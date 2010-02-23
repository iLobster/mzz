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
class entity implements serializable
{
    const STATE_DIRTY = 1;
    const STATE_CLEAN = 2;
    const STATE_NEW = 3;

    /**
     * @var mapper
     */
    protected $mapper;
    protected $methodsMap = array();

    protected $data = array();
    protected $dataChanged = array();
    protected $state = self::STATE_NEW;

    public function __construct(mapper $mapper)
    {
        $this->mapper = $mapper;
        $this->methodsMap = $this->generateMethodsMap($mapper->map());
    }

    public function module()
    {
        return $this->mapper->getModule();
    }

    public function import($data)
    {
        $this->data = $data;
    }

    public function merge($data)
    {
        $map = $this->mapper->map();
        foreach ($data as $key => $val) {
            if (isset($map[$key])) {
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

    private function isLazy($field)
    {
        if ($this->data[$field] instanceof lazy) {
            return true;
        }

        if (is_object($this->data[$field])) {
            return false;
        }

        $map = $this->mapper->map();
        if (!empty($map[$field]['relation'])) {
            if ($map[$field]['relation'] == 'one' && (!isset($map[$field]['join_type']) || ($map[$field]['join_type'] == 'left')) && is_null($this->data[$field])) {
                return false;
            }
            return true;
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

                if ($this->isLazy($field)) {
                    $result = $this->mapper->load($field, $this->data, $args);
                    if ($this->mapper->hasOption($field, 'nocache')) {
                        return $result;
                    }
                    $this->data[$field] = $result;
                }

                return $this->data[$field];
            } else {
                if ($this->mapper->hasOption($field, 'ro')) {
                    throw new mzzRuntimeException(get_class($this) . '::' . $name . '() is declared as read only');
                }

                if ($this->mapper->hasOption($field, 'once') && isset($this->data[$field]) && !is_null($this->data[$field])) {
                    throw new mzzRuntimeException(get_class($this) . '::' . $name . '() is declared as setted once');
                }

                if ($this->state() == self::STATE_NEW && $this->mapper->hasOption($field, 'one-to-one-back')) {
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

    private function validateMethod($name)
    {
        // strtolower used here to dispose stupid php strtolower when parent::<method> through __call
        $name = strtolower($name);

        if (isset($this->methodsMap[$name])) {
            return $this->methodsMap[$name];
        }
    }

    private function generateMethodsMap(Array $map)
    {
        $methodsMap = array();
        foreach ($map as $field => $data) {
            if (isset($data['accessor'])) {
                $methodsMap[strtolower($data['accessor'])] = array('accessor', $field);
            }

            if (isset($data['mutator'])) {
                $methodsMap[strtolower($data['mutator'])] = array('mutator', $field);
            }
        }

        return $methodsMap;
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

    public function canRun($actionName)
    {
        $action = systemToolkit::getInstance()->getModule($this->module())->getAction($actionName);

        if (is_a($this, 'iACL')) {
            $action->setObject($this);
        }

        return $action->canRun();
    }

    protected function serializableProperties()
    {
        return array(
            'data',
            'dataChanged',
            'state');
    }

    public function serialize()
    {
        $this->mapper->notify('preSerialize', $this);

        $serializable = $this->serializableProperties();
        $vars = array_intersect_key(get_object_vars($this), array_flip($serializable));
        $vars['module'] = $this->mapper->getModule();
        
        foreach ($this->data as $k => $v) {
            if ($v instanceof lazy) {
                $vars['data'][$k] = $v->load();
                unset($vars['data'][$k]);
            } elseif (is_object($v)) {
                $vars['data'][$k] = serialize($v);
            }
        }

        foreach ($this->dataChanged as $k => $v) {
            if ($v instanceof lazy) {
                $vars['dataChanged'][$k] = $v->load();
            } elseif (is_object($v)) {
                $vars['dataChanged'][$k] = serialize($v);
            }
        }

        return serialize($vars);
    }

    public function unserialize($data)
    {
        $array = unserialize($data);

        $module = $array['module'];
        unset($array['module']);

        $mapper = systemToolkit::getInstance()->getMapper($module, get_class($this));
        $map = $mapper->map();
        
        foreach ($array as $k => $v) {
            if ($k == 'data' || $k == 'dataChanged') {
                foreach ($v as $field => $value) {
                    if (isset($map[$field]['relation']) && !$mapper->hasOption($field, 'lazy')) {
                        $this->{$k}[$field] = unserialize($value);
                    } else {
                        $this->{$k}[$field] = $value;
                    }
                }
            } else {
                $this->{$k} = $v;
            }
        }
        
        $this->__construct($mapper);

        $mapper->notify('preUnserialize', $this);
        $mapper->notify('preCreate', $this);
        $mapper->notify('postCreate', $this);
    }
}

?>