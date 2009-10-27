<?php

class accessSaveController extends simpleController
{
    protected function getView()
    {
        $module_name = $this->request->getString('module_name');
        $group_id = $this->request->getInteger('group_id');

        $action = $this->request->getAction();
        $isEdit = $action == 'edit';

        $groupMapper = $this->toolkit->getMapper('user', 'group');
        $group = $groupMapper->searchByKey($group_id);

        $roleMapper = $this->toolkit->getMapper('user', 'userRole');
        $currentRoles = $roleMapper->getRolesGorGroup($module_name, $group_id);

        $validator = new formValidator();

        if (!$isEdit) {
            $groups = $roleMapper->getGroupsNotAddedYet($module_name)->toArray();
            $this->smarty->assign('groups', $groups);

            $validator->rule('required', 'group_id');
            $validator->rule('in', 'group_id', 'группа не найдена', array_keys($groups));
        }

        try {
            $module = $this->toolkit->getModule($module_name);
        } catch (mzzModuleNotFoundException $e) {
            $controller = new messageController($this->action, $e->getMessage(), messageController::WARNING);
            return $controller->run();
        }

        if ($validator->validate()) {
            if (!$isEdit) {
                $group_id = $this->request->getInteger('group_id', SC_POST);
            }

            $newRoles = $this->request->getArray('access', SC_POST);

            foreach ($module->getRoles() as $role) {
                if (empty($newRoles[$role])) {
                    if (isset($currentRoles[$role])) {
                        $roleMapper->delete($currentRoles[$role]);
                    }
                } else {
                    if (!isset($currentRoles[$role])) {
                        $newRole = $roleMapper->create();
                        $newRole->setGroup($group_id);
                        $newRole->setModule($module_name);
                        $newRole->setRole($role);
                        $roleMapper->save($newRole);
                    }
                }
            }

            return jipTools::closeWindow();
        }

        if ($isEdit) {
            $form_action = new url('accessEditModuleRoles');
            $form_action->add('group_id', $group_id);
        } else {
            $form_action = new url('accessEditRoles');
        }
        $form_action->add('module_name', $module_name);
        $form_action->setAction($action);

        $this->smarty->assign('form_action', $form_action->get());
        $this->smarty->assign('roles', $module->getRoles());
        $this->smarty->assign('current_roles', $currentRoles);

        return $this->smarty->fetch('access/save.tpl');
    }
}

?>