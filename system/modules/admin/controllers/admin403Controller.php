<?php

class admin403Controller extends simpleController
{
    protected function getView()
    {
        return $this->view->render('admin/403.tpl');
    }
}

?>