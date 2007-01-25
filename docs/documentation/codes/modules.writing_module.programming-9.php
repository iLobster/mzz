<?php

class commentsPostSuccessView extends simpleView
{
    public function toString()
    {
        header('Location: ' . $this->DAO);
        exit;
    }
}

?>