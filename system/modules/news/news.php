<?php

class news
{
    private $title;
    private $text;
    private $folder_id;

    public function getTitle()
    {
        return $this->title;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getFolderId()
    {
        return $this->folder_id;
    }

    public function setTitle($value)
    {
        $this->title = $value;
    }

    public function setText($value)
    {
        $this->text = $value;
    }

    public function setFolderId($value)
    {
        $this->folder_id = $value;
    }
}

?>