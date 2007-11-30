<?php

class commentsPostForm
{
    static function getForm($parent_id, $action = 'post', $comment = null)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url();
        $url->addParam($parent_id);
        $url->setAction($action);

        $form = new HTML_QuickForm('post', 'POST', $url->get());

        if ($action == 'edit') {
            $defaultValues = array();
            $defaultValues['text']  = $comment->getText();
            $form->setDefaults($defaultValues);
        }

        $form->addElement('textarea', 'text', 'Ваш комментарий', 'rows=7 cols=50');

        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();

        $form->addElement('hidden', 'url', $request->get('REQUEST_URI', 'string', SC_SERVER));

        $form->addElement('reset', 'reset', 'Отмена', 'onclick="javascript: hideJip();');
        $form->addElement('submit', 'submit', 'Отправить');

        return $form;
    }
}

?>