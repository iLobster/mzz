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
        if (!file_exists(systemConfig::$pathToTemp . '/dump_checked')) {
            file_put_contents(systemConfig::$pathToTemp . '/dump_checked', time());
            return false;
        } 
        
        $timeDiff = filemtime(systemConfig::$pathToTemp . '/dump_checked') - 
                    filemtime(systemConfig::$pathToTemp . '/../db/mzz.dump');
		    
        if ($timeDiff) {
           $cmd = 'mysql -u '.escapeshellarg(systemConfig::$dbUser).
                  (empty(systemConfig::$dbPassword) ? '' : ' -p '.escapeshellarg(systemConfig::$dbPassword)).
                  ' < '.escapeshellarg(systemConfig::$pathToTemp . '/../db/mzz.dump');
           exec($cmd);
           file_put_contents(systemConfig::$pathToTemp . '/dump_checked', time());
           return true;
        }      
        return false;
    }
}



?>