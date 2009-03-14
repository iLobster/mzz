<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * entity: implementation of a domain object for the Data Mapper pattern
 *
 * @package system
 * @subpackage orm
 * @version 0.2
 */
class entity
{
    const STATE_DIRTY = 1;
    const STATE_CLEAN = 2;
    const STATE_NEW = 3;

    private $map = array();
    private $data = array();
    private $dataChanged = array();
    private $state = self::STATE_NEW;
    /**
     * relations object
     *
     * @var relation
     */
    private $relations;
    protected $module = null;

    public function relations($relations)
    {
        $this->relations = $relations;
    }

    public function module()
    {
        if (empty($this->module)) {
            $class = new ReflectionClass(get_class($this));
            $path = $class->getFileName();
            $this->module = substr($path, strrpos($path, DIRECTORY_SEPARATOR) + 1, -4);
        }
        return $this->module;
    }

    public function setMap($map)
    {
        $this->map = $map;
    }

    public function getMap()
    {
        return $this->map;
    }

    public function import($data)
    {
        $this->data = $data;
    }

    public function merge($data)
    {
        foreach ($data as $key => $val) {
            if (isset($this->map[$key])) {
                $this->data[$key] = $val;
            }
        }
    }

    public function export()
    {
        return $this->data;
    }

    public function exportChanged()
    {
        $this->replaceRelated();
        return $this->dataChanged;
    }

    public function replaceRelated()
    {
        if ($this->relations) {
            $oneToOne = $this->relations->oneToOne();

            // traverse all one-to-one related fields and if changed - replace them with scalar foreign_key values
            foreach ($oneToOne as $key => $value) {
                if (isset($this->data[$key]) && $this->data[$key] instanceof entity) {
                    // recursive call to replace related objects with scalar
                    $this->data[$key]->replaceRelated();
                    // if nested related objects are not clean - mark current object as dirty and save related
                    if ($this->data[$key]->state() != self::STATE_CLEAN) {
                        $this->state(self::STATE_DIRTY);
                        $value['mapper']->save($this->data[$key]);
                        $this->dataChanged[$key] = $this->data[$key];
                    }
                }

                // if changed related field is not scalar - replace it with scalar
                if (isset($this->dataChanged[$key]) && $this->dataChanged[$key] instanceof entity) {
                    // if changed related field is not clean too - save it
                    if ($this->dataChanged[$key]->state() != self::STATE_CLEAN) {
                        $value['mapper']->save($this->dataChanged[$key]);
                    }
                    $accessor = $value['methods'][0];
                    $this->dataChanged[$key] = $this->dataChanged[$key]->$accessor();
                }
            }

            if ($this->state() != self::STATE_NEW) {
                foreach ($this->relations->oneToOneBack() as $key => $value) {
                    if (isset($this->dataChanged[$key])) {
                        $accessor = $value['methods'][0];
                        $mutator = $value['methods'][1];

                        if ($this->dataChanged[$key]->$accessor() != $this->data[$value['local_key']]) {
                            $this->dataChanged[$key]->$mutator($this->data[$value['local_key']]);
                            $value['mapper']->save($this->dataChanged[$key]);
                            $this->data[$key] = $this->dataChanged[$key];
                            unset($this->dataChanged[$key]);
                        }
                    }
                }
            }

            $oneToMany = $this->relations->oneToMany();
            foreach ($oneToMany as $key => $value) {
                if (isset($this->data[$key]) && $this->data[$key] instanceof collection) {
                    $this->data[$key]->save();
                }
            }

            $manyToMany = $this->relations->manyToMany();
            foreach ($manyToMany as $key => $value) {
                if (isset($this->data[$key]) && $this->data[$key] instanceof collection) {
                    $this->data[$key]->save();
                }
            }
        }
    }

    public function __call($name, $args)
    {
        if ($attr = $this->validateMethod($name)) {
            list ($method, $field) = $attr;

            if ($method == 'accessor') {
                if (!array_key_exists($field, $this->data)) {
                    $this->data[$field] = null;
                }

                if ($this->data[$field] instanceof lazy) {
                    $this->data[$field] = $this->data[$field]->load($args);
                }

                return $this->data[$field];
            } else {
                if ($this->hasOption($field, 'ro')) {
                    throw new mzzRuntimeException(get_class($this) . '::' . $name . '() is declared as read only');
                }

                if ($this->hasOption($field, 'once') && isset($this->data[$field]) && !is_null($this->data[$field])) {
                    throw new mzzRuntimeException(get_class($this) . '::' . $name . '() is declared as setted once');
                }

                if ($this->state() == self::STATE_NEW && in_array($field, $this->getOneToOneBackKeys())) {
                    throw new mzzRuntimeException(get_class($this) . '::' . $name . '() cannot be specified during object creation');
                }

                if (!sizeof($args)) {
                    throw new mzzRuntimeException(get_class($this) . '::' . $name . '() invocation expects one argument');
                }

                $this->dataChanged[$field] = $args[0];

                if ($this->state() != self::STATE_NEW) {
                    $this->state(self::STATE_DIRTY);
                }
            }
        } else {
            throw new mzzRuntimeException('Unknown method was invoked: ' . get_class($this) . '::' . $name . '()');
        }
    }

    private function getOneToOneBackKeys()
    {
        static $keys = null;

        if (!$keys) {
            $keys = $this->relations ? array_keys($this->relations->oneToOneBack()) : array();
        }

        return $keys;
    }

    public function state($state = null)
    {
        if (!is_null($state)) {
            // if object became clean or new - reset the dataChanged array
            if ($state != self::STATE_DIRTY) {
                $this->dataChanged = array();
            }

            $old = $this->state;
            $this->state = $state;
            return $old;
        }
        return $this->state;
    }

    private function validateMethod($name)
    {
        foreach ($this->map as $key => $value) {
            if ($value['accessor'] == $name) {
                return array(
                    'accessor',
                    $key);
            }
            if (isset($value['mutator']) && $value['mutator'] == $name) {
                return array(
                    'mutator',
                    $key);
            }
        }
    }

    private function hasOption($field, $name)
    {
        return isset($this->map[$field]['options']) && in_array($name, $this->map[$field]['options']);
    }
}

?>