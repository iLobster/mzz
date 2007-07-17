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
 * messageDeleteController: контроллер для метода delete модуля message
 *
 * @package modules
 * @subpackage message
 * @version 0.1
 */

class messageDeleteController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer');
        $messageMapper = $this->toolkit->getMapper('message', 'message');
        $message = $messageMapper->searchByKey($id);

        if (!$message) {
            return $messageMapper->get404()->run();
        }

        $category = $message->getCategory();
        $isSent = $category->getName() == 'sent';

        $me = $this->toolkit->getUser();
        $user_id = $isSent ? $message->getSender()->getId() : $message->getRecipient()->getId();

        if ($user_id != $me->getId()) {
            fileLoader::load('simple/simple403Controller');
            $controller = new simple403Controller();
            return $controller->run();
        }

        if ($message->getCategory()->getName() != 'recycle') {
            $messageCategoryMapper = $this->toolkit->getMapper('message', 'messageCategory');
            $recycle = $messageCategoryMapper->searchOneByField('name', 'recycle');
            $message->setCategory($recycle);
            $messageMapper->save($message);
        } else {
            $messageMapper->delete($message->getId());
        }

        return jipTools::redirect();
    }
}

?>