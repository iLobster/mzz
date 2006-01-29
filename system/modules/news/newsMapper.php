<?php

class newsMapper
{
    private $db;
    private $map = array();

    public function __construct()
    {
        $this->db = DB::factory();
    }
}

?>