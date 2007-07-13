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

fileLoader::load('forms/validators/formValidator');

/**
 * votingSaveController: контроллер для метода save модуля voting
 *
 * @package modules
 * @subpackage voting
 * @version 0.1
 */

class votingSaveController extends simpleController
{
    public function getView()
    {
        $questionMapper = $this->toolkit->getMapper('voting', 'question');
        $action = $this->request->getAction();
        $isEdit = ($action == 'edit');

        $id = $this->request->get('id', 'integer');
        $vote = ($isEdit) ? $questionMapper->searchById($id) : $questionMapper->create();

        $validator = new formValidator();
        $validator->add('required', 'name', 'Необходимо задать имя голосования');
        $validator->add('required', 'question', 'Необходимо задать тему голосования');

        if (!$validator->validate()) {
            $url = new url(($isEdit) ? 'withId' : 'default2');
            $url->setAction($action);
            $url->addParam('id', $id);

            $this->smarty->assign('vote', $vote);
            $this->smarty->assign('action', $url->get());
            $this->smarty->assign('errors', $validator->getErrors());
            $this->smarty->assign('isEdit', $isEdit);
            return $this->smarty->fetch('voting/save.tpl');
        } else {
            $name = $this->request->get('name', 'string', SC_POST);
            $question = $this->request->get('question', 'string', SC_POST);

            $vote->setName($name);
            $vote->setQuestion($question);
            $questionMapper->save($vote);

            return jipTools::redirect();
        }
    }
}

?>