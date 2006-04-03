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
     * Конструктор
     *
     * @param string $section
     * @param string $module имя модуля
     * @param string $id идентификатор
     * @param string $type тип
     * @param array $actions действия для JIP
     */
    public function __construct($section, $module, $id, $type, Array $actions)
    {
        $this->section = $section;
        $this->module = $module;
        $this->id = $id;
        $this->type = $type;
        $this->actions = $actions;
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
     * Генерирует массив JIP из названия и ссылки для действия модуля
     *
     * @return array
     * @todo использовать $this->type в идентификатор или вообще отказаться от него
     */
    private function generate()
    {
        $result = array();
        foreach ($this->actions as $item) {
            $result[] = array(
            'url' => $this->buildUrl($item['controller']),
            'title' => $item['title'],
            'id' => $this->section . '_' . $this->module . '_' . $this->id . '_' . $item['controller'],
            'confirm' => $item['confirm'],
            );
        }
        return $result;
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

        return $smarty->fetch('jip.tpl');
    }
}
?>