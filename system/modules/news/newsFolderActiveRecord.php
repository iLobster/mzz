<?php

class newsFolderActiveRecord
{
    private $stmt;
    private $tm;
    private $data = false;


    function __construct($stmt, $tm)
    {
        $this->stmt = $stmt;
        $this->tm = $tm;
    }

    public function get($name)
    {
        if ($this->data == false) {
            $this->process();
        }

        return $this->data->get($name);
    }

    private function process()
    {
        $this->stmt->execute();

        $this->data = new arrayDataspace((array) $this->stmt->fetch());

        $this->stmt->closeCursor();
    }

    public function exists()
    {

        if ($this->data == false) {
            $this->process();
        }
        //return ($this->get('id') === null) ? false : true;
        return $this->data->exists('id');
    }

    public function getFolders()
    {
        return $this->tm->getFolders($this->get('id'));
    }

    public function getItems()
    {
        return $this->tm->getItems($this->get('id'));
    }
}

?>