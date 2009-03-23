<?php

class obj_idPlugin extends observer
{
    protected $obj_id_field;

    public function __construct($obj_id_field = 'obj_id')
    {
        $this->obj_id_field = $obj_id_field;
        parent::__construct();
    }

    protected function updateMap(& $map)
    {
        $map[$this->obj_id_field] = array(
            'accessor' => 'getObjId',
            'mutator' => 'setObjId',
            'options' => array('ro')
        );
    }

    public function postCreate(entity $object)
    {
        if (!$object->getObjId()) {
            $obj_id = systemToolkit::getInstance()->getObjectId();
            $object->merge(array('obj_id' => $obj_id));
            $this->mapper->save($object);
        }
    }

    public function preInsert(array & $data)
    {
        $data['obj_id'] = systemToolkit::getInstance()->getObjectId();
    }
}

?>