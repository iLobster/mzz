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
 * userGroupDeleteController: ���������� ��� ������ groupDelete ������ user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

fileLoader::load('user/views/userGroupDeleteView');

class userGroupDeleteController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);

        // ��������� ������������� �� ���� ������
        $userGroupMapper = $this->toolkit->getMapper('user', 'userGroup', $this->request->getSection());
        $groups = $userGroupMapper->searchAllByField('group_id', $id);

        foreach ($groups as $val) {
            $userGroupMapper->delete($val->getId());
        }

        // ������� ������
        $groupMapper = $this->toolkit->getMapper('user', 'group', $this->request->getSection());
        $groupMapper->delete($id);

        return new userGroupDeleteView();
    }
}

?>