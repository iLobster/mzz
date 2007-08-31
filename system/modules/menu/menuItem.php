<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * menuItem: ����� ��� ������ c �������
 *
 * @package modules
 * @subpackage menu
 * @version 0.1.1
 */

class menuItem extends simpleCatalogue
{
    protected $name = 'menu';

    protected $childrens = false;

    public function getChildrens()
    {
        if ($this->childrens === false) {
            $this->childrens = $this->mapper->getChildrensById($this->getId());
        }
        return $this->childrens;
    }

    public function setChildrens(Array $childrens)
    {
        $this->childrens = $childrens;
    }

    public function move($target)
    {
        $this->mapper->move($this, $target);
    }

    public function getUrl($full = true)
    {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();

        switch ($this->getTypeName()) {
            case 'simple':
                return (($full ? $request->getUrl() : '') . $this->getPropertyValue('url'));
                break;

            case 'advanced':
                return (($full ? $request->getUrl() : '') . $this->getPropertyValue('url'));
                break;
        }
    }

    public function isActive()
    {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();

        switch ($this->getTypeName()) {
            case 'simple':
                return ($request->getUrl() . $this->getPropertyValue('url') == $request->getRequestUrl());
                break;

            case 'advanced':
                $section = $this->getPropertyValue('section');
                $action = $this->getPropertyValue('action');

                $isActive = false;
                if (!empty($section)) {
                    $isActive = ($request->getRequestedSection() == $section);
                }

                if ($isActive && !empty($action)) {
                    $isActive = ($request->getRequestedAction() == $action);
                }

                return $isActive;
                break;
        }
    }

    protected function getJipView($module, $id, $type, $tpl = jip::DEFAULT_TEMPLATE)
    {
        $toolkit = systemToolkit::getInstance();
        $action = $toolkit->getAction($module);
        $request = $toolkit->getRequest();

        $jip = new jip($request->getSection(), $module, $id, $type, $action->getJipActions($type), $this->getObjId(), $tpl);

        $url = new url('menuMoveAction');
        $url->add('id', $id);

        if ($jip->hasItem('up')) {
            $act = &$jip->getItem('up');
            $url->add('target', 'up');
            $act['url'] = $url->get();
        }

        if ($jip->hasItem('down')) {
            $act = &$jip->getItem('down');
            $url->add('target', 'down');
            $act['url'] = $url->get();
        }
        return $jip->draw();
    }
}

?>