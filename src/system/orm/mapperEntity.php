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
 * mapperEntity
 *
 * @todo переименовать в просто entity
 */
class mapperEntity
{
    protected $mapper;
    protected $methodsMap = null;

    protected $data = array();

    public function __construct(abstractMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function import(Array $data)
    {
        $this->data = $data;
    }

    public function export()
    {
        return $this->data;
    }

    public function merge($data)
    {
        $map = $this->mapper->getMap();
        foreach ($data as $key => $val) {
            if (isset($map[$key])) {
                $this->data[$key] = $val;
            }
        }
    }

    public function __call($name, $args)
    {
        if ($attr = $this->validateMethod($name)) {
            list($method_type, $field) = $attr;

            if ($method_type == 'accessor') {
                if (!array_key_exists($field, $this->data)) {
                    $this->data[$field] = null;
                }

                return $this->data[$field];
            } else {
                if (!sizeof($args)) {
                    throw new mzzRuntimeException(get_class($this) . '::' . $name . '() invocation expects one argument');
                }

                $this->data[$field] = $args[0];

                if ($this->state() != self::STATE_NEW) {
                    $this->state(self::STATE_DIRTY);
                }
            }
        } else {
            throw new mzzORMNotExistMethodException($this, $name);
        }
    }

    protected function validateMethod($name)
    {
        if (is_null($this->methodsMap)) {
            $methodsMap = array();
            foreach ($this->mapper->getMap() as $field => $data) {
                if (isset($data['accessor'])) {
                    $methodsMap[strtolower($data['accessor'])] = array('accessor', $field);
                }

                if (isset($data['mutator'])) {
                    $methodsMap[strtolower($data['mutator'])] = array('mutator', $field);
                }
            }

            $this->methodsMap = $methodsMap;
        }

        // strtolower used here to dispose stupid php strtolower when parent::<method> through __call
        $name = strtolower($name);

        if (isset($this->methodsMap[$name])) {
            return $this->methodsMap[$name];
        }

        return null;
    }
}
?>