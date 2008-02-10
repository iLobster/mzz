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
 * messageListController: контроллер для метода list модуля message
 *
 * @package modules
 * @subpackage message
 * @version 0.1
 */

class messageListController extends simpleController
{
    public function getView()
    {
        $name = $this->request->getString('name');
        $isSent = $name == 'sent';

        $messageCategoryMapper = $this->toolkit->getMapper('message', 'messageCategory');
        $messageCategory = $messageCategoryMapper->searchOneByField('name', $name);

        if (empty($messageCategory)) {
            return $messageCategoryMapper->get404()->run();
        }

        $me = $this->toolkit->getUser();

        $messageMapper = $this->toolkit->getMapper('message', 'message');
        $criteria = new criteria();
        $criteria->add('category_id', $messageCategory->getId());
        $criteria->add($isSent ? 'sender' : 'recipient', $me->getId());
        $messages = $messageMapper->searchAllByCriteria($criteria);

        $messageCategories = $messageCategoryMapper->searchAll();

        $this->smarty->assign('current', $name);
        $this->smarty->assign('messages', $messages);
        $this->smarty->assign('isSent', $isSent);
        $this->smarty->assign('categories', $messageCategories);
        $this->smarty->assign('messageCategory', $messageCategory);
        return $this->smarty->fetch('message/list.tpl');
    }
}

?>