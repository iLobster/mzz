<?php
/**
 * $URL: http://svn.web/repository/mzz/system/db/dbDumpCheck.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage db
 * @version $Id: dbDumpCheck.php 674 2007-03-11 22:27:52Z zerkms $
*/

/**
 * Обновляет базу, если есть более новый дамп
 *
 * @package system
 * @subpackage db
 * @version 0.1
 * @deprecated загружайте дампы ручками
 */
class dbDumpCheck
{
    /**
     * Запуск проверки и загрузки дампов в MySQL если они обновились.
     *
     * @return boolean
     */
    public static function run()
    {
        $dumpCheckedFile = systemConfig::$pathToTemp . '/dump_checked';
        $dumpFile        = systemConfig::$pathToTemp . '/../db/mzz.dump';
        $dumpFileTest    = systemConfig::$pathToTemp . '/../db/mzz_test.dump';

        if (!file_exists($dumpCheckedFile)) {
            file_put_contents($dumpCheckedFile, time());
            return false;
        }

        if (!defined('MYSQL_PATH')) {
            return false;
        }

        if (!is_executable(MYSQL_PATH)) {
            return false;
        }


        $timeDiff = filemtime($dumpFile) - filemtime($dumpCheckedFile);

        if ($timeDiff > 0) {

           $cmd = MYSQL_PATH . ' -u '.escapeshellarg(systemConfig::$dbUser) .
                  (empty(systemConfig::$dbPassword)
                  ? ''
                  : ' -p ' . escapeshellarg(systemConfig::$dbPassword)) .
                  ' < ' . escapeshellarg($dumpFile);
           exec($cmd);

           $cmd = MYSQL_PATH . ' -u '.escapeshellarg(systemConfig::$dbUser) .
                  (empty(systemConfig::$dbPassword)
                  ? ''
                  : ' -p ' . escapeshellarg(systemConfig::$dbPassword)) .
                  ' < ' . escapeshellarg($dumpFileTest);
           exec($cmd);

           file_put_contents($dumpCheckedFile, time());

           return true;
        }
        return false;
    }
}



?>