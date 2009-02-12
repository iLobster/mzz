<?php

class tree_mpPlugin extends observer
{
    private $parent;

    protected $options = array(
        'postfix' => 'tree');

    public function setMapper(mapper $mapper)
    {
        if (!isset($this->options['foreign_key'])) {
            $this->options['foreign_key'] = $mapper->pk();
        }

        $map = $mapper->map();
        $this->options['foreign_accessor'] = $map[$this->options['foreign_key']]['accessor'];

        return parent::setMapper($mapper);
    }

    protected function updateMap(& $map)
    {
        $map['tree_level'] = array(
            'accessor' => 'getTreeLevel',
            'options' => array(
                'fake',
                'ro'));

        $map['tree_path'] = array(
            'accessor' => 'getTreePath',
            'options' => array(
                'fake',
                'ro'));

        $map['tree_id'] = array(
            'accessor' => 'getTreeId',
            'options' => array(
                'fake',
                'ro'));

        $map['tree_foreign_key'] = array(
            'accessor' => 'getTreeForeignKey',
            'options' => array(
                'fake',
                'ro'));

        $map['tree_parent'] = array(
            'accessor' => 'getTreeParent',
            'mutator' => 'setTreeParent',
            'options' => array(
                'fake'));

        $map['tree_parent_branch'] = array(
            'accessor' => 'getTreeParentBranch',
            'options' => array(
                'fake'));

        $map['tree_branch'] = array(
            'accessor' => 'getTreeBranch',
            'options' => array(
                'fake'));
    }

    public function preSqlSelect(criteria $criteria)
    {
        $criterion = new criterion('tree.foreign_key', $this->mapper->table() . '.' . $this->options['foreign_key'], criteria::EQUAL, true);
        $criteria->addJoin($this->table(), $criterion, 'tree');
        $criteria->setOrderByFieldAsc('tree.path');
        $this->addSelectFields($criteria);
    }

    public function preSqlJoin(array & $data)
    {
        $criteria = $data[0];
        $alias = $data[1];

        $criterion = new criterion('tree.foreign_key', $alias . '.' . $this->options['foreign_key'], criteria::EQUAL, true);
        $criteria->addJoin($this->table(), $criterion, 'tree');
        $criteria->setOrderByFieldAsc('tree.path');
        $this->addSelectFields($criteria, $alias);
    }

    public function postCreate(entity $object)
    {
        $tmp['tree_parent'] = new lazy(array(
            $this,
            'getParent',
            array(
                $object)));

        $tmp['tree_parent_branch'] = new lazy(array(
            $this,
            'getParentBranch',
            array(
                $object)));

        $tmp['tree_branch'] = new lazy(array(
            $this,
            'getBranch',
            array(
                $object)));

        $object->merge($tmp);
    }

    public function getParent(entity $object)
    {
        $path = $object->getTreePath();
        $parent = substr($path, 0, strrpos(substr($path, 0, -1), '/')) . '/';

        $criteria = new criteria();
        $criteria->add('tree.path', $parent);

        return $this->mapper->searchOneByCriteria($criteria);
    }

    public function getParentBranch(entity $object)
    {
        $path = $object->getTreePath();
        $path = explode('/', $path);
        array_pop($path);

        $nodes = array();

        while (sizeof($path)) {
            $nodes[] = implode('/', $path) . '/';
            array_pop($path);
        }

        $criteria = new criteria();
        $criteria->add('tree.path', $nodes, criteria::IN);

        return $this->mapper->searchAllByCriteria($criteria);
    }

    public function getBranch(entity $object, $depth = 0)
    {
        $path = $object->getTreePath();

        $criteria = new criteria();
        $criteria->add('tree.path', $path . '%', criteria::LIKE);

        if ($depth) {
            $criteria->add('tree.level', $object->getTreeLevel() + $depth, criteria::LESS_EQUAL);
        }

        return $this->mapper->searchAllByCriteria($criteria);
    }

    public function preInsert(array & $data)
    {
        // if tree parent was specified - remove it from the data array and store for later using in postInsert event
        if (isset($data['tree_parent'])) {
            $this->parent = $data['tree_parent'];
            unset($data['tree_parent']);
        }
    }

    public function preUpdate(& $data)
    {
        if (is_array($data)) {
            if (isset($data['tree_parent'])) {
                $this->parent = $data['tree_parent'];
                unset($data['tree_parent']);
            }
        }
    }

    public function postInsert(entity $object)
    {
        $criteria = new criteria($this->table());
        $insert = new simpleInsert($criteria);
        // insert the record to tree table linked with data table
        $this->mapper->db()->query($insert->toString(array(
            'foreign_key' => $object->{$this->options['foreign_accessor']}())));
        $criteria->add('foreign_key', $object->{$this->options['foreign_accessor']}());
        // update path
        $update = new simpleUpdate($criteria);

        $path = $this->mapper->db()->lastInsertId();

        // if parent node was specified - append it's path before current node id
        if (!empty($this->parent)) {
            $path = $this->parent->getTreePath() . $path;
            unset($this->parent);
        }

        $path .= '/';

        $level = $this->calcLevelByPath($path);

        $this->mapper->db()->query($update->toString(array(
            'path' => $path,
            'level' => $level)));
        // merge tree info into object
        $data = array(
            'tree_path' => $path,
            'tree_level' => $level);
        $object->merge($data);
        $this->postCreate($object);
    }

    public function postUpdate(entity $object)
    {
        // if parent was changed
        if (!empty($this->parent)) {
            $path = $this->parent->getTreePath() . $object->getTreeId() . '/';

            $newLevel = $this->calcLevelByPath($path);

            $levelDelta = $newLevel - $object->getTreeLevel();

            $sql = "UPDATE `" . $this->table() . "`
                     SET `level` = `level` + " . $levelDelta . ", `path` = CONCAT(" . $this->mapper->db()->quote($this->parent->getTreePath()) . ", SUBSTRING(`path`, " . (strlen($object->getTreeParent()->getTreePath()) + 1) . "))
                      WHERE `path` LIKE " . $this->mapper->db()->quote($object->getTreePath() . '%') . "";

            $this->mapper->db()->query($sql);

            $object->merge(array(
                'tree_path' => $path,
                'tree_level' => $newLevel));
            $this->postCreate($object);

            unset($this->parent);
        }
    }

    public function preDelete(entity $object)
    {
        // retrieve all subnodes
        $criteria = new criteria($this->table());
        $criteria->addSelectField('foreign_key');
        $criteria->add('path', $object->getTreePath() . '%', criteria::LIKE);
        $criteria->add('id', $object->getTreeId(), criteria::NOT_EQUAL);

        $select = new simpleSelect($criteria);

        // traverse subnodes and delete each
        foreach ($this->mapper->db()->getAll($select->toString()) as $key) {
            $this->mapper->delete($key['foreign_key']);
        }

        // delete current node
        $criteria = new criteria($this->table());
        $criteria->add('foreign_key', $object->{$this->options['foreign_accessor']}());
        $delete = new simpleDelete($criteria);
        $this->mapper->db()->query($delete->toString());
    }

    private function table()
    {
        return $this->mapper->table() . '_' . $this->options['postfix'];
    }

    private function addSelectFields(criteria $criteria, $alias = null)
    {
        if (is_null($alias)) {
            $alias = $this->mapper->table();
        }

        foreach (array(
            'id',
            'path',
            'foreign_key',
            'level') as $field) {
            $criteria->addSelectField('tree.' . $field, $alias . mapper::TABLE_KEY_DELIMITER . 'tree_' . $field);
        }
    }

    private function calcLevelByPath($path)
    {
        return substr_count($path, '/');
    }
}

?>