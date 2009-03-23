<?php

fileLoader::load('jip');

class jipPlugin extends observer
{
    public function setMapper(mapper $mapper)
    {
        parent::setMapper($mapper);
        if (!isset($this->options['identity_method'])) {
            $map = $this->mapper->map();
            $this->options['identity_method'] = $map[$mapper->pk()]['accessor'];
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
    public function getJip($object, $id = null, $class = null, $tpl = jip::DEFAULT_TEMPLATE)
    {
        $id = is_null($id) ? $object->{$this->options['identity_method']}() : $id;
        $class = is_null($class) ? get_class($object): $class;
        $action = systemToolkit::getInstance()->getAction($object->module());
        $jip = new jip($id, $class, $action->getJipActions($class), $object, $tpl);
        return $jip->draw();
    }

    public function postCreate(entity $object)
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