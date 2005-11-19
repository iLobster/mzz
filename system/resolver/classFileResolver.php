<?php

require_once SYSTEM_DIR . 'resolver/partialFileResolver.php';

class classFileResolver extends partialFileResolver
{
    public function __construct($resolver)
    {
        parent::__construct($resolver);
    }
    
    protected function partialResolve($request)
    {
        $result = $request;
        if (strpos($request, '/') === false) {
            $result = $request . '/' . $request;
        }
        return $result . '.php';
    }
}

?>