<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * messageViewController: контроллер для метода view модуля message
 *
 * @package modules
 * @subpackage message
 * @version 0.1
 */

class messageViewController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer');
        $messageMapper = $this->toolkit->getMapper('message', 'message');
        $message = $messageMapper->searchByKey($id);
        $category = $message->getCategory();
        $isSent = $category->getName() == 'sent';

        $me = $this->toolkit->getUser();
        $user_id = $isSent ? $message->getSender()->getId() : $message->getRecipient()->getId();

        if ($user_id != $me->getId()) {
            fileLoader::load('simple/simple403Controller');
            $controller = new simple403Controller();
            return $controller->run();
        }

        $messageCategoryMapper = $this->toolkit->getMapper('message', 'messageCategory');
        $messageCategories = $messageCategoryMapper->searchAll();
        $this->smarty->assign('categories', $messageCategories);
        $this->smarty->assign('messageCategory', $category);
        $this->smarty->assign('isSent', $isSent);

        $this->smarty->assign('message', $message);

        return $this->smarty->fetch('message/view.tpl');
    }
}

?>