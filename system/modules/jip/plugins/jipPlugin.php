<?php

fileLoader::load('jip');

class jipPlugin extends observer
{
    protected $options = array(
        'byField' => 'id'
    );

    protected function updateMap(& $map)
    {
        $map['jip'] = array(
            'accessor' => 'getJip',
            'options' => array(
                'fake',
                'ro'));
    }

    /**
     * Возвращает JIP-меню
     *
     * @param string $tpl шаблон JIP-меню
     * @return string
     */
    public function getJip($object, $menu_id = 1, $tpl = jip::DEFAULT_TEMPLATE, $class = null) // $obj_id = null, $class = null, $tpl = jip::DEFAULT_TEMPLATE)
    {
        $class = is_null($class) ? get_class($object): $class;

        $map = $this->mapper->map();
        if (!isset($map[$this->getByField()])) {
            throw new mzzInvalidParameterException('Invalid byField value for jip plugin');
        }

        $objectId = $object->$map[$this->getByField()]['accessor']();

        $module = systemToolkit::getInstance()->getModule($object->module());
        $actions = $module->getClassActions($class);

        $jipActions = array();
        foreach ($actions as $actionName => $actionObject) {
            if ($actionObject->isJip() && $actionObject->getJipMenuId() == $menu_id) {
                $jipActions[$actionName] = $actionObject;
            }
        }

        $jip = new jip($objectId, $jipActions, $object, $tpl, $class);
        return $jip->draw();
    }

    public function preCreate(entity $object)
    {
        $tmp = array();
        $tmp['jip'] = new lazy(array(
            $this,
            'getJip',
            array(
                $object)));

        $object->merge($tmp);
    }

    public function getByField()
    {
        return $this->options['byField'];
    }
}

?>