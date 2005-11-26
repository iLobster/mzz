<?php

require_once SYSTEM_DIR . 'resolver/partialFileResolver.php';

class casesFileResolver extends partialFileResolver
{
    public function __construct($resolver)
    {
        parent::__construct($resolver);
    }
    
    protected function partialResolve($request)
    {
        if (strpos($request, '.case') !== false) {
            return 'cases/' . $request . '.php';
        }
        return null;
    }
}

?>