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
 * jip: ����� ��� ������ � jip
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
     * ��� ������
     *
     * @var string
     */
    private $module;

    /**
     * �������������
     *
     * @var string
     */
    private $id;

    /**
     * ���
     *
     * @var string
     */
    private $type;

    /**
     * �������� ��� JIP
     *
     * @var array
     */
    private $actions;

    /**
     * �����������
     *
     * @param string $section
     * @param string $module ��� ������
     * @param string $id �������������
     * @param string $type ���
     * @param array $actions �������� ��� JIP
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
     * ���������� ������ ��� JIP
     *
     * @param string $action �������� ������
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
     * ���������� ������ JIP �� �������� � ������ ��� �������� ������
     *
     * @return array
     * @todo ������������ $this->type � ������������� ��� ������ ���������� �� ����
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
     * ���������� ����������� JIP
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