<?php

class newsFolderActiveRecord
{
    private $stmt;
    private $tm;
    private $data;

    function __construct($stmt, $tm)
    {
        $this->stmt = $stmt;
        $this->tm = $tm;
    }

    public function get($name)
    {
        if (sizeof($this->data) === 0) {
            $this->process();
        }

        return (isset($this->data[$name])) ? $this->data[$name] : null;
    }

    private function process()
    {
        $this->stmt->execute();

        $this->data = $this->stmt->fetch();

        $this->stmt->closeCursor();
    }
}

?>