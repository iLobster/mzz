<?php

require_once SYSTEM_DIR . 'resolver/partialFileResolver.php';

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