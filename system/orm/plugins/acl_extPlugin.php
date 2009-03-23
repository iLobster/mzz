<?php

class acl_extPlugin extends observer
{
    const OBJ_ID_PLUGIN_NAME = 'obj_id';
    protected $obj_id_field;

    public function __construct($obj_id_field = 'obj_id')
    {
        $this->obj_id_field = $obj_id_field;
    }

    public function setMapper(mapper $mapper)
    {
        parent::setMapper($mapper);

        try {
            $this->mapper->plugin(self::OBJ_ID_PLUGIN_NAME);
        } catch (mzzRuntimeException $e) {
            fileLoader::load('orm/plugins/obj_idPlugin');
            $this->mapper->attach(new obj_idPlugin($this->obj_id_field));
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

    public function postCreate(entity $object)
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