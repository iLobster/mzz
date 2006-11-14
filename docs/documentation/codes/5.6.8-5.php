<?php

class commentsFolderPostView extends simpleView
{
    public function toString()
    {
        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $this->DAO->accept($renderer);

        $this->smarty->assign('form', $renderer->toArray());

        return $this->smarty->fetch('comments.post.tpl');
    }
}

?>