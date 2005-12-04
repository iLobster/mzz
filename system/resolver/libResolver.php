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

require_once systemConfig::$pathToSystem  . 'resolver/partialFileResolver.php';

class libResolver extends partialFileResolver
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
     * ????? этот резолвер написан Ќ≈¬≈–Ќќ
     * 1. если делать: fileLoader::load('Smarty/Smarty.class');, тогда отнаследовать этот резолвер от fileResolver (типа appFileResolver/sysFileResolver)
     * 2. либо сделать его полноценным партиал–езолвером и запрашивать fileLoader::load('libs/Smarty/Smarty.class');
     *
     * @access protected
     * @param string $request строка запроса
     * @return string|null переписанный запрос, если запрос совпадает с шаблоном, либо null
     */
    protected function partialResolve($request)
    {
        return 'libs/' . $request . '.php';
    }
}

?>