<?php

class mzzPdoStatement extends PDOStatement
{
    public function bindArray(&$data)
    {
        foreach($data as $key => $val) {
            $this->bindParam(':' . $key, $data[$key]);
        }
    }
}

?>