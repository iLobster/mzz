<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

/**
 * jip: класс для работы с jip
 *
 * @package system
 * @version 0.1
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
    }

    /**
     * Генерирует ссылку для JIP
     *
     * @param string $action действие модуля
     * @return string
     */
    private function buildUrl($action)
    {
        $url = new url();
        $url->setSection($this->section);
        $url->setAction($action);
        $url->addParam($this->id);
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
        $url = new url();
        $url->setSection('access');
        $url->setAction('editACL');
        $url->addParam($obj_id);
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
        $result = array();
        foreach ($this->actions as $key => $item) {
            $url = new url();
            $icon = $item['icon'];
            if (strpos($icon, '/') === 0) {
                $icon = substr($icon, 1);
            }
            $url->addParam($icon);
            $url->setSection('');

            $result[] = array(
            'url' => ($key != 'editACL') ? $this->buildUrl($key) : $this->buildACLUrl($this->obj_id),
            'title' => $item['title'],
            'icon' => $url->get(),
            'id' => $this->getJipMenuId() . '_' . $item['controller'],
            'confirm' => $item['confirm'],
            );
        }
        return $result;
    }

    /**
     * Возвращает идентификатор JIP-меню
     *
     * @return string
     */
    private function getJipMenuId()
    {
        return $this->section . '_' . $this->module . '_' . $this->id;
    }

    /**
     * Возвращает отображение JIP
     *
     * @return string
     */
    public function draw()
    {
        $toolkit = systemToolkit::getInstance();
        $smarty = $toolkit->getSmarty();

        $smarty->assign('jip', $this->generate());
        $smarty->assign('jipMenuId', $this->getJipMenuId());

        return $smarty->fetch('jip.tpl');
    }
}
?>