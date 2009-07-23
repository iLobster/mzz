<?php

class tree_alPlugin extends observer
{
    private $parent;
    private $path_name_changed;

    protected $options = array(
        'postfix' => 'tree');

    public function setMapper(mapper $mapper)
    {
        if (!isset($this->options['path_name'])) {
            throw new mzzRuntimeException('path_name option should be specified');
        }

        if (!isset($this->options['foreign_key'])) {
            $this->options['foreign_key'] = $mapper->pk();
        }

        $map = $mapper->map();
        $this->options['foreign_accessor'] = $map[$this->options['foreign_key']]['accessor'];
        $this->options['path_name_accessor'] = $map[$this->options['path_name']]['accessor'];

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

        $map['tree_parent_id'] = array(
            'accessor' => 'getTreeParentId',
            'mutator' => 'setTreeParentId');

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
        $this->addSelectFields($criteria);
    }

    private function table()
    {
        return $this->mapper->table() . '_' . $this->options['postfix'];
    }

    private function addSelectFields(criteria $criteria, $alias = null)
    {
        if (is_null($alias)) {
            $alias = $this->mapper->table();
            $self = 'tree';
        } else {
            $self = $alias . '_tree';
        }

        foreach (array(
            'id',
            'path',
            'foreign_key',
            'level',
            'parent_id') as $field) {
            $criteria->addSelectField($self . '.' . $field, $alias . mapper::TABLE_KEY_DELIMITER . 'tree_' . $field);
        }
    }

    public function postCreate(entity $object)
    {
        $tmp = array();
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

    public function getParentBranch(entity $object)
    {
        $ids = array();
        $ids[] = $object->getTreeForeignKey();

        $parent_id = $object->getTreeParentId();

        $criteria = new criteria($this->table());
        $criteria->addSelectField('parent_id')->addSelectField('foreign_key');
        $select = new simpleSelect($criteria);

        while ($parent_id != 0) {
            $criteria->add('id', $parent_id);
            $row = $this->mapper->db()->getRow($select->toString());

            $ids[] = $row['foreign_key'];
            $parent_id = $row['parent_id'];
        }

        $criteria = new criteria();
        $criteria->add($this->options['foreign_key'], $ids, criteria::IN);

        return $this->mapper->searchAllByCriteria($criteria);
    }

    public function getBranch(entity $object, $depth = 0, criteria $sortCriteria = null)
    {
        if ($depth) {
            $depth += $object->getTreeLevel();
        }
        $ids = array_merge(array($object->getTreeId()), $this->searchChildren($object->getTreeId(), $depth));

        $criteria = new criteria();
        $criteria->add($this->options['foreign_key'], $ids, criteria::IN);

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
            if (isset($data[$this->options['path_name']])) {
                $this->path_name_changed = true;
            }
            if (isset($data['tree_parent'])) {
                $this->parent = $data['tree_parent'];
                unset($data['tree_parent']);
            }
        }
    }

    public function postInsert(entity $object)
    {
        // if parent node was specified - append it's path before current node id
        if (!empty($this->parent)) {
            $level = $this->parent->getTreeLevel() + 1;
            $parent_id = $this->parent->getTreeId();
            $path = $this->parent->getTreePath() . '/';
            unset($this->parent);
        } else {
            $level = 1;
            $parent_id = 0;
            $path = '';
        }

        $path .= $object->{$this->options['path_name_accessor']}();

        $criteria = new criteria($this->table());
        $insert = new simpleInsert($criteria);
        // insert the record to tree table linked with data table
        $this->mapper->db()->query($insert->toString(array(
            'parent_id' => $parent_id,
            'level' => $level,
            'path' => $path . '/',
            'foreign_key' => $object->{$this->options['foreign_accessor']}())));

        $data = array(
            'tree_level' => $level,
            'tree_parent_id' => $parent_id,
            'tree_path' => $path);
        $object->merge($data);
        $this->postCreate($object);
    }

    public function postUpdate(entity $object)
    {
        // if parent was changed
        if (!empty($this->parent)) {
            $path = $this->parent->getTreePath() . '/' . $object->{$this->options['path_name_accessor']}();

            $newLevel = $this->parent->getTreeLevel() + 1;

            $levelDelta = $newLevel - $object->getTreeLevel();

            $ids = array_merge($this->searchChildren($object->getTreeId()), array($object->getTreeId()));

            $sql = "UPDATE `" . $this->table() . "`
                     SET `level` = `level` + " . $levelDelta . ", `path` = CONCAT(" . $this->mapper->db()->quote($this->parent->getTreePath()) . ", SUBSTRING(`path`, " . (strlen($object->getTreeParent()->getTreePath()) + 1) . "))
                      WHERE `id` IN (" . implode(', ', $ids) . ")";

            $this->mapper->db()->query($sql);

            $criteria = new criteria($this->table());
            $criteria->add('foreign_key', $object->{$this->options['foreign_accessor']}());
            $update = new simpleUpdate($criteria);
            $this->mapper->db()->query($update->toString(array(
                'parent_id' => $this->parent->getTreeId())));

            $object->merge(array(
                'tree_level' => $newLevel,
                'tree_parent_id' => $this->parent->getTreeId(),
                'tree_path' => $path));
            $this->postCreate($object);

            unset($this->parent);
        }

        if ($this->path_name_changed) {
            $this->path_name_changed = false;

            $new = $object->getTreeLevel() != 1 ? $object->getTreeParent()->getTreePath() . '/' : '';
            $new .= $object->{$this->options['path_name_accessor']}() . '/';

            $ids = array_merge($this->searchChildren($object->getTreeId()), array($object->getTreeId()));

            $sql = "UPDATE `" . $this->table() . "`
                     SET `path` = CONCAT(" . $this->mapper->db()->quote($new) . ", SUBSTRING(`path`, " . (strlen($object->getTreePath()) + 2) . "))
                      WHERE `id` IN (" . implode(', ', $ids) . ")";

            $this->mapper->db()->query($sql);

            $object->merge(array(
                'tree_path' => $new));
        }
    }

    private function searchChildren($node_id, $level = 0)
    {
        $result = array();

        $criteria = new criteria($this->table());
        $criteria->addSelectField('id');
        $criteria->add('parent_id', $node_id);

        if ($level) {
            $criteria->add('level', $level, criteria::LESS_EQUAL);
        }

        $select = new simpleSelect($criteria);

        foreach ($this->mapper->db()->getAll($select->toString()) as $row) {
            $result[] = $row['id'];
            $result = array_merge($result, $this->searchChildren($row['id'], $level));
        }

        return $result;
    }

    public function preDelete(entity $object)
    {
        // retrieve all subnodes
        $criteria = new criteria($this->table());
        $criteria->add('tree.parent_id', $object->getTreeId());

        // traverse subnodes and delete each
        foreach ($this->mapper->searchAllByCriteria($criteria) as $subnode) {
            $this->mapper->delete($subnode);
        }

        // delete current node
        $criteria = new criteria($this->table());
        $criteria->add('foreign_key', $object->{$this->options['foreign_accessor']}());
        $delete = new simpleDelete($criteria);
        $this->mapper->db()->query($delete->toString());
    }

    public function getParent(entity $object)
    {
        return $this->mapper->searchOneByField('id', $object->getTreeParentId());
    }

    public function processRow(& $row)
    {
        $row['tree_path'] = trim($row['tree_path'], '/');
    }
}

?>