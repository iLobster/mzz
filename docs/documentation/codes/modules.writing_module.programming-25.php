<?php

class commentsFolderPostView extends simpleView
{
    private $action;

    public function __construct($form, $action = 'post')
    {
        $this->action = $action;
        parent::__construct($form);
    }

    public function toString()
    {
        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $this->DAO->accept($renderer);

        $this->smarty->assign('action', $this->action);
        $this->smarty->assign('form', $renderer->toArray());

        return $this->smarty->fetch('comments.post.tpl');
    }
}

?>