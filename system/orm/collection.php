<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/branches/orm/system/mapper.php $
 *
 * MZZ Content Management System (c) 2005-2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: mapper.php 2928 2009-01-14 05:53:47Z zerkms $
 */

/**
 * collection: collection container for orm
 *
 * @package system
 * @subpackage orm
 * @version 0.1
 */
class collection extends arrayDataspace implements Serializable
{
    private $deleted = array();
    private $inserted = array();
    private $modified = false;
    private $mapper;
    private $local_key;
    private $local_accessor;

    private $local_mutator;
    private $foreign_value;
    private $name;

    private $foreign_field_name;
    private $local_field_name;
    private $criteria;

    public function __construct(array $data, mapper $mapper)
    {
        parent::__construct($data);
        $this->mapper = $mapper;
        $this->local_key = $mapper->pk();
        $map = $mapper->map();
        $this->local_accessor = $map[$this->local_key]['accessor'];
    }

    public function setParams($name, $value)
    {
        $this->name = $name;
        $map = $this->mapper->map();
        $this->local_mutator = $map[$name]['mutator'];
        $this->foreign_value = $value;
    }

    public function setMtoMParams($value, $foreign_field_name, $local_field_name, criteria $criteria)
    {
        $this->foreign_field_name = $foreign_field_name;
        $this->local_field_name = $local_field_name;
        $this->criteria = $criteria;
        $this->foreign_value = $value;

        $this->criteria->where($this->foreign_field_name, $value);
    }

    public function delete($key)
    {
        $this->modified = true;

        if ($this->exists($key)) {
            $this->deleted[] = $key;
        }
    }

    public function get($key)
    {
        if (!in_array($key, $this->deleted)) {
            return parent::get($key);
        }
    }

    public function set($key, $value)
    {
        throw new mzzRuntimeException('For object to collection adding you should use collection::add() method instead');
    }

    public function add($value)
    {
        $this->modified = true;
        $this->inserted[] = $value;
    }

    public function keys()
    {
        return array_keys($this->data);
    }

    public function next()
    {
        do {
            $result = parent::next();
        } while (in_array($this->key(), $this->deleted));

        return $result;
    }

    public function isModified()
    {
        return $this->modified;
    }

    public function save()
    {
        $this->modified = false;

        foreach ($this as $val) {
            $this->mapper->save($val);
        }

        foreach ($this->deleted as $key) {
            $this->deleteKey($key);
            parent::delete($key);
        }

        $this->deleted = array();

        foreach ($this->inserted as $val) {
            $this->insertKey($val);
            parent::set($val->{$this->local_accessor}(), $val);
        }

        $this->inserted = array();
    }

    public function toArray()
    {
        return $this->data;
    }

    private function deleteKey($key)
    {
        if ($this->criteria) {
            $criteria = clone $this->criteria;
            $criteria->where($this->local_field_name, $key);
            $delete = new simpleDelete($criteria);

            $this->mapper->db()->query($delete->toString());

            return;
        }

        $this->mapper->delete($this->data[$key]);
    }

    private function insertKey($val)
    {
        if ($this->criteria) {
            $criteria = clone $this->criteria;

            $insert = new simpleInsert($criteria);
            $this->mapper->db()->query($insert->toString(array(
                $this->foreign_field_name => $this->foreign_value,
                $this->local_field_name => $val->{$this->local_accessor}())));
            return;
        }

        $val->{$this->local_mutator}($this->foreign_value);
        $this->mapper->save($val);
    }

    protected function serializableProperties()
    {
        return array('data', 'current', 'deleted', 'inserted', 'modified', 'local_key', 'local_accessor', 'local_mutator', 'foreign_value', 'name', 'foreign_field_name', 'local_field_name', 'criteria');
    }

    public function serialize()
    {
        $serializable = $this->serializableProperties();
        $vars = array_intersect_key(get_object_vars($this), array_flip($serializable));

        $vars['mapper']['module'] = $this->mapper->getModule();
        $vars['mapper']['class'] = $this->mapper->getClass();

        return serialize($vars);
    }

    public function unserialize($data)
    {
        $array = unserialize($data);

        $this->mapper = systemToolkit::getInstance()->getMapper($array['mapper']['module'], $array['mapper']['class']);
        unset($array['mapper']);

        foreach($array as $k => $v) {
            $this->$k = $v;
        }
    }
}

?>