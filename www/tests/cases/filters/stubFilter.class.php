<?php

class stubFilter
{
    private $text;

    public function run($filter_chain, $response)
    {
        echo '<'.$this->getText('test') . '>';
        $filter_chain->next();
        echo '</'.$this->getText('test') . '>';
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getText($text)
    {
        return $this->text;
    }
}

?>