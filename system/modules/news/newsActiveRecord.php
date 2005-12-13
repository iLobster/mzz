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

    function fetch_array() {
        $data = mysqli_stmt_result_metadata($this->stmt);
        $count = 1;
        $fieldnames[0] = $this->stmt;
        while ($field = mysqli_fetch_field($data)) {
            $fieldnames[$count] = &$array[$field->name];
            $count++;
        }
        call_user_func_array('mysqli_stmt_bind_result', $fieldnames);
        mysqli_stmt_fetch($this->stmt);
        return $array;

    }

    private function process()
    {
        $this->stmt->execute();

        $this->data = $this->stmt->fetch(PDO::FETCH_ASSOC);

        $this->stmt->closeCursor();
    }

    public function delete()
    {
        return $this->tm->delete($this->get('id'));
    }
}

?>