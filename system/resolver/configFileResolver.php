<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2005
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * configFileResolver: резолвит файлы конфигурации
 * ѕримеры:
 * (запрос -> результат)
 * configs/someconfig.ext   -> configs/someconfig.ext
 * notconfig/somefile       -> null
 * 
 * @package system
 * @subpackage resolver
 * @version 0.1
 */

require_once SYSTEM_DIR . 'resolver/partialFileResolver.php';

class configFileResolver extends partialFileResolver
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
        if (strpos($request, 'configs/') === 0) {
            return $request;
        }
        return null;
    }
}

?>