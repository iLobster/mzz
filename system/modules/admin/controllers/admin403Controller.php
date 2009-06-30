<?php

class admin403Controller extends simpleController
{
    protected function getView()
    {
        return $this->smarty->fetch('admin/403.tpl');
    }
}

?>