<?php

class acl_simplePlugin extends observer
{
    protected function updateMap(& $map)
    {
        $map['acl'] = array(
            'accessor' => 'getAcl',
            'options' => array(
                'fake',
                'ro',
                'nocache'));
    }

    public function preCreate(entity $object)
    {
        $name = method_exists($object, 'getAcl') ? 'getDefaultAcl' : 'getAcl';

        $tmp['acl'] = new lazy(array(
            $this,
            $name,
            array(
                $object)));

        $object->merge($tmp);
    }

    public function getAcl($object, $name = null)
    {
        if (method_exists($object, 'getAcl')) {
            return $object->getAcl($name);
        }

        return $this->getDefaultAcl($object, $name);
    }

    public function getDefaultAcl($object, $name = null)
    {
        $acl = new acl();
        return $acl->getForClass($this->mapper->getClass(), $name);
    }
}

?>