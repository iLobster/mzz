<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage core
 * @version $Id$
*/

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
     * @var array
     */
    private static $stack = array();

    /**
     * текущий резолвер
     *
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
     * @param object $resolver
     */
    public static function setResolver(iResolver $resolver)
    {
        array_push(self::$stack, self::$resolver);
        self::$resolver = $resolver;
    }

    /**
     * восстановление последнего резолвера из стека
     *
     */
    public function restoreResolver()
    {
        self::$resolver = array_pop(self::$stack);
    }

    /**
     * резолвинг запроса
     *
     * @param string $request строка запроса (файл/имя класса)
     * @return string|null путь до запрашиваемого файла/класса, либо null если не найден
     */
    public static function resolve($request)
    {
        if (!($filename = self::$resolver->resolve($request))) {
            throw new mzzIoException($request);
        }
        return $filename;
    }

    /**
     * загрузка файла
     *
     * @param string $file имя для подключаемого файла. Абсолютный путь будет автоматически определен с помощью Resolver-ОВ
     * @return boolean true - если файл уже был загружен
     */
    public static function load($file)
    {
        if (!isset(self::$files[$file])) {
            $filename = self::resolve($file);
            self::$files[$file] = 1;
            // require_once не использовано из-за ее медленности
            require $filename;
        }
        return true;
    }
}
?>