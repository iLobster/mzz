<?php

class acl_extPlugin extends observer
{
    public function setMapper(mapper $mapper)
    {
        parent::setMapper($mapper);

        try {
            $this->mapper->plugin('obj_id');
        } catch (mzzRuntimeException $e) {
            fileLoader::load('orm/plugins/obj_idPlugin');
            $this->mapper->attach(new obj_idPlugin());
        }
    }

    protected function updateMap(& $map)
    {
        $map['acl'] = array(
            'accessor' => 'getAcl',
            'options' => array(
                'fake',
                'ro'));
    }

    public function preCreate(entity $object)
    {
        $tmp['acl'] = new lazy(array(
            $this,
            'getAcl',
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
        $acl = new acl(systemToolkit::getInstance()->getUser(), $object->getObjId());
        return $acl->get($name);
    }
}

?>