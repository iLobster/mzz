<?php

class FileException extends mzzException
{

  // Redefine the exception so message isn't optional
   public function __construct($message, $code = 0) {
       // some code

       $this->setName("File Exception");
       // make sure everything is assigned properly
       parent::__construct($message, $code);
   }

}

?>