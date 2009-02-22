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

    public function getAcl()
    {
        return true;
    }
}

?>