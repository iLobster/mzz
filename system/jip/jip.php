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
     * ������������� �������
     *
     * @var integer
     */
    private $obj_id;

    /**
     * �����������
     *
     * @param string $section
     * @param string $module ��� ������
     * @param integer $id �������������
     * @param string $type ���
     * @param array $actions �������� ��� JIP
     * @param integer $obj_id ������������� �������
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
     * ���������� ������ ��� JIP �� �������������� ACL
     *
     * @param integer $obj_id ������������� �������
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
     * ���������� ������ JIP �� �������� � ������ ��� �������� ������
     *
     * @return array
     * @todo ������������ $this->type � ������������� ��� ������ ���������� �� ����
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
     * ���������� ������������� JIP-����
     *
     * @return string
     */
    private function getJipMenuId()
    {
        return $this->section . '_' . $this->module . '_' . $this->id;
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
        $smarty->assign('jipMenuId', $this->getJipMenuId());

        return $smarty->fetch('jip.tpl');
    }
}
?>