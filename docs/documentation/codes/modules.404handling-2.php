<?php

class news404Controller extends simpleController
{
    protected function getView()
    {
        $this->response->setTitle('������. ������������� ������� �� �������.');
        return $this->smarty->fetch('news/notfound.tpl');
    }
}

?>