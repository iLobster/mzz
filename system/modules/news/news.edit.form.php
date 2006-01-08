<?php

class newsEditForm {
    static function getForm($tableModule,  $params)
    {
        require_once 'HTML/QuickForm.php';
        require_once 'HTML/QuickForm/Renderer/ArraySmarty.php';

        // ��������� ������ ����� �� � ����� ???
        $data = $tableModule->getNews($params[0]);

        $form = new HTML_QuickForm('form', 'POST');
        $defaultValues = array();
        $defaultValues['title']  = $data->get('title');
        $defaultValues['text']  = $data->get('text');
        $form->setDefaults($defaultValues);

        $form->addElement('text', 'title', '���:', 'size=30');
        $form->addElement('textarea', 'text', '�����:', 'rows=7 cols=50');
        $form->addElement('hidden', 'path', '/news/edit');
        $form->addElement('hidden', 'id', $data->get('id'));
        $form->addElement('reset', 'reset', '�����');
        $form->addElement('submit', 'submit', '���������');
        return $form;
    }
}

?>