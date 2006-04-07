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
 * classFileResolver: резолвит основные классы
 * Примеры:
 * (запрос -> результат)
 * core         -> core/core.php
 * module/bla   -> module/bla.php
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */

require_once systemConfig::$pathToSystem . '/resolver/partialFileResolver.php';

class classFileResolver extends partialFileResolver
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
        $result = $request;
        if (strpos($request, '/') === false) {
            $result = $request . '/' . $request;
        }
        return $result . '.php';
    }
}

?>