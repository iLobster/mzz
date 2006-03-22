<?php

class stubFilter implements iFilter
{
    private $text;

    public function run(filterChain $filter_chain, $response, iRequest $request)
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