<?php
//
// $Id: timer.php 717 2006-05-24 22:47:36Z pento $
// $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/db/dbDumpCheck.php $
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

/**
 * Обновляет базу, если есть более новый дамп
 *
 * @package dbDumpCheck
 * @version 0.1
 */

class dbDumpCheck
{
    public static function run()
    {
        $dumpCheckedFile = systemConfig::$pathToTemp . '/dump_checked';
        $dumpFile = systemConfig::$pathToTemp . '/../db/mzz.dump';
        
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
        
        $timeDiff = filemtime($dumpCheckedFile) - filemtime($dumpFile);
		    
        if ($timeDiff) {
           $cmd = MYSQL_PATH . ' -u '.escapeshellarg(systemConfig::$dbUser) .
                  (empty(systemConfig::$dbPassword) 
                  ? '' 
                  : ' -p ' . escapeshellarg(systemConfig::$dbPassword)) .
                  ' < ' . escapeshellarg($dumpFile);
           exec($cmd);
           file_put_contents($dumpCheckedFile, time());
           return true;
        }      
        return false;
    }
}



?>