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
 * forumCreateForumController: контроллер для метода createForum модуля forum
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class forumSaveForumController extends simpleController
{
    public function getView()
    {
        $action = $this->request->getAction();
        $isEdit = $action == 'editForum';

        $id = $this->request->get('id', 'integer');

        $forumMapper = $this->toolkit->getMapper('forum', 'forum');

        if ($isEdit) {
            $forum = $forumMapper->searchByKey($id);
        } else {
            $forum = $forumMapper->create();
        }

        $validator = new formValidator();

        $validator->add('required', 'title', 'Необходимо дать название форуму');
        $validator->add('numeric', 'order', 'Значение порядка сортировки должно быть числовым');

        if ($validator->validate()) {
            if (!$isEdit) {
                $categoryMapper = $this->toolkit->getMapper('forum', 'category');
                $category = $categoryMapper->searchByKey($id);
                $forum->setCategory($category);
            }

            $forum->setTitle($this->request->get('title', 'string', SC_POST));
            $forum->setOrder($this->request->get('order', 'integer', SC_POST));
            $forum->setDescription($this->request->get('description', 'string', SC_POST));
            $forumMapper->save($forum);

            return jipTools::redirect();
        }

        $url = new url('withId');
        $url->add('id', $id);
        $url->setAction($action);

        $this->smarty->assign('forum', $forum);
        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('action', $url->get());
        return $this->smarty->fetch('forum/saveForum.tpl');
    }
}

?>