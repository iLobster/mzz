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
 * menuFolder: ����� ��� ������ c �������
 *
 * @package modules
 * @subpackage menu
 * @version 0.1
 */

class menuFolder extends simple
{
    protected $name = 'menu';

    protected function getJipView($module, $id, $type)
    {
        $toolkit = systemToolkit::getInstance();
        $action = $toolkit->getAction($module);
        $request = $toolkit->getRequest();

        $jip = new jip($request->getSection(), $module, $id, $type, $action->getJipActions($type), $this->getObjId());

        $url = new url('default2');
        $url->setSection($request->getSection());
        $url->setAction('addmenu');

        $createAction = &$jip->getItem('addmenu');
        $createAction['url'] = $url->get();
        return $jip->draw();
    }
}

?>