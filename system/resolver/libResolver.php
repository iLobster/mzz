<?php

require_once systemConfig::$pathToSystem  . 'resolver/partialFileResolver.php';

class libResolver extends partialFileResolver
{
    public function __construct($resolver)
    {
        parent::__construct($resolver);
    }

    protected function partialResolve($request)
    {
        return 'libs/' . $request . '.php';
    }
}

?>