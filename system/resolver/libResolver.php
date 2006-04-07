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
 * libResolver: резолвит файлы сторонних библиотек
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */

require_once systemConfig::$pathToSystem  . '/resolver/partialFileResolver.php';

class libResolver extends partialFileResolver
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
        if (strpos($request, 'libs/') === 0) {
            return $request . '.php';
        } else {
            return null;
        }
    }
}

?>