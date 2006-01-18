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
 * moduleResolver: резолвит файлы модулей
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */

require_once systemConfig::$pathToSystem . 'resolver/partialFileResolver.php';

class moduleResolver extends partialFileResolver
{
    /**
     * конструктор
     *
     * @param object $resolver базовый резолвер
     */
    public function __construct(iResolver $resolver)
    {
        parent::__construct($resolver);
    }

    /**
     * проверка на соответствие запроса некоторому шаблону
     * определяем что файл действительно тот, который требуется
     *
     * @param string $request строка запроса
     * @return string|null переписанный запрос, если запрос совпадает с шаблоном, либо null
     */
    protected function partialResolve($request)
    {
        $result = null;

        // короткий вид news.factory переписываем в news/news.factory
        if (preg_match('/^([a-z]+)\.factory$/i', $request, $matches) == true) {
            $request = $matches[1] . '/' . $request;
            // короткий вид news.list.controller переписываем в news/news.list.controller
        } elseif (preg_match('/^([a-z]+)(?:\.[a-z]+){2,}$/i', $request, $matches) == true) {
            $request = $matches[1] . '/' . $request;
        }

        if (preg_match('/^[a-z]+\/[a-z\.]+$/i', $request) == true) {
            $result = 'modules/' . $request;
        }
        $ext = substr(strrchr($request, '.'), 1);
        if ($ext != 'php' && $ext != 'ini') {
            $result .= '.php';
        }
        return $result;
    }
}

?>