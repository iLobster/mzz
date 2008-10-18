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
 * menuItem: класс для работы c данными
 *
 * @package modules
 * @subpackage menu
 * @version 0.1.1
 */

class menuItem extends simpleCatalogue
{
    protected $name = 'menu';

    protected $childrens = array();

    protected $isActive = null;

    public function getChildrens()
    {
        return $this->childrens;
    }

    public function setChildrens(Array $childrens, $parent)
    {
        foreach ($childrens as $child) {
            if ($child->isActive()) {
                $this->isActive = true;
            }
        }

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
        $lang = systemConfig::$i18nEnable ? $request->getString('lang') : null;

        switch ($this->getTypeName()) {
            case 'simple':
            case 'advanced':
                return (($full ? $request->getUrl() : '') . ($lang ? '/' . $lang : '') . $this->getPropertyValue('url'));
                break;
        }
    }

    public function isActive()
    {
        if (!is_bool($this->isActive)) {
            $toolkit = systemToolkit::getInstance();
            $request = $toolkit->getRequest();

            $lang = systemConfig::$i18nEnable ? $request->getString('lang') : null;

            switch ($this->getTypeName()) {
                case 'simple':
                    $isActive = ($request->getUrl() . ($lang ? '/' . $lang : '') . $this->getPropertyValue('url') == $request->getRequestUrl());
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
                    break;
            }

            $this->isActive = $isActive;
        }

        return $this->isActive;
    }
}

?>