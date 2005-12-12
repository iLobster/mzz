<?php

class newsActiveRecord
{
    private $stmt;
    private $data = array();
    public function __construct($stmt, $tm)
    {
        $this->stmt = $stmt;
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
        $this->stmt->bind_result($id, $title, $text);
        $this->stmt->fetch();
        $this->data['id'] = $id;
        $this->data['title'] = $title;
        $this->data['text'] = $text;
    }
}

?>