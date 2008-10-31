<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/codegenerator/actionGenerator.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: actionGenerator.php 2688 2008-10-29 04:53:30Z zerkms $
 */

/**
 * safeGenerate: класс генератора, предназначенный для проведения операций удаления/переименования/создания файлов и директорий
 * с проверкой прав доступа к ним
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */
class safeGenerate
{
    /**
     * Метод записи данных в файлы с проверкой на права создания и модификации файлов
     *
     * @param array $data
     */
    public static function write($data)
    {
        foreach ($data as $val) {
            $file = $val[0];
            if (is_file($file)) {
                if (!is_writable($file)) {
                    throw new Exception('Файл недоступен для записи: ' . $file);
                }
            } else {
                $info = pathinfo($file);
                $dir = $info['dirname'];

                if (!is_writable($dir)) {
                    throw new Exception('Директория недоступна для записи: ' . $dir);
                }
            }
        }

        foreach ($data as $val) {
            file_put_contents($val[0], $val[1]);
        }
    }

    /**
     * Метод для удаления файлов, с проверкой их существования
     *
     * @param string $filename
     */
    public static function delete($filename)
    {
        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    /**
     * Метод переименования файлов с проверкой на права
     *
     * @param array $data
     */
    public static function rename($data)
    {
        foreach ($data as $val) {
            if (!is_file($val[0])) {
                throw new Exception('Файла не существует: ' . $val[0]);
            }

            if (is_file($val[1]) && $val[1] != $val[0]) {
                throw new Exception('Такой файл уже есть: ' . $val[1]);
            }

            if (!is_writable($val[0])) {
                throw new Exception('Нет прав на переименование файла: ' . $val[0]);
            }

            $info = pathinfo($val[1]);
            $dir = $info['dirname'];

            if (!is_writable($dir)) {
                throw new Exception('Нет прав на переименование файла: ' . $val[0] . ' в директории: ' . $dir);
            }
        }

        foreach ($data as $val) {
            if ($val[0] != $val[1]) {
                rename($val[0], $val[1]);
            }
            if (isset($val[2])) {
                file_put_contents($val[1], $val[2]);
            }
        }
    }

    /**
     * Метод переименования директорий с проверкой на права
     *
     * @param array $data
     */
    public static function renameDir($data)
    {
        foreach ($data as $val) {
            if (!is_dir($val[0])) {
                throw new Exception('Директории не существует: ' . $val[0]);
            }

            if (is_dir($val[1])) {
                throw new Exception('Такая директория уже есть: ' . $val[1]);
            }

            if (!is_writable($val[0])) {
                throw new Exception('Нет прав на переименование директории: ' . $val[0]);
            }
        }

        foreach ($data as $val) {
            if ($val[0] != $val[1]) {
                rename($val[0], $val[1]);
            }
        }
    }
}

?>