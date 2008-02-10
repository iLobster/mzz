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

/**
 * forumProfileController: контроллер для метода profile модуля forum
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class forumProfileController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');

        $profileMapper = $this->toolkit->getMapper('forum', 'profile');
        $profile = $profileMapper->searchById($id);

        if (!$profile) {
            return $profileMapper->get404()->run();
        }

        $this->smarty->assign('profile', $profile);
        return $this->smarty->fetch('forum/profile.tpl');
    }
}

?>