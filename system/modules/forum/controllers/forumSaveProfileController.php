<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('forms/validators/formValidator');

/**
 * forumSaveProfileController: контроллер для метода editProfile модуля forum
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class forumSaveProfileController extends simpleController
{
    protected function getView()
    {
        $action = $this->request->getAction();
        $isEdit = ($action == 'editProfile');

        $id = $this->request->get('id', 'integer');

        $profileMapper = $this->toolkit->getMapper('forum', 'profile');
        $profile = $profileMapper->searchById($id);

        if (!$profile) {
            return $profileMapper->get404()->run();
        }

        $validator = new formValidator();
        if ($validator->validate()) {
            $signature = $this->request->get('signature', 'string', SC_POST);

            $profile->setSignature($signature);
            $profileMapper->save($profile);

            $url = new url('withId');
            $url->setAction('profile');
            $url->add('id', $id);

            $response = $this->toolkit->getResponse();
            $response->redirect($url->get());
            //return null;
        }

        $this->smarty->assign('profile', $profile);
        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('errors', $validator->getErrors());
        return $this->smarty->fetch('forum/saveProfile.tpl');
    }
}

?>