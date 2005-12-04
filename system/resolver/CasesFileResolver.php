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
 * CasesFileResolver: резолвит файлы с тестами
 * ѕримеры:
 * (запрос -> результат)
 * sometest.case -> cases/sometest.case.php
 * 
 * @package system
 * @subpackage resolver
 * @version 0.1
 */

require_once SystemConfig::$pathToSystem  . 'resolver/PartialFileResolver.php';

class CasesFileResolver extends PartialFileResolver
{
    /**
     * конструктор
     *
     * @access public
     * @param object $resolver базовый резолвер
     */
    public function __construct($resolver)
    {
        parent::__construct($resolver);
    }
    
    /**
     * проверка на соответствие запроса некоторому шаблону
     * определ€ем что файл действительно тот, который требуетс€
     *
     * @access protected
     * @param string $request строка запроса
     * @return string|null переписанный запрос, если запрос совпадает с шаблоном, либо null
     */
    protected function partialResolve($request)
    {
        if (strpos($request, '.case') !== false) {
            return 'cases/' . $request . '.php';
        }
        return null;
    }
}

?>