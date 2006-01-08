<?php

class newsSuccessEditView extends simpleView
{
    protected $form;

    public function __construct($tableModule, $form, $params = array())
    {
        $this->form = $form;
        parent::__construct($tableModule, $params);
    }

    public function toString()
    {

        $values = $this->form->exportValues();
        $this->tableModule->update($values);
        header('Location: /news/' . $values['id'] . '/view');
        exit;

    }

}
?>