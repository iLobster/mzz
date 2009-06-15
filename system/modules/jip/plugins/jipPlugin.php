<?php

fileLoader::load('jip');

class jipPlugin extends observer
{
    public function setMapper(mapper $mapper)
    {
        parent::setMapper($mapper);

        if (!isset($this->options['identity_method'])) {
            $map = $this->mapper->map();

            $this->options['identity_method'] = !$this->mapper->pk() ? 'getObjId' : $map[$this->mapper->pk()]['accessor'];
        }
    }

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
    public function getJip($object, $menu_id = 1) // $obj_id = null, $class = null, $tpl = jip::DEFAULT_TEMPLATE)
    {
        //$class = is_null($class) ? get_class($object): $class;
        $class = get_class($object);

        $action = systemToolkit::getInstance()->getAction($object->module());

        $actions = $action->getActions(array('class' => $class, 'jip' => $menu_id));

        try {
            $object->getObjId();
        } catch(mzzORMNotExistMethodException $e) {
            unset($actions['editACL']);
        }

        $obj_id = $object->{$this->options['identity_method']}();

        $jip = new jip($obj_id, $class, $actions, $object);
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
}

?>