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
 * item: класс для работы c данными
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class item extends simpleCatalogue
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

    public function getUrl()
    {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();

        switch ($this->getTypeName()) {
            case 'simple':
                return ($request->getUrl() . '/' . $this->getPropertyValue('url'));
                break;

            case 'advanced':
                return ($request->getUrl() . '/' . $this->getPropertyValue('url'));
                break;
        }
    }

    public function isActive()
    {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();

        switch ($this->getTypeName()) {
            case 'simple':
                return ($request->getUrl() . '/' . $this->getPropertyValue('url') == $request->getRequestUrl());
                break;

            case 'advanced':
                $section = $this->getPropertyValue('section');
                $action = $this->getPropertyValue('action');

                $smarty = $toolkit->getSmarty();

                $isActive = false;
                if (!empty($section)) {
                    $current_section = $smarty->get_template_vars('current_section');
                    $isActive = ($current_section == $section) ? true : false;
                }

                if (!empty($action)) {
                    $current_action = $smarty->get_template_vars('current_action');
                    $isActive = ($current_action == $action) ? true : false;
                }

                return $isActive;
                break;
        }
    }
}

?>