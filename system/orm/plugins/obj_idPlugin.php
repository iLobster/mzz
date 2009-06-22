<?php

class obj_idPlugin extends observer
{
    protected $options = array(
        'obj_id_field' => 'obj_id'
    );

    protected function updateMap(& $map)
    {
        $map[$this->options['obj_id_field']] = array(
            'accessor' => 'getObjId',
            'mutator' => 'setObjId',
            'options' => array('once', 'plugin')
        );
    }

    public function postCreate(entity $object)
    {
        if (!$object->getObjId()) {
            $obj_id = systemToolkit::getInstance()->getObjectId();
            $map = $this->mapper->map();
            $object->{$map[$this->options['obj_id_field']]['mutator']}($obj_id);
            $this->mapper->save($object);
        }
    }

    public function preInsert(array & $data)
    {
        $data[$this->options['obj_id_field']] = systemToolkit::getInstance()->getObjectId();
    }

    public function setObjId(entity $object, $id)
    {
        $object->merge(array($this->options['obj_id_field'] => $id));
        return $object;
    }

    public function getObjIdField()
    {
        return $this->options['obj_id_field'];
    }
}

?>