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

fileLoader::load('forms/validators/formValidator');

/**
 * userGroupEditController: ���������� ��� ������ groupEdit ������ user
 *
 * @package modules
 * @subpackage user
 * @version 0.2
 */
class userGroupEditController extends simpleController
{
    public function getView()
    {
        $groupMapper = $this->toolkit->getMapper('user', 'group');
        $id = $this->request->get('id', 'integer', SC_PATH | SC_POST);

        $group = $groupMapper->searchById($id);

        $action = $this->request->getAction();
        $isEdit = ($action == 'groupEdit');

        if (!$group && $isEdit) {
            return $groupMapper->get404()->run();
        }

        $validator = new formValidator();
        $validator->add('required', 'name', '������������ ��� ���������� ����');
        $validator->add('callback', 'name', '������ � ����� ������ ��� ����������', array('checkUniqueGroupName', $group, $groupMapper));

        if ($validator->validate()) {
            if (!$isEdit) {
                $group = $groupMapper->create();
            }

            $name = $this->request->get('name', 'string', SC_POST);
            $is_default = $this->request->get('is_default', 'boolean', SC_POST);
            $group->setName($name);
            $group->setIsDefault($is_default);
            $groupMapper->save($group);

            return jipTools::redirect();
        }


        $url = new url('default2');
        $url->setAction($action);

        if ($isEdit) {
            $url->setRoute('withId');
            $url->addParam('id', $group->getId());
        }

        $group = ($isEdit) ? $group : $groupMapper->create();
        $this->smarty->assign('group', $group);
        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('errors', $validator->getErrors());
        return $this->smarty->fetch('user/groupEdit.tpl');
    }
}

function checkUniqueGroupName($name, $group, $groupMapper)
{
    if (is_object($group) && $name === $group->getName()) {
        return true;
    }

    $group = $groupMapper->searchByName($name);
    return empty($group);
}

?>