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
 * @package system
 * @version 0.1.2
 */

class jip
{
    /**
     * Section
     *
     * @var string
     */
    private $section;

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
     * Идентификатор объекта
     *
     * @var integer
     */
    private $obj_id;


    /**
     * Результат сборки массива элементов JIP-меню
     *
     * @var array
     */
    private $result = array();

    /**
     * Конструктор
     *
     * @param string $section
     * @param string $module имя модуля
     * @param integer $id идентификатор
     * @param string $type тип
     * @param array $actions действия для JIP
     * @param integer $obj_id идентификатор объекта
     */
    public function __construct($section, $module, $id, $type, Array $actions, $obj_id)
    {
        $this->section = $section;
        $this->module = $module;
        $this->id = $id;
        $this->type = $type;
        $this->actions = $actions;
        $this->obj_id = $obj_id;
        $this->generate();
    }

    /**
     * Генерирует ссылку для JIP
     *
     * @param string $action действие модуля
     * @return string
     */
    private function buildUrl($action)
    {
        $url = new url('withId');
        $url->setSection($this->section);
        $url->setAction($action);
        $url->addParam('id', $this->id);
        return $url->get();
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
        $url->addParam('id', $obj_id);
        return $url->get();
    }

    /**
     * Генерирует массив JIP из названия и ссылки для действия модуля
     *
     * @return array
     * @todo использовать $this->type в идентификатор или вообще отказаться от него
     */
    private function generate()
    {
        $toolkit = systemToolkit::getInstance();

        $acl = new acl($toolkit->getUser(), $this->obj_id);
        //$access = $acl->get();

        foreach ($this->actions as $key => $item) {
            if ($acl->get($key)) {
                $this->result[$key] = array(
                'url' => isset($item['url']) ? $item['url'] : (($key != 'editACL') ? $this->buildUrl($key) : $this->buildACLUrl($this->obj_id)),
                'title' => $item['title'],
                'isPopup' => isset($item['isPopup']) ? $item['isPopup'] :null,
                'icon' => SITE_PATH . $item['icon'],
                'id' => $this->getJipMenuId() . '_' . $item['controller'],
                'confirm' => $item['confirm'],
                );
            }
        }
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
        return $this->section . '_' . $this->type . '_' . $this->id;
    }

    /**
     * Возвращает отображение JIP
     *
     * @return string
     */
    public function draw()
    {
        if (empty($this->result)) {
            $this->generate();
        }

        if (sizeof($this->result)) {
            $toolkit = systemToolkit::getInstance();
            $smarty = $toolkit->getSmarty();

            $smarty->assign('jip', $this->result);
            $smarty->assign('jipMenuId', str_replace('/', '_', $this->getJipMenuId()));
            $this->result = array();

            return $smarty->fetch('jip.tpl');
        }

        return '';
    }
}

?>