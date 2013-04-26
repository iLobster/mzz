<?php

class versionablePlugin extends observer
{
    protected $options = array(
        'field' => 'version',
        'postfix' => 'version');

    protected function updateMap(& $map)
    {
        $map['version'] = array(
            'accessor' => 'getVersion',
            'mutator' => 'setVersion');
    }

    public function preInsert(array & $data)
    {
        $data[$this->options['field']] = 1;
    }

    public function postInsert(entity $object)
    {
        $data = $object->export();

        $data['version'] = $object->getVersion();

        $criteria = new criteria($this->mapper->table() . '_' . $this->options['postfix']);

        $insert = new simpleInsert($criteria);

        $this->mapper->db()->query($insert->toString($data));
    }

    public function preUpdate(& $data)
    {
        if (is_array($data)) {
            $data[$this->options['field']] = new sqlOperator('+', array(
                $this->options['field'],
                1));
        }
    }

    public function postUpdate(entity $object)
    {
        return $this->postInsert($object);
    }

    public function revert(entity $object, $revision)
    {
        $criteria = $this->getPKCriteria($object);
        $criteria->where($this->options['field'], $revision);
        $select = new simpleSelect($criteria);

        $data = $this->mapper->db()->getRow($select->toString());

        $object->merge($data);
    }

    public function preDelete(entity $object)
    {
        $criteria = $this->getPKCriteria($object);
        $delete = new simpleDelete($criteria);
        $this->mapper->db()->query($delete->toString());
    }

    private function getPKCriteria(entity $object)
    {
        $map = $this->mapper->map();
        $accessor = $map[$this->mapper->pk()]['accessor'];

        $key = $object->$accessor();

        $criteria = new criteria($this->mapper->table() . '_' . $this->options['postfix']);
        $criteria->where($this->mapper->pk(), $key);

        return $criteria;
    }
}

?>