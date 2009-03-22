<?php

class acl_extPlugin extends observer
{
    protected function updateMap(& $map)
    {
        $map['acl'] = array(
            'accessor' => 'getAcl',
            'options' => array(
                'fake',
                'ro'));
        $map['obj_id'] = array(
            'accessor' => 'getObjId',
            'mutator' => 'setObjId',
            'options' => array(
                'ro'));
    }

    public function postCreate(entity $object)
    {
        $tmp['acl'] = new lazy(array(
            $this,
            'getAcl',
            array(
                $object)));

        $object->merge($tmp);
    }

    public function preInsert(array & $data)
    {
        $data['obj_id'] = systemToolkit::getInstance()->getObjectId();
    }

    public function getAcl($object, $name = null)
    {
        if (method_exists($object, 'getAcl')) {
            return $object->getAcl($name);
        }

        $acl = new acl(systemToolkit::getInstance()->getUser(), $object->getObjId());
        return $acl->get($name);
    }
}

?>