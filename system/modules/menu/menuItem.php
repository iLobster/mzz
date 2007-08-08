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
 * menuItem: класс дл€ работы c данными
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

        $url = new url('menuMoveAction');
        $url->add('id', $id);

        $items = array();
        $url->add('target', 'up');
        $items['up'] = array(
            'url' => $url->get(),
            'controller' => 'move',
            'title' => '¬верх',
            'icon' => '/templates/images/arrow_up.gif',
            'confirm' => ''
        );

        $url->add('target', 'down');
        $items['down'] = array(
            'url' => $url->get(),
            'controller' => 'move',
            'title' => '¬низ',
            'icon' => '/templates/images/arrow_down.gif',
            'confirm' => ''
        );

        $create['create'] = array(
            'url' => $url->get(),
            'controller' => 'save',
            'title' => '—оздать пункт',
            'icon' => '/templates/images/add.gif',
            'confirm' => ''
        );

        $actions = $items + $action->getJipActions($type);

        $jip = new jip($request->getSection(), $module, $id, $type, $actions, $this->getObjId(), $tpl);
        return $jip->draw();
    }
}

?>