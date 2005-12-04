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
     * @param string $classname имя искомого класса/запрос
     * @return boolean true - если файл загружен; false - в противном случае
     */
    public static function load($classname)
    {
        $realname = (strpos($classname, '/') === false ) ? $classname : substr(strrchr($classname, '/'), 1);
        if (class_exists($realname)) {
            return true;
        } else {
            try {
                if(!($filename = self::resolve($classname))) {
                    throw new FileResolverException("Can't find file for class '" . $classname . "'");
                    return false;
                }
                require_once $filename;
                return true;
            } catch (FileResolverException $e) {
                $e->printHtml();
            }
            return false;
        }
    }
}

?>
