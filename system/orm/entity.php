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

    protected $map = array();
    protected $data = array();
    protected $dataChanged = array();
    protected $state = self::STATE_NEW;

    protected $module = null;

    public function module()
    {
        if (empty($this->module)) {
            $class = new ReflectionClass(get_class($this));
            $path = $class->getFileName();

            $path = pathinfo($path, PATHINFO_DIRNAME);
            $this->module = substr($path, strrpos($path, DIRECTORY_SEPARATOR) + 1);
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
        return $this->dataChanged;
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
                    $result = $this->data[$field]->load($args);
                    if ($this->hasOption($field, 'nocache')) {
                        return $result;
                    }
                    $this->data[$field] = $result;
                }

                return $this->data[$field];
            } else {
                if ($this->hasOption($field, 'ro')) {
                    throw new mzzRuntimeException(get_class($this) . '::' . $name . '() is declared as read only');
                }

                if ($this->hasOption($field, 'once') && isset($this->data[$field]) && !is_null($this->data[$field])) {
                    throw new mzzRuntimeException(get_class($this) . '::' . $name . '() is declared as setted once');
                }

                if ($this->state() == self::STATE_NEW && $this->hasOption($field, 'one-to-one-back')) {
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
            throw new mzzORMNotExistMethodException($this, $name);
        }
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
        // strtolower used here to dispose stupid php strtolower when parent::<method> through __call
        $name = strtolower($name);

        foreach ($this->map as $key => $value) {
            if (strtolower($value['accessor']) == $name) {
                return array(
                    'accessor',
                    $key);
            }
            if (isset($value['mutator']) && strtolower($value['mutator']) == $name) {
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