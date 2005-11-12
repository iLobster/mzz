<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2005
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

/**
 * response
 * 
 * @package system
 * @version 0.1
 */

class response
{
    private $response = '';
    
    public function __construct()
    {
        
    }
    
    public function send()
    {
        $this->sendText();
    }
    
    public function append($string)
    {
        $this->response .= $string;
    }
    
    private function sendText()
    {
        echo $this->response;
    }
    
}

?>