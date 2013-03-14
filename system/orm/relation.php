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
    private $relations;
    private $mapper;

    public function __construct($mapper)
    {
        $this->mapper = $mapper;
        $this->table = $mapper->table(false);
        $this->map = $mapper->map();

        $this->markOneToBack($mapper);
    }

    private function markOneToBack($mapper)
    {
        //$changed = false;

        foreach (array_keys($this->oneToOneBack()) as $key) {
            if (!isset($this->map[$key]['options'])) {
                $this->map[$key]['options'] = array();
            }

            $this->map[$key]['options'][] = 'one-to-one-back';

            //$changed = true;
        }

        /* if ($changed) {
          $mapper->map($this->map);
          } */
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

                    $tmp['mapper'] = $this->loadMapperClass($val['mapper']);

                    $tmp['options'] = isset($val['options']) ? $val['options'] : array();

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

                    $tmp['mapper'] = $this->loadMapperClass($val['mapper']);

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

                    $tmp['mapper'] = $this->loadMapperClass($val['mapper']);

                    $this->relations['manyToMany'][$key] = $tmp;
                }
            }
        }

        return $this->relations['manyToMany'];
    }

    private function loadMapperClass($mapperName)
    {
        if (strpos($mapperName, '/') === false) {
            throw new mzzRuntimeException('Module and mapper name should be specified');
        }

        list ($module, $do) = explode('/', $mapperName);
        return ($module === $this->mapper->getModule() && $do === $this->mapper->getClass()) ? $this->mapper : systemToolkit::getInstance()->getMapper($module, $do);
    }

    public function load($field, $data, $mapper)
    {
        $info = $this->map[$field];

        if ($info['relation'] == 'one') {
            $back = $this->oneToOneBack();
            if (isset($back[$field])) {
                $infoRel = $back[$field];
                return $infoRel['mapper']->searchOneByField($infoRel['foreign_key'], $data[$infoRel['local_key']]);
            } else {
                $infoRel = $this->oneToOne();
                $infoRel = $infoRel[$field];

                return $infoRel['mapper']->searchOneByField($infoRel['foreign_key'], $data[$field]);
            }
        } elseif ($info['relation'] == 'many') {
            $infoRel = $this->oneToMany();
            $infoRel = $infoRel[$field];

            if (!isset($info['local_key'])) {
                throw new mzzRuntimeException('local_key not specified');
            }
            $local_value = isset($data[$info['local_key']]) ? $data[$info['local_key']] : null;

            $collection = $infoRel['mapper']->searchAllByField($infoRel['foreign_key'], $local_value);
            $collection->setParams($infoRel['foreign_key'], $local_value);

            return $collection;
        } elseif ($info['relation'] == 'many-to-many') {
            $infoRel = $this->manyToMany();
            $infoRel = $infoRel[$field];

            if (!isset($info['local_key'])) {
                throw new mzzRuntimeException('local_key not specified');
            }
            $local_value = isset($data[$info['local_key']]) ? $data[$info['local_key']] : null;

            $criterion = new criterion('reference.' . $info['ref_foreign_key'], $infoRel['mapper']->table(false) . '.' . $info['foreign_key'], criteria::EQUAL, true);
            $criterion->addAnd(new criterion('reference.' . $info['ref_local_key'], $local_value));

            $criteria = new criteria();
            $criteria->join($mapper->db()->getTablePrefix() . $info['reference'], $criterion, 'reference', criteria::JOIN_INNER);

            $collection = $infoRel['mapper']->searchAllByCriteria($criteria);

            $modifyCriteria = new criteria($mapper->db()->getTablePrefix() . $info['reference']);
            $collection->setMtoMParams($local_value, $info['ref_local_key'], $info['ref_foreign_key'], $modifyCriteria);

            return $collection;
        }
    }

    private function oneToOneLazy($val, $value)
    {
        throw new Exception('deprecated');
        return new lazy(array(
            $val['mapper'],
            $val['foreign_key'],
            $value,
            true));
    }

    public function retrieve(& $data)
    {
        foreach ($this->oneToOne() + $this->oneToOneBack() as $key => $val) {
            if (!$this->isLazy($val)) {
                $object = $val['mapper']->createItemFromRow($data[$key]);
                $data[$this->table][$key] = $object;
            }
        }
    }

    private function isLazy($val)
    {
        return isset($val['options']) && in_array('lazy', $val['options']);
    }

    public function add(criteria $criteria, $mapper)
    {
        foreach ($this->oneToOne() + $this->oneToOneBack() as $key => $val) {
            if (!isset($val['local_key'])) {
                $val['local_key'] = $key;
            }

            if ($this->isLazy($val)) {
                continue;
            }

            $mapper->addSelectFields($criteria, $val['mapper'], $key);

            $joinType = isset($val['join_type']) && $val['join_type'] == 'inner' ? criteria::JOIN_INNER : criteria::JOIN_LEFT;

            $criterion = new criterion($this->table . '.' . $val['local_key'], $key . '.' . $val['foreign_key'], criteria::EQUAL, true);
            $criteria->join($val['mapper']->table(), $criterion, $key, $joinType);

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
            $accessor = $this->map[$val['local_key']]['accessor'];
			
            $criteria = new criteria($val['mapper']->db()->getTablePrefix() . $val['reference']);
            $criteria->where($val['ref_foreign_key'], $object->$accessor());
            $delete = new simpleDelete($criteria);
            $val['mapper']->db()->query($delete->toString());
        }
    }

}
?>