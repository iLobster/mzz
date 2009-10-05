<?php

class accessListController extends simpleController
{
    protected function getView()
    {
        $module_name = $this->request->getString('module_name');
        $module = $this->toolkit->getModule($module_name);

        if (!sizeof($module->getRoles())) {
            $controller = new messageController($this->action, 'Для этого модуля не определена ни одна роль (i18n)', messageController::INFO);
            return $controller->run();
        }

        $roleMapper = $this->toolkit->getMapper('user', 'userRole');
        $groups_left = $roleMapper->getGroupsNotAddedYet($module_name);
        $roles = $roleMapper->getGroups($module_name);

        $this->smarty->assign('roles', $roles);
        $this->smarty->assign('groups_left', $groups_left);
        $this->smarty->assign('module_name', $module_name);

        return $this->smarty->fetch('access/list.tpl');
    }
}

?>