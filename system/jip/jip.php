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
 * jip: ����� ��� ������ � jip
 *
 * @package system
 * @version 0.1.3
 */

class jip
{
    /**
     * ��� JIP-������� �� ���������
     *
     * @var string
     */
    const DEFAULT_TEMPLATE = 'jip.tpl';

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
     * ��������� ������ ������� ��������� JIP-����
     *
     * @var array
     */
    private $result = array();

    /**
     * ������ JIP-����
     *
     * @var string
     */
    private $tpl = null;

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
    public function __construct($section, $module, $id, $type, Array $actions, $obj_id, $tpl = self::DEFAULT_TEMPLATE)
    {
        $this->section = $section;
        $this->module = $module;
        $this->id = $id;
        $this->type = $type;
        $this->actions = $actions;
        $this->obj_id = $obj_id;
        $this->tpl = $tpl;
        $this->generate();
    }

    /**
     * ���������� ������ ��� JIP
     *
     * @param string $action �������� ������
     * @return string
     */
    private function buildUrl($action)
    {
        $url = new url('withId');
        $url->setSection($this->section);
        $url->setAction($action);
        $url->add('id', $this->id);
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
        $url = new url('withId');
        $url->setSection('access');
        $url->setAction('editACL');
        $url->add('id', $obj_id);
        return $url->get();
    }

    /**
     * ���������� ������ JIP �� �������� � ������ ��� �������� ������
     *
     * @return array
     */
    private function generate()
    {
        $toolkit = systemToolkit::getInstance();

        $acl = new acl($toolkit->getUser(), $this->obj_id);
        //$access = $acl->get();

        foreach ($this->actions as $key => $item) {
            if ($acl->get($key)) {
                $item['url'] = isset($item['url']) ? $item['url'] : (($key != 'editACL') ? $this->buildUrl($key) : $this->buildACLUrl($this->obj_id));
                $item['id'] = $this->getJipMenuId() . '_' . $item['controller'];
                $item['icon'] = isset($item['icon']) ? SITE_PATH . $item['icon'] : '';
                $this->result[$key] = new arrayDataspace($item);
            }
        }
    }

    /**
     * ��������� ����������� �������� � JIP-����
     *
     * @param string $name ��� ��������
     * @return boolean
     */
    public function hasItem($name)
    {
        return isset($this->result[$name]);
    }

    /**
     * ���������� ������ �� ������ ������ �������� JIP-����
     *
     * @return array
     */
    public function & getItem($name)
    {
        if (isset($this->result[$name])) {
            return $this->result[$name];
        } else {
            throw new mzzRuntimeException('�� ������ ������� "' . $name . '" � jip-���� ��� dataobject "' . $this->type . '"');
        }
    }

    /**
     * ���������� ������������� JIP-����
     *
     * @return string
     */
    private function getJipMenuId()
    {
        return $this->section . '_' . $this->type . '_' . $this->id;
    }

    /**
     * ���������� ����������� JIP
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

            return $smarty->fetch($this->tpl);
        }

        return '';
    }
}

?>