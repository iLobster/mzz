<?php

fileLoader::load('jip');

class jipPlugin extends observer
{
    protected $options = array('byField' => 'id');

    protected function updateMap(& $map)
    {
        $map['jip'] = array('accessor' => 'getJip', 'options' => array('fake', 'ro'));
    }

    /**
     * Возвращает JIP-меню
     *
     * @param string $tpl шаблон JIP-меню
     * @return string
     */
    public function getJip($object, $menu_id = 1, $tpl = jip::DEFAULT_TEMPLATE, $class = null) // $obj_id = null, $class = null, $tpl = jip::DEFAULT_TEMPLATE)
    {
        $class = is_null($class) ? get_class($object) : $class;

        $map = $this->mapper->map();
        if (!isset($map[$this->getByField()])) {
            throw new mzzInvalidParameterException('Invalid byField value for jip plugin');
        }

        $objectId = $object->$map[$this->getByField()]['accessor']();

        $module = systemToolkit::getInstance()->getModule($object->module());
        $actions = $module->getClassActions($class);

        $jip_id = $object->module() . '_' . $class . '_' . $objectId;
        $jip = new jip($jip_id, $tpl);

        foreach ($actions as $actionName => $actionObject) {
            if ($actionObject->isJip() && $actionObject->getJipMenuId() == $menu_id) {
                $actionObject->setObject($object);
                if ($actionObject->canRun()) {
                    $item = array();
                    $item['title'] = $actionObject->getTitle();
                    $item['url'] = $this->buildUrlForJip($object, $objectId, $actionObject);
                    $item['id'] = $jip_id . '_' . $actionObject->getControllerName();
                    $item['lang'] = $actionObject->isLang();
                    $item['icon'] = $actionObject->getIcon();

                    $target = $actionObject->getData('jip_target');
                    $item['target'] = ($target === 'new');
                    $jip->addItem($actionName, $item);
                }
            }
        }

        return $jip->getJip();
    }

    protected function buildUrlForJip($object, $objectId, simpleAction $action)
    {
        $url = new url();
        $url->setModule($object->module());
        $url->setAction($action->getName());

        $routeName = $action->getData('route_name');
        if (!$routeName) {
            $url->setRoute('withId');
            $url->add('id', $objectId);
        } else {
            $url->setRoute($routeName);
            foreach ($action->getAllData() as $name => $value) {
                if (strpos($name, 'route.') === 0) {
                    $url->add(substr($name, 6), strpos($value, '->') === 0 ? $this->callObjectMethodFromString($object, $value) : $value);
                }
            }
        }

        return $url->get();
    }

    private function callObjectMethodFromString($object, $str)
    {
        $methods = explode('->', substr($str, 2));
        $result = $object;
        foreach ($methods as $method) {
            $result = $result->$method();
        }
        return $result;
    }

    public function preCreate(entity $object)
    {
        $tmp = array();
        $tmp['jip'] = new lazy(array($this, 'getJip', array($object)));

        $object->merge($tmp);
    }

    public function getByField()
    {
        return $this->options['byField'];
    }
}

?>