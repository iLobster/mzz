<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

/**
 * userViewView: вид для метода view модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

class userLoginformView extends simpleView
{
    public function __construct($form)
    {
        $this->form = $form;
        parent::__construct(null);
    }

    public function toString()
    {
        //fileLoader::load('libs/PEAR/HTML/QuickForm');
        //fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $this->form->accept($renderer);

        $this->smarty->assign('form', $renderer->toArray());
        $this->smarty->assign('user', $this->DAO);
        $this->response->setTitle('Пользователь -> Авторизация');

        return $this->smarty->fetch('user.login.tpl');
    }
}

?>
