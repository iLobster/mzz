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
 * votingResultsController: контроллер для метода results модуля voting
 *
 * @package modules
 * @subpackage voting
 * @version 0.1
 */

class votingResultsController extends simpleController
{
    public function getView()
    {
        $id = $this->request->getInteger('id');
        $questionMapper = $this->toolkit->getMapper('voting', 'question');

        $question = $questionMapper->searchById($id);

        $this->smarty->assign('question', $question);
        return $this->smarty->fetch('voting/results.tpl');
    }
}

?>