<?php

require_once SYSTEM_DIR . 'resolver/partialFileResolver.php';

class configFileResolver extends partialFileResolver
{
    public function __construct($resolver)
    {
        parent::__construct($resolver);
    }
    
    protected function partialResolve($request)
    {
        if (strpos($request, 'configs/') === 0) {
            return $request;
        }
        return null;
    }
}

?>