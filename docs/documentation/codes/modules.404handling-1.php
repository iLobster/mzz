<?php

class menu404Controller extends simpleController
{
    protected function getView()
    {
        return $this->smarty->fetch('menu/notfound.tpl');
    }
}

?>