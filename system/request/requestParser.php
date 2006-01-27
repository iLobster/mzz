<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * RequestParser: класс для получения секции, действия и других параметров
 *
 * @package system
 * @subpackage request
 * @version 0.2
 */
class requestParser
{
    /**
     * URL-Rewriter
     *
     * @var object Rewrite
     */
    protected $rewrite;

    /**
     * Constructor
     */
    public function __construct($rewrite)
    {
        $this->rewrite = $rewrite;
    }

    /**
     * Разборка URL на section, action, params.
     *
     * @param object $request
     */
    public function parse($request)
    {
        $params = $this->extractParams($request->get('path'));
        $section = array_shift($params);

       // $this->rewrite->getRules($section);
        //$path = $this->rewrite->process($request->get('path'));
        $params = $this->extractParams($request->get('path'));

        $section = array_shift($params);
        $request->setSection($section);

        $action = array_pop($params);
        $request->setAction($action);

        /* DEPRECATED
        // Если action задан, то заносим его так же и в params,
        // который будет использован как параметр,
        // если указанный action не существует
        if (!empty($action)) {
            $params = array_merge($params, array($action));
        }
        */
        $request->setParams($params);
    }

    /**
     * Очищает строку запроса от лишних "/" и возвращает
     * разобранный запрос на массив
     *
     * @param string $path
     * @return array
     */
    protected function extractParams($path) {
        $path = preg_replace('/\/{2,}/', '/', $path);
        return explode('/', substr($path, 1, (strlen($path) - 1) - (strrpos($path, '/') == strlen($path) - 1)));
    }

}

?>