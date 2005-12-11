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
 * fileLoader: класс для загрузки/поиска файлов по запросу
 *
 * @package system
 * @subpackage core
 * @version 0.1
 */

class fileLoader
{
    /**
     * стэк резолверов
     *
     * @access private
     * @static
     * @var array
     */
    private static $stack = array();

    /**
     * текущий резолвер
     *
     * @access private
     * @static
     * @var object
     */
    private static $resolver;

    /**
     * список уже загруженных файлов
     *
     * @var array
     */
    private static $files = array();

    /**
     * установка нового резолвера в качестве текущего
     * предыдущий переносится в стэк
     *
     * @access public
     * @param object $resolver
     */
    public static function setResolver($resolver)
    {
        array_push(self::$stack, self::$resolver);
        self::$resolver = $resolver;
    }

    /**
     * восстановление последнего резолвера из стека
     *
     * @access public
     */
    public function restoreResolver()
    {
        self::$resolver = array_pop(self::$stack);
    }

    /**
     * резолвинг запроса
     *
     * @access public
     * @static
     * @param string $request строка запроса (файл/имя класса)
     * @return string|null путь до запрашиваемого файла/класса, либо null если не найден
     */
    public static function resolve($request)
    {
        return self::$resolver->resolve($request);
    }

    /**
     * загрузка файла
     *
     * @access public
     * @static
     * @param string $file путь до подключаемого файла
     * @return boolean true - если файл загружен; false - в противном случае
     */
    public static function load($file)
    {
        if (in_array($file, self::$files)) {
            return true;
        } else {
            if(!($filename = self::resolve($file))) {
                throw new mzzIoException($file);
            }
            //return false;
            self::$files[] = $file;
            require_once $filename;
            return true;
        }
    }
}

?>
