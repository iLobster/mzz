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

fileLoader::load('simple/simpleForTree');

/**
 * menu: класс для работы c данными
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menu extends simple
{
    protected $name = 'menu';

    public function searchItems()
    {
        return $this->mapper->searchItemsById($this->getId());
    }

    protected function getJipView($module, $id, $type)
    {
        $toolkit = systemToolkit::getInstance();
        $action = $toolkit->getAction($module);
        $request = $toolkit->getRequest();

        $create['create'] = array(
            'controller' => 'save',
            'title' => 'Создать подпункт',
            'icon' => '/templates/images/add.gif',
            'confirm' => ''
        );

        $actions = $create + $action->getJipActions($type);

        $jip = new jip($request->getSection(), $module, $id, $type, $actions, $this->getObjId());
        return $jip->draw();
    }
}

?>