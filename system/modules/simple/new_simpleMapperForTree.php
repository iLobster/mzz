<?php

fileLoader::load('db/new_dbTreeNS');
fileLoader::load('simple/new_simpleForTree');

abstract class new_simpleMapperForTree extends simpleMapper
{
    /*protected $tree_table;
    protected $tree_join_field;
    protected $tree_name_field;
    protected $tree_path_field;
    protected $tree;*/
    protected $treeTmp = array();
    protected $treeParams = array();

    public function __construct($section)
    {
        parent::__construct($section);
        $this->treeParams = $this->getTreeParams();
        $this->tree = new new_dbTreeNS($this->treeParams, $this);
    }

    protected function getTreeParams()
    {
        return array('nameField' => 'name', 'pathField' => 'path', 'joinField' => 'parent', 'tableName' => $this->table . '_tree');
    }


    protected function searchByCriteria(criteria $criteria)
    {
        $this->tree->addSelect($criteria);
        $this->tree->addJoin($criteria);
        return parent::searchByCriteria($criteria);
    }

    public function getBranch($target, $level = 0)
    {
        $criteria = new criteria();
        $this->tree->addSelect($criteria);
        $this->tree->addJoin($criteria);
        $this->tree->getBranch($criteria, $target->getTreeKey());

        $stmt = parent::searchByCriteria($criteria);

        $result = array();

        while ($row = $stmt->fetch()) {
            $data = $this->fillArray($row);
            $result[$data[$this->tableKey]] = $this->createItemFromRow($data);
        }

        return $result;
    }

    public function getTreeParent($child)
    {
        $criteria = new criteria();
        $this->tree->addSelect($criteria);
        $this->tree->addJoin($criteria);
        $this->tree->getParentNode($criteria, $child->getTreeKey());

        $stmt = parent::searchByCriteria($criteria);

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

        $mutator = $this->map[$this->treeParams['joinField']]['mutator'];
        $accessor = $this->map[$this->treeParams['joinField']]['accessor'];

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

        if (isset($data[$this->treeParams['nameField']])) {
            $branch = $this->getBranch($object, 1);

            $pathAccessor = $this->map[$this->treeParams['pathField']]['accessor'];
            $pathMutator = $this->map[$this->treeParams['pathField']]['mutator'];
            $nameAccessor = $this->map[$this->treeParams['nameField']]['accessor'];
            $nameMutator = $this->map[$this->treeParams['nameField']]['mutator'];

            $baseName = $target->$pathAccessor() . '/' . $object->$nameAccessor();
            $object->$pathMutator($baseName);
            $this->save($object);

            foreach ($branch as $key => $val) {
                if ($val->getTreeKey() != $object->getTreeKey()) {
                    $val->$nameMutator($val->$nameAccessor());
                    $this->save($val);
                }
            }
        }
    }

    public function move(new_simpleForTree $node, new_simpleForTree $target)
    {
        $result = $this->tree->move($node, $target);

        if ($result) {
            $nameAccessor = $this->map[$this->treeParams['nameField']]['accessor'];
            $nameMutator = $this->map[$this->treeParams['nameField']]['mutator'];
            $node->$nameMutator($node->$nameAccessor());

            $this->save($node);
        }

        return $result;
    }

    public function delete(new_simpleForTree $id)
    {
        $branch = $this->getBranch($id);
        foreach ($branch as $do) {
            parent::delete($do);
        }
        $this->tree->delete($id);
    }

    /*

    public function save($object, $target = null, $user = null)
    {
    static $i=0;
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
    if ($val->getTreeKey() != $object->getTreeKey()) {
    $val->$nameMutator($val->$nameAccessor());
    $this->save($val);
    }
    }
    }

    return $result;
    }

    protected function getStdCriteria($criteria_outer = null)
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

    // если были указаны критерии без явной установки имени таблицы - заменяем их на аналогичные с именами таблиц
    foreach ($criteria->getCriterion() as $key => $condition) {
    $field = $condition->getField();
    if (!strpos($field, '.') && !$condition->getAlias()) {
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

    // добавляем таблицу с деревом
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

    public function move(new_simpleForTree $node, new_simpleForTree $target)
    {
    $result = $this->tree->move($node, $target);

    if ($result) {
    $nameAccessor = $this->map[$this->tree_name_field]['accessor'];
    $nameMutator = $this->map[$this->tree_name_field]['mutator'];
    $node->$nameMutator($node->$nameAccessor());

    $this->save($node);
    }

    return $result;
    }

    public function loadTreeData(new_simpleForTree $object)
    {
    $accessor = $this->map[$this->tree_join_field]['accessor'];
    $id = $object->$accessor();
    $node = $this->tree->getNodeInfo($id);
    $object->importTreeFields($node);
    }

    public function searchByPath($path)
    {
    return $this->searchOneByField($this->tree_path_field, $path);
    }
    */
    /**
     * Заполняет данными из массива доменный объект
     *
     * @param array $row массив с данными
     * @return object
     */
    public function createItemFromRow($row)
    {
        $object = $this->create();
        $object->import($row);
        $object->importTreeFields($this->treeTmp);
        $this->treeTmp = null;
        return $object;
    }

    public function fillArray(&$array, $name = null)
    {
        $this->treeTmp = parent::fillArray($array, 'tree');
        return parent::fillArray($array, $name);
    }
}

?>