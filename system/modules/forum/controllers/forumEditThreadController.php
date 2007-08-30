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
 * forumEditThreadController: контроллер для метода editThread модуля forum
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class forumEditThreadController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer');

        $threadMapper = $this->toolkit->getMapper('forum', 'thread');

        $thread = $threadMapper->searchByKey($id);

        $validator = new formValidator();

        $validator->add('required', 'title', 'Необходимо дать название треду');
        $validator->add('required', 'text', 'Необходимо написать сообщение');

        if ($validator->validate()) {
            $thread->setTitle($this->request->get('title', 'string', SC_POST));
            $thread->setIsClosed($this->request->get('closed', 'boolean', SC_POST));
            $threadMapper->save($thread);

            $post = $thread->getFirstPost();
            $post->setText($this->request->get('text', 'string', SC_POST));
            $post->getMapper()->save($post);

            $url = new url('withId');
            $url->add('id', $id);
            $url->setAction('thread');

            $response = $this->toolkit->getResponse();
            $response->redirect($url->get());

            return;
        }

        $url = new url('withId');
        $url->add('id', $id);
        $url->setAction('editThread');

        $this->smarty->assign('thread', $thread);
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('action', $url->get());
        return $this->smarty->fetch('forum/editThread.tpl');
    }
}

?>