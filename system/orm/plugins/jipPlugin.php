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
     * @param string $id
     * @param string $type
     * @param string $tpl шаблон JIP-меню
     * @return string
     */
    protected function getJipView($object, $id, $class, $tpl = jip::DEFAULT_TEMPLATE)
    {
        $action = systemToolkit::getInstance()->getAction($object->module());
        $jip = new jip($id, $class, $action->getJipActions($class), $object, $tpl);
        return $jip->draw();
    }

    /**
     * Возвращает JIP-меню
     * Переопределяется если требуется использовать другие данные для построения JIP-меню
     *
     * @param string $tpl шаблон JIP-меню
     * @return string
     */
    public function getJip($object, $tpl = jip::DEFAULT_TEMPLATE)
    {
        return $this->getJipView($object, $object->getId(), get_class($object), $tpl);
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