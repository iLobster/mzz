<?php

class accessDeleteController extends simpleController
{
    public function getView()
    {
        $module_name = $this->request->getString('module_name');
        $group_id = $this->request->getInteger('group_id');

        $roleMapper = $this->toolkit->getMapper('user', 'userRole');
        $roleMapper->deleteRolesGorGroup($module_name, $group_id);

        return jipTools::closeWindow();
    }
}

?>