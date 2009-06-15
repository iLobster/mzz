<?php

fileLoader::load('jip');

class jipPlugin extends observer
{
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
            $obj_id = $object->getObjId();
        } catch(mzzORMNotExistMethodException $e) {
            $obj_id = $object->{$this->getPkAccessor()}();
            unset($actions['editACL']);
        }

        $jip = new jip($obj_id, $class, $actions, $object);
        return $jip->draw();
    }

    private function getPkAccessor()
    {
        if (!isset($this->options['identity_method'])) {
            $map = $this->mapper->map();

            if (!$mapper->pk()) {
                throw new mzzRuntimeException('Primary key in object map expected');
            }

            $this->options['identity_method'] = $map[$mapper->pk()]['accessor'];
        }

        return $this->options['identity_method'];
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