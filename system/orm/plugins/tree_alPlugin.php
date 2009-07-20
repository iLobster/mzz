<?php

class tree_alPlugin extends observer
{
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
}

?>