<?php

class testsFinder
{
    static public function find($dir)
    {
        $cases = array();
        $dirs = self::getDirsList($dir);

        foreach ($dirs as $val) {
            $cases = array_merge($cases, self::getCasesList($val));
        }

        if(count($dirs) == 0) {
            $cases = self::getCasesList($dir);
        }

        return $cases;
    }

    static private function getCasesList($dir,  $caseslist = array())
    {
        if (is_dir($dir)) {
            $caseslist = glob($dir . '/*case.php');
            $caseslist = array_merge($caseslist, glob($dir . '/*/*case.php'));
        }
        return $caseslist;
    }


    static public function getDirsList($dir)
    {
        $dirs = glob($dir . "/*", GLOB_ONLYDIR);
        return $dirs;
    }
}

?>