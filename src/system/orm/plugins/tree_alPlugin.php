<?php

class tree_alPlugin extends observer
{
    private $parent;
    private $path_name_changed;
    private $old_path;

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
        $criterion = new criterion('tree.foreign_key', $this->mapper->table(false) . '.' . $this->options['foreign_key'], criteria::EQUAL, true);
        $criteria->join($this->table(), $criterion, 'tree');
        $this->addSelectFields($criteria);
    }

    public function preSqlJoin(array & $data)
    {
        $criteria = $data[0];
        $alias = $data[1];

        $table_name = $alias . '_' . $this->options['postfix'];

        $criterion = new criterion($table_name . '.foreign_key', $alias . '.' . $this->options['foreign_key'], criteria::EQUAL, true);
        $criteria->join($this->table(), $criterion, $table_name);
        $this->addSelectFields($criteria, $alias);
    }

    private function table()
    {
        return $this->mapper->table() . '_' . $this->options['postfix'];
    }

    private function addSelectFields(criteria $criteria, $alias = null)
    {
        if (is_null($alias)) {
            $alias = $this->mapper->table(false);
            $self = 'tree';
        } else {
            $self = $alias . '_' . $this->options['postfix'];
        }

        foreach (array(
            'id',
            'path',
            'foreign_key',
            'level',
            'parent_id') as $field) {
            $criteria->select($self . '.' . $field, $alias . mapper::TABLE_KEY_DELIMITER . 'tree_' . $field);
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
        $criteria->select('parent_id')->select('foreign_key');
        $select = new simpleSelect($criteria);

        while ($parent_id != 0) {
            $criteria->where('id', $parent_id);
            $row = $this->mapper->db()->getRow($select->toString());

            $ids[] = $row['foreign_key'];
            $parent_id = $row['parent_id'];
        }

        $criteria = new criteria();
        $criteria->where($this->options['foreign_key'], $ids, criteria::IN);

        return $this->mapper->searchAllByCriteria($criteria);
    }

    public function getBranch(entity $object, $depth = 0, criteria $sortCriteria = null)
    {
        if ($depth) {
            $depth += $object->getTreeLevel();
        }
        $ids = array_merge(array(
            $object->getTreeId()), $this->searchChildren($object->getTreeId(), $depth));

        $criteria = new criteria();
        $criteria->where($this->options['foreign_key'], $ids, criteria::IN);

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

    public function postCollectionSelect(collection $collection)
    {
        if ($collection->count()) {
            $rows = $collection->export();

            $last_id = reset($rows)->getTreeParentId();
            $result = array();
            $parent = array();
            $ids = array();

            foreach ($rows as $key => $data) {
                $parent[$data->getTreeParentId()][] = $data;
                $ids[$data->getTreeId()] = $data;
            }

            for ($i = count($rows); $i > 0; $i--) {
                while ((!isset($parent[$last_id]) || count($parent[$last_id]) == 0) && $last_id != 0) {
                    $last_id = $ids[$last_id]->getTreeParentId();
                }
                $lst = array_shift($parent[$last_id]);
                $last_id = $lst->getTreeId();

                $result[$lst->{$this->options['foreign_accessor']}()] = $lst;
            }

            $collection->import($result);
        }
    }

    public function preUpdate(& $data)
    {
        if (is_array($data)) {
            if (isset($data[$this->options['path_name']])) {
                $this->path_name_changed = true;
            }
            if (array_key_exists('tree_parent', $data)) {
                $this->parent = $data['tree_parent'];

                if (is_null($this->parent)) {
                    $this->parent = 0;
                }

                unset($data['tree_parent']);
            }
        }

        if (is_object($data)) {
            $this->old_path = $data->getTreePath();
        }
    }

    public function getBranchByPath($path, $depth = 0)
    {
        $criteria = new criteria();
        $criteria->where('tree.path', $path . '%', criteria::LIKE);

        if ($depth) {
            $criteria->where('tree.level', $this->calcLevelByPath($path) + $depth, criteria::LESS_EQUAL);
        }

        return $this->mapper->searchAllByCriteria($criteria);
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
        // if moved to root
        if ($this->parent === 0) {
            $path = $object->{$this->options['path_name_accessor']}();

            $this->moveNode($object, 1, '', 0, $path);

            unset($this->parent);
        } elseif (!empty($this->parent)) {
            // if parent was changed
            $path = $this->parent->getTreePath() . '/' . $object->{$this->options['path_name_accessor']}();

            $newLevel = $this->parent->getTreeLevel() + 1;
            $parentTreePath = $this->parent->getTreePath();
            $parentTreeId = $this->parent->getTreeId();

            $this->moveNode($object, $newLevel, $parentTreePath, $parentTreeId, $path);

            unset($this->parent);
        }

        if ($this->path_name_changed) {
            $oldPath = $this->old_path;
            $this->old_path = null;
            $this->path_name_changed = false;

            $new = $object->getTreeLevel() != 1 ? $object->getTreeParent()->getTreePath() . '/' : '';
            $new .= $object->{$this->options['path_name_accessor']}();

            $ids = array_merge($this->searchChildren($object->getTreeId()), array(
                $object->getTreeId()));

            $sql = "UPDATE `" . $this->table() . "`
                     SET `path` = CONCAT(" . $this->mapper->db()->quote($new . '/') . ", SUBSTRING(`path`, " . (mzz_strlen($oldPath) + 2) . "))
                      WHERE `id` IN (" . implode(', ', $ids) . ")";

            $this->mapper->db()->query($sql);

            $object->merge(array(
                'tree_path' => $new));
        }
    }

    private function moveNode($object, $newLevel, $parentTreePath, $parentTreeId, $path)
    {
        $levelDelta = $newLevel - $object->getTreeLevel();

        $ids = array_merge($this->searchChildren($object->getTreeId()), array(
            $object->getTreeId()));

        $sql = "UPDATE `" . $this->table() . "`
                     SET `level` = `level` + " . $levelDelta . ", `path` = CONCAT(" . $this->mapper->db()->quote($parentTreePath) . ", SUBSTRING(`path`, " . ($object->getTreeLevel() > 1 ? mzz_strlen($object->getTreeParent()->getTreePath()) + 1 : 1) . "))
                      WHERE `id` IN (" . implode(', ', $ids) . ")";

        $this->mapper->db()->query($sql);

        $criteria = new criteria($this->table());
        $criteria->where('foreign_key', $object->{$this->options['foreign_accessor']}());
        $update = new simpleUpdate($criteria);
        $this->mapper->db()->query($update->toString(array(
            'parent_id' => $parentTreeId)));

        $object->merge(array(
            'tree_level' => $newLevel,
            'tree_parent_id' => $parentTreeId,
            'tree_path' => $path));
        $this->postCreate($object);
    }

    private function searchChildren($node_id, $level = 0)
    {
        $result = array();

        $criteria = new criteria($this->table());
        $criteria->select('id');
        $criteria->where('parent_id', $node_id);

        if ($level) {
            $criteria->where('level', $level, criteria::LESS_EQUAL);
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
        $criteria->where('tree.parent_id', $object->getTreeId());

        // traverse subnodes and delete each
        foreach ($this->mapper->searchAllByCriteria($criteria) as $subnode) {
            $this->mapper->delete($subnode);
        }

        // delete current node
        $criteria = new criteria($this->table());
        $criteria->where('foreign_key', $object->{$this->options['foreign_accessor']}());
        $delete = new simpleDelete($criteria);
        $this->mapper->db()->query($delete->toString());
    }

    public function getParent(entity $object)
    {
        return $this->mapper->searchOneByField('tree.id', $object->getTreeParentId());
    }

    public function processRow(& $row)
    {
        $row['tree_path'] = trim($row['tree_path'], '/');
    }
}

?>