<?php

class newsActiveRecord
{
    private $stmt;
    private $data = false;
    private $tm;

    public function __construct($stmt, $tm)
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

    public function extract()
    {
        if ($this->data == false) {
            $this->process();
        }

        return $this->data->export();
    }

    public function replaceData($data)
    {
        $this->data = new arrayDataspace($data);
    }

    private function process()
    {
        $this->stmt->execute();

        $this->data = new arrayDataspace((array) $this->stmt->fetch(PDO::FETCH_ASSOC));

        $this->stmt->closeCursor();
    }

    public function delete()
    {
        return $this->tm->delete($this->get('id'));
    }

    public function update($data)
    {
        return $this->tm->update($data);
    }
}

?>