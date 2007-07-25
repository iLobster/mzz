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
 * votingAdminController: контроллер для метода admin модуля voting
 *
 * @package modules
 * @subpackage voting
 * @version 0.1
 */

class votingAdminController extends simpleController
{
    public function getView()
    {
        $questionMapper = $this->toolkit->getMapper('voting', 'question');
        $folderMapper = $this->toolkit->getMapper('voting', 'voteFolder');
        $questions = $questionMapper->searchAll();

        $this->smarty->assign('questions', $questions);
        $this->smarty->assign('folder', $folderMapper->getFolder());
        return $this->smarty->fetch('voting/admin.tpl');
    }
}

?>