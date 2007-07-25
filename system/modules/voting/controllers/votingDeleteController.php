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
 * votingDeleteController: контроллер для метода delete модуля voting
 *
 * @package modules
 * @subpackage voting
 * @version 0.1
 */

class votingDeleteController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer');
        $questionMapper = $this->toolkit->getMapper('voting', 'question');

        $question = $questionMapper->searchById($id);

        if ($question) {
            $questionMapper->delete($question);
        }

        return jipTools::redirect();
    }
}

?>