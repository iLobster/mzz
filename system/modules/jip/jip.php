<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * jip: класс для работы с jip
 *
 * @package modules
 * @subpackage jip
 * @version 0.1.5
 */

class jip
{
    /**
     * Default template for jip
     *
     * @var string
     */
    const DEFAULT_TEMPLATE = 'jip/jip.tpl';

    /**
     * JIP object id
     *
     * @var int
     */
    private $id;

    /**
     * JIP object type
     *
     * @var string
     */
    private $type;

    /**
     * JIP Object
     *
     * @var simple
     */
    private $obj;

    /**
     * Действия для JIP
     *
     * @var array
     */
    private $actions;

    /**
     * Результат сборки массива элементов JIP-меню
     *
     * @var array
     */
    private $result = array();

    /**
     * Шаблон JIP-меню
     *
     * @var string
     */
    private $tpl = null;

    /**
     * Конструктор
     *
     * @param integer $id идентификатор
     * @param array $actions действия для JIP
     * @param simple $obj объект
     * @param string $tpl шаблон JIP-меню
     * @param string $type тип доменного объекта
     */
    public function __construct($id, Array $actions, entity $obj, $tpl = self::DEFAULT_TEMPLATE, $type)
    {
        $this->id = $id;
        $this->actions = $actions;
        $this->obj = $obj;
        $this->tpl = $tpl;
        $this->type = $type;
    }

    /**
     * Генерирует ссылку для JIP
     *
     * @param string $action action's params
     * @param string $action_name действие модуля
     * @return string
     */
    private function buildUrl(simpleAction $action, $action_name)
    {
        $url = new url();
        $url->setModule($this->obj->module());
        $url->setAction($action_name);

        $routeName = $action->getData('route_name');
        if (!$routeName) {
            $url->setRoute('withId');
            $url->add('id', $this->id);
        } else {
            $url->setRoute($routeName);
            foreach ($action->getAllData() as $name => $value) {
                if (strpos($name, 'route.') === 0) {
                    $url->add(substr($name, 6), strpos($value, '->') === 0 ? $this->callObjectMethodFromString($value) : $value);
                }
            }
        }

        return $url->get();
    }

    protected function callObjectMethodFromString($str)
    {
        $methods = explode('->', substr($str, 2));
        $result = $this->obj;
        foreach ($methods as $method) {
            $result = $result->$method();
        }
        return $result;
    }

    /**
     * Генерирует массив JIP из названия и ссылки для действия модуля
     *
     * @return array
     */
    private function generate()
    {
        $this->result = array();
        foreach ($this->actions as $key => $action) {
            $action->setObject($this->obj);
            if ($action->canRun()) {
                $item = array();
                $item['title'] = $action->getTitle();
                $item['url'] = $this->buildUrl($action, $key);
                $item['id'] = $this->getJipMenuId() . '_' . $action->getControllerName();
                $item['lang'] = $action->isLang();
                $item['icon'] = $action->getIcon();

                $target = $action->getData('jip_target');
                $item['target'] = ($target === 'new');

                $this->result[$key] = new arrayDataspace($item);
            }
        }
    }

    /**
     * Проверяет присутствие элемента в JIP-меню
     *
     * @param string $name имя элемента
     * @return boolean
     */
    public function hasItem($name)
    {
        return isset($this->result[$name]);
    }

    /**
     * Возвращает ссылку на массив данных элемента JIP-меню
     *
     * @return array
     */
    public function &getItem($name)
    {
        if (isset($this->result[$name])) {
            return $this->result[$name];
        } else {
            throw new mzzRuntimeException('Не найден элемент "' . $name . '" в jip-меню для dataobject "' . $this->type . '"');
        }
    }

    /**
     * Возвращает идентификатор JIP-меню
     *
     * @return string
     */
    private function getJipMenuId()
    {
        return $this->obj->module() . '_' . $this->type . '_' . $this->id;
    }

    /**
     * Возвращает отображение JIP
     *
     * @return string
     */
    public function draw()
    {
        static $langs = array();

        if (empty($langs)) {
            $langs = locale::searchAll();
        }

        if (empty($this->result)) {
            $this->generate();
        }

        if (sizeof($this->result)) {
            $toolkit = systemToolkit::getInstance();
            $smarty = $toolkit->getSmarty();

            $smarty->assign('langs', $langs);

            $smarty->assign('jip', $this->result);
            //@todo: wtf str_replace?
            $smarty->assign('jipMenuId', str_replace('/', '_', $this->getJipMenuId()));
            $this->result = array();

            return $smarty->fetch($this->tpl);
        }

        return '';
    }
}

?>