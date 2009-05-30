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
     * Имя JIP-шаблона по умолчанию
     *
     * @var string
     */
    const DEFAULT_TEMPLATE = 'jip/jip.tpl';

    /**
     * Имя модуля
     *
     * @var string
     */
    private $module;

    /**
     * Идентификатор
     *
     * @var string
     */
    private $id;

    /**
     * Тип
     *
     * @var string
     */
    private $type;

    /**
     * Действия для JIP
     *
     * @var array
     */
    private $actions;

    /**
     * Объект, для которого строится JIP-меню
     *
     * @var simple
     */
    private $obj;

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
     * @param string $type тип доменного объекта
     * @param array $actions действия для JIP
     * @param simple $obj объект
     * @param string $tpl шаблон JIP-меню
     */
    public function __construct($id, $type, Array $actions, entity $obj, $tpl = self::DEFAULT_TEMPLATE)
    {
        $this->module = $obj->module();
        $this->id = $id;
        $this->type = $type;
        $this->actions = $actions;
        $this->obj = $obj;
        $this->tpl = $tpl;
        $this->generate();
    }

    /**
     * Генерирует ссылку для JIP
     *
     * @param string $action action's params
     * @param string $action_name действие модуля
     * @return string
     */
    private function buildUrl($action, $action_name)
    {
        $url = new url(isset($action['route_name']) ? $action['route_name'] : 'withId');
        $url->setSection($this->module);
        $url->setAction($action_name);

        if (isset($action['route_name'])) {
            foreach ($action as $name => $value) {
                if (strpos($name, 'route.') === 0) {
                    $url->add(substr($name, 6), strpos($value, '->') === 0 ? $this->callObjectMethodFromString($value): $value);
                }
            }
        } else {
            $url->add('id', $this->id);
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
     * Генерирует ссылку для JIP на редактирование ACL
     *
     * @param integer $obj_id идентификатор объекта
     * @return string
     */
    private function buildACLUrl($obj_id)
    {
        $url = new url('withId');
        $url->setSection('access');
        $url->setAction('editACL');
        $url->add('id', $obj_id);
        return $url->get();
    }

    /**
     * Генерирует массив JIP из названия и ссылки для действия модуля
     *
     * @return array
     */
    private function generate()
    {
        $toolkit = systemToolkit::getInstance();

        foreach ($this->actions as $key => $item) {
            $action = isset($item['alias']) ? $item['alias'] : $key;
            if ($this->obj->getAcl($action)) {
                $item['url'] = isset($item['url']) ? $item['url'] : (($key != 'editACL') ? $this->buildUrl($item, $key) : $this->buildACLUrl($this->obj->getObjId()));
                $item['id'] = $this->getJipMenuId() . '_' . $item['controller'];
                $item['icon'] = isset($item['icon']) ? SITE_PATH . $item['icon'] : '';
                $item['lang'] = (isset($item['lang']) && systemConfig::$i18nEnable) ? (boolean)$item['lang'] : false;
                $item['target'] = (isset($item['jip_target']) && $item['jip_target'] == 'new') ? 1 : 0;

                if (!isset($item['title'])) {
                    $item['title'] = '_ ' . $key;
                }

                if (i18n::isName($item['title'])) {
                    $item['title'] = i18n::getMessage(i18n::extractName($item['title']), 'jip');
                }

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
    public function & getItem($name)
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
        return $this->module . '_' . $this->type . '_' . $this->id;
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
            $smarty->assign('jipMenuId', str_replace('/', '_', $this->getJipMenuId()));
            $this->result = array();

            return $smarty->fetch($this->tpl);
        }

        return '';
    }
}

?>
