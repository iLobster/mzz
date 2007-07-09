<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
*/

/**
 * accessEditOwnerController: ���������� ��� ������ editOwner ������ access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */
class accessEditOwnerController extends simpleController
{
    protected function getView()
    {
        $class = $this->request->get('class_name', 'string');
        $section = $this->request->get('section_name', 'string');

        $acl = new acl($this->toolkit->getUser(), 0, $class, $section);

        $action = $this->toolkit->getAction($acl->getModule($class));
        $actions = $action->getActions(true);

        $actions = $actions[$class];

        if ($this->request->getMethod() == 'POST') {
            $setted = $this->request->get('access', 'array', SC_POST);

            $result = array();
            foreach ($actions as $key => $val) {
                $result[$key]['allow'] = isset($setted[$key]) && isset($setted[$key]['allow']) && $setted[$key]['allow'];
                $result[$key]['deny'] = isset($setted[$key]) && isset($setted[$key]['deny']) && $setted[$key]['deny'];
            }

            $acl->setDefault(0, $result, true);

            return jipTools::closeWindow();
        }

        $this->smarty->assign('acl', $acl->getForOwner(true));
        $this->smarty->assign('actions', $actions);
        $this->smarty->assign('class', $class);
        $this->smarty->assign('section', $section);

        $this->response->setTitle('ACL -> ����� ��� ��������� �������');

        return $this->smarty->fetch('access/editOwner.tpl');
    }
}

?>