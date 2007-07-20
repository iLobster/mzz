<?php

fileLoader::load('db/new_dbTreeNS');
fileLoader::load('simple/new_simpleForTree');

abstract class new_simpleMapperForTree extends simpleMapper
{
    protected $tree_table;
    protected $tree_join_field;
    protected $tree_name_field;
    protected $tree_path_field;
    protected $tree;
    protected $treeTmp;

    public function __construct($section)
    {
        $this->tree_name_field = 'name';
        $this->tree_path_field = 'path';
        parent::__construct($section);
        if (!$this->tree_table) {
            $this->tree_table = $this->table . '_tree';
        }

        $this->tree = new new_dbTreeNS($this->tree_table);
        $this->tree_join_field = 'some_id';
    }

    protected function searchByCriteria(criteria $criteria_outer)
    {
        $criteria = $this->getStdCriteria($criteria_outer);

        $stmt = $this->tree->getTree();

        return $stmt;
    }

    private function getStdCriteria($criteria_outer = null)
    {
        $criteria = new criteria();
        $this->addJoins($criteria);

        if ($criteria_outer) {
            $criteria->append($criteria_outer);
        }

        // если есть пейджер - то посчитать записи без LIMIT и передать найденное число записей в пейджер
        if ($this->pager) {
            $this->count($criteria);
        }

        $this->addOrderBy($criteria);

        // если были указаны критерии без €вной установки иммени таблицы - замен€ем их на аналогичные с именами таблиц
        foreach ($criteria->getCriterion() as $key => $condition) {
            $field = $condition->getField();
            if (!strpos($field, '.')) {
                $criteria->remove($key);
                $criterion = new criterion($this->className . '.' . $field, $condition->getValue(), $condition->getComparsion());

                $clauses = $condition->getClauses();
                foreach ($clauses[0] as $clause_key => $clause) {
                    if ($clause) {
                        $clause_field = $clause->getField();
                        if (!strpos($clause_field, '.')) {
                            $clause_field = $this->className . '.' . $clause_field;
                        }
                        if ($clauses[1][$clause_key] == 'OR') {
                            $criterion->addOr(new criterion($clause_field, $clause->getValue(), $clause->getComparsion()));
                        } else {
                            $criterion->addAnd(new criterion($clause_field, $clause->getValue(), $clause->getComparsion()));
                        }
                    }
                }
                $criteria->add($criterion);
            }
        }

        // добавл€ем таблицу с деревом
        $criteria->addJoin($this->table, new criterion($this->className . '.' . $this->tree_join_field, 'tree.id', criteria::EQUAL, true), $this->className);
        $this->tree->appendCriteria($criteria);

        return $criteria;
    }

    public function getBranch($target, $level = 0)
    {
        $criteria = $this->getStdCriteria();
        $stmt = $this->tree->getBranch($target->getTreeKey());

        $result = array();

        while ($row = $stmt->fetch()) {
            $data = $this->fillArray($row);
            $result[$data[$this->tableKey]] = $this->createItemFromRow($data);
        }

        return $result;
    }

    public function getTreeParent($child)
    {
        $criteria = $this->getStdCriteria();
        $stmt = $this->tree->getParentNode($child->getTreeKey());

        if ($row = $stmt->fetch()) {
            $row = $this->fillArray($row);
            $parent = $this->createItemFromRow($row);

            return $parent;
        }

        return null;
    }

    public function save($object, $target = null, $user = null)
    {
        $data = $object->export();

        $mutator = $this->map[$this->tree_join_field]['mutator'];
        $accessor = $this->map[$this->tree_join_field]['accessor'];

        if (!$object->getId()) {
            $node = $this->tree->getNodeInfo($target);
            $id = $this->tree->insert($node['id']);
            $object->$mutator($id);

        } else {
            $target = $this->getTreeParent($object);
        }

        $result = parent::save($object, $user);

        $node = $this->tree->getNodeInfo($object->$accessor());

        $object->importTreeFields($node);

        if (isset($data[$this->tree_name_field])) {
            $branch = $this->getBranch($object, 1);

            $pathAccessor = $this->map[$this->tree_path_field]['accessor'];
            $pathMutator = $this->map[$this->tree_path_field]['mutator'];
            $nameAccessor = $this->map[$this->tree_name_field]['accessor'];
            $nameMutator = $this->map[$this->tree_name_field]['mutator'];

            $baseName = $target->$pathAccessor() . '/' . $object->$nameAccessor();
            $object->$pathMutator($baseName);
            $this->save($object);

            foreach ($branch as $key => $val) {
                if ($key != $object->getTreeKey()) {
                    $val->$nameMutator($val->$nameAccessor());
                    $this->save($val);
                }
            }
        }

        return $result;
    }

    /**
     * «аполн€ет данными из массива доменный объект
     *
     * @param array $row массив с данными
     * @return object
     */
    public function createItemFromRow($row)
    {
        $object = $this->create();
        $object->import($row);
        $object->importTreeFields($this->treeTmp);
        return $object;
    }

    public function fillArray(&$array, $name = null)
    {
        $this->treeTmp = parent::fillArray($array, 'tree');
        return parent::fillArray($array, $name);
    }

}

?>