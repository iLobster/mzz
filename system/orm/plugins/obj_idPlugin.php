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
            'options' => array('ro')
        );
    }

    public function postCreate(entity $object)
    {
        if (!$object->getObjId()) {
            $obj_id = systemToolkit::getInstance()->getObjectId();
            $object->merge(array($this->options['obj_id_field'] => $obj_id));
            $this->mapper->save($object);
        }
    }

    public function preInsert(array & $data)
    {
        $data[$this->options['obj_id_field']] = systemToolkit::getInstance()->getObjectId();
    }
}

?>