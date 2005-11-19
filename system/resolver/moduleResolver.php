<?php

require_once SYSTEM_DIR . 'resolver/partialFileResolver.php';

class moduleResolver extends partialFileResolver
{
    public function __construct($resolver)
    {
        parent::__construct($resolver);
    }

    protected function partialResolve($request)
    {
        $result = null;
        
        // �������� ��� news.factory ������������ � news/news.factory
        if (preg_match('/^([a-z]+)\.factory$/i', $request, $matches) == true) {
            $request = $matches[1] . '/' . $request;
        // �������� ��� news.list.controller ������������ � news/news.list.controller
        } elseif (preg_match('/^([a-z]+)(?:\.[a-z]+){2,}$/i', $request, $matches) == true) {
            $request = $matches[1] . '/' . $request;
        }
        
        if (preg_match('/^[a-z]+\/[a-z\.]+$/i', $request) == true) {
            $result = 'modules/' . $request . '.php';
        }
        return $result;
    }
}

?>