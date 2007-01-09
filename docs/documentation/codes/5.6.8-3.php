<?php

class commentsPostForm
{
    static function getForm($parent_id)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url();
        $url->addParam($parent_id);
        $url->setAction('post');

        $form = new HTML_QuickForm('post', 'POST', $url->get());

        $form->addElement('textarea', 'text', '��� �����������', 'rows=7 cols=50');

        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();

        $form->addElement('hidden', 'url', $request->get('REQUEST_URI', 'string', SC_SERVER));

        $form->addElement('reset', 'reset', '�����');
        $form->addElement('submit', 'submit', '���������');

        return $form;
    }
}

?>