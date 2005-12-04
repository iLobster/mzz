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
 * partialFileResolver: базовый класс для всех частичных резолверов
 * 
 * @package system
 * @subpackage resolver
 * @version 0.1
 */

class partialFileResolver
{
    /**
     * базовый резолвер
     *
     * @access private
     * @var object
     */
    private $resolver;
    
    /**
     * конструктор
     *
     * @access public
     * @param object $resolver базовый резолвер
     */
    public function __construct($resolver)
    {
        $this->resolver = $resolver;
    }
    
    /**
     * запуск процесса резолвинга
     *
     * @access public
     * @param string $request строка запроса
     * @return string|null путь до файла, если файл найден, null в противном случае
     */
    public function resolve($request)
    {
        return $this->resolver->resolve($this->partialResolve($request));
    }
    
    /**
     * модификация запроса
     * замещается в наследниках
     *
     * @access protected
     * @param string $request строка запроса
     * @return string переписанный запрос
     */
    protected function partialResolve($request)
    {
        return str_replace('*', '', $request);
    }
}

?>