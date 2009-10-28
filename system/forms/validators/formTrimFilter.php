<?php

class formTrimFilter extends formAbstractFilter
{
    public function filter($value)
    {
    	return trim($value);
    }

}

?>