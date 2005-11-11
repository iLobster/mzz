<?php
class DB
{
    private static $instance;
    // The factory method
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            if (file_exists(SYSTEM.'db/driver_' . DB_DRIVER . '.php')) {
                include_once(SYSTEM.'db/driver_' . DB_DRIVER . '.php');
                $classname = 'Mzz' . ucfirst(DB_DRIVER);
                self::$instance = new $classname(DB_HOST, DB_USER, DB_PASSWORD, DB_BASE);
            } else {
                throw new Exception ('Driver "'.DB_DRIVER.'" not found');
            }
        }

        // TODO: ¬ынести из фабрики установку кодировки
        if(DB_DRIVER == "mysqli") {
            self::$instance->query("SET NAMES `cp1251`");
        }
        return self::$instance;
   }

}
?>