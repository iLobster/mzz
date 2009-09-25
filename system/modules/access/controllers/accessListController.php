<?php

class accessListController extends simpleController
{
    protected function getView()
    {
        $module_name = $this->request->getString('module_name');

        $roleMapper = $this->toolkit->getMapper('user', 'userRole');

        $groups_left = $roleMapper->getGroupsNotAddedYet($module_name);
        $roles = $roleMapper->getGroups($module_name);

        if (!$roles->count()) {
            $controller = new messageController($this->action, 'Для этого модуля не определена ни одна роль (i18n)', messageController::INFO);
            return $controller->run();
        }

        $this->smarty->assign('roles', $roles);
        $this->smarty->assign('groups_left', $groups_left);
        $this->smarty->assign('module_name', $module_name);

        return $this->smarty->fetch('access/list.tpl');
    }
}

?>