<?php

class newsActiveRecord
{
    private $stmt;
    private $data = array();
    private $tm;

    public function __construct($stmt, $tm)
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

    public function extract()
    {
        if (sizeof($this->data) === 0) {
            $this->process();
        }

        return $this->data;
    }

    public function replaceData($data)
    {
        $this->data = $data;
    }

    private function process()
    {
        $this->stmt->execute();

        $this->data = $this->stmt->fetch(PDO::FETCH_ASSOC);

        //$this->stmt->closeCursor();
    }

    public function delete()
    {
        return $this->tm->delete($this->get('id'));
    }
}

?>