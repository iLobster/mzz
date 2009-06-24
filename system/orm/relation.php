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
 * relation: the class, that controls relations and it's descriptions in orm
 *
 * @package system
 * @subpackage orm
 * @version 0.1
 */
class relation
{
    private $map;
    private $table;
    private $mapper;
    private $relations = array();

    public function __construct($mapper)
    {
        $this->table = $mapper->table();
        $this->map = $mapper->map();
        $this->mapper = $mapper;
    }

    public function oneToOne()
    {
        if (!isset($this->relations['oneToOne'])) {
            $this->relations['oneToOne'] = array();
            $this->relations['oneToOneBack'] = array();
            foreach ($this->map as $key => $val) {
                if (isset($val['relation']) && $val['relation'] == 'one') {
                    $tmp = array(
                        'foreign_key' => $val['foreign_key']);

                    if (!isset($val['join_type'])) {
                        $val['join_type'] = null;
                    }

                    $tmp['join_type'] = $val['join_type'];

                    $this->loadMapperClass($val['mapper']);

                    $tmp['mapper'] = new $val['mapper']();
                    $map = $tmp['mapper']->map();
                    $tmp['methods'] = array(
                        $map[$val['foreign_key']]['accessor'],
                        $map[$val['foreign_key']]['mutator']);

                    $type = 'oneToOne';
                    if (isset($val['local_key']) && $val['local_key'] != $key) {
                        unset($val['join_type']);
                        $tmp['local_key'] = $val['local_key'];
                        $type .= 'Back';
                    }

                    $this->relations[$type][$key] = $tmp;
                }
            }
        }

        return $this->relations['oneToOne'];
    }

    public function oneToOneBack()
    {
        if (!isset($this->relations['oneToOneBack'])) {
            $this->oneToOne();
        }

        return $this->relations['oneToOneBack'];
    }

    public function oneToMany()
    {
        if (!isset($this->relations['oneToMany'])) {
            $this->relations['oneToMany'] = array();
            foreach ($this->map as $key => $val) {
                if (isset($val['relation']) && $val['relation'] == 'many') {
                    $tmp = array(
                        'foreign_key' => $val['foreign_key'],
                        'local_key' => $val['local_key']);

                    $this->loadMapperClass($val['mapper']);

                    $tmp['mapper'] = new $val['mapper']();
                    $this->relations['oneToMany'][$key] = $tmp;
                }
            }
        }

        return $this->relations['oneToMany'];
    }

    public function manyToMany()
    {
        if (!isset($this->relations['manyToMany'])) {
            $this->relations['manyToMany'] = array();
            foreach ($this->map as $key => $val) {
                if (isset($val['relation']) && $val['relation'] == 'many-to-many') {
                    $tmp = array(
                        'foreign_key' => $val['foreign_key'],
                        'local_key' => $val['local_key'],
                        'ref_foreign_key' => $val['ref_foreign_key'],
                        'ref_local_key' => $val['ref_local_key'],
                        'reference' => $val['reference']);

                    $this->loadMapperClass($val['mapper']);

                    $tmp['mapper'] = new $val['mapper']();
                    $this->relations['manyToMany'][$key] = $tmp;
                }
            }
        }

        return $this->relations['manyToMany'];
    }

    private function loadMapperClass(& $mapperName)
    {
        if (!class_exists($mapperName)) {
            if (strpos($mapperName, '/') === false) {
                throw new mzzRuntimeException('Module and mapper name should be specified');
            }

            list ($module, $mapper) = explode('/', $mapperName);
            fileLoader::load($module . '/mappers/' . $mapper);
            $mapperName = $mapper;
        }
    }

    public function addLazy(entity $object)
    {
        $row = $object->export();

        foreach ($this->oneToOne() as $key => $val) {
            if (is_scalar($row[$key])) {
                $lazy = new lazy(array(
                    $val['mapper'],
                    $val['foreign_key'],
                    $row[$key],
                    true));
                $row[$key] = $lazy;
            }
        }

        foreach ($this->oneToOneBack() as $key => $val) {
            $lazy = new lazy(array(
                $val['mapper'],
                $val['foreign_key'],
                $row[$val['local_key']],
                true));
            $row[$key] = $lazy;
        }

        foreach ($this->oneToMany() as $key => $val) {
            $lazy = new lazy(array(
                $val['mapper'],
                $val['foreign_key'],
                $row[$val['local_key']]));
            $row[$key] = $lazy;
        }

        foreach ($this->manyToMany() as $key => $val) {
            $lazy = new lazy(array(
                $val['mapper'],
                $val['ref_local_key'],
                $row[$val['local_key']],
                $val['ref_foreign_key'],
                $val['foreign_key'],
                $val['reference']));
            $row[$key] = $lazy;
        }

        $object->import($row);
    }

    public function retrieve(& $data)
    {
        foreach ($this->oneToOne() + $this->oneToOneBack() as $key => $val) {
            $object = $val['mapper']->createItemFromRow($data[$key]);
            $data[$this->table][$key] = $object;
        }
    }

    public function add(criteria $criteria)
    {
        foreach ($this->oneToOne() + $this->oneToOneBack() as $key => $val) {
            if (!isset($val['local_key'])) {
                $val['local_key'] = $key;
            }

            $this->mapper->addSelectFields($criteria, $val['mapper'], $key);

            $joinType = isset($val['join_type']) && $val['join_type'] == 'inner' ? criteria::JOIN_INNER : criteria::JOIN_LEFT;

            $criterion = new criterion($this->mapper->getClass() . '.' . $val['local_key'], $key . '.' . $val['foreign_key'], criteria::EQUAL, true);
            $criteria->addJoin($val['mapper']->table(), $criterion, $key, $joinType);

            $data = array(
                $criteria,
                $key);
            $val['mapper']->notify('preSqlJoin', $data);
        }
    }

    public function delete($object)
    {
        foreach ($this->manyToMany() as $val) {
            $map = $val['mapper']->map();
            $accessor = $map[$val['local_key']]['accessor'];

            $criteria = new criteria($val['reference']);
            $criteria->add($val['ref_local_key'], $object->$accessor());
            $delete = new simpleDelete($criteria);
            $val['mapper']->db()->query($delete->toString());
        }
    }
}

?>