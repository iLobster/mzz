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
 * userMemberOfController: контроллер для метода memberOf модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

fileLoader::load('user/views/userMemberOfView');

class userMemberOfController extends simpleController
{
    public function getView()
    {
        $groupMapper = $this->toolkit->getMapper('user', 'group', $this->request->getSection());

        if (($id = $this->request->get('id', 'integer', SC_PATH)) == null) {
            $id = $this->request->get('id', 'integer', SC_POST);
        }

        $userGroupMapper = $this->toolkit->getMapper('user', 'userGroup', $this->request->getSection());

        list($result, $selected) = $userGroupMapper->searchAllByUserId($id);

        if ($this->request->getMethod() == 'POST') {
            $groups = $this->request->get('groups', 'array', SC_POST);

            if (is_null($groups)) {
                $groups = array();
            }

            $removed = array_diff_key($selected, $groups);
            $added = array_diff_key($groups, $selected);

            if (sizeof($removed)) {

                foreach ($removed as $key => $val) {
                    $userGroupMapper->deleteByGroupId(array_keys($removed), $id);
                }
            }

            if (sizeof($added)) {


                foreach ($added as $key => $val) {
                    $userGroup = $userGroupMapper->create();
                    $userGroup->setUser($id);
                    $userGroup->setGroup($key);
                    $userGroupMapper->save($userGroup);
                }
            }

            fileLoader::load('user/views/userMemberOfSuccessView');
            return new userMemberOfSuccessView();
        }

        $userMapper = $this->toolkit->getMapper('user', 'user', $this->request->getSection());
        $user = $userMapper->searchById($id);

        return new userMemberOfView($groupMapper, $id, $result, $selected, $user);
    }
}

?>