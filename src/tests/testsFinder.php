<?php

class testsFinder
{
    static public function find($dir)
    {
        $cases = self::getCasesList($dir);
        $dirs = self::getDirsList($dir);

        foreach ($dirs as $val) {
            $subDirs = self::getDirsList($val);

            if(count($subDirs)) {
                foreach($subDirs as $dir) {
                    $cases = array_merge($cases, self::getCasesList($dir));
                    }
                }

            $cases = array_merge($cases, self::getCasesList($val));
        }

        if(count($dirs) == 0) {
            $cases = self::getCasesList($dir);
        }

        return $cases;
    }

    static private function getCasesList($dir)
    {
        $caseslist = array();
        if (is_dir($dir)) {
            $caseslist = glob($dir . DIRECTORY_SEPARATOR . '*.case.php');
            //$caseslist = array_merge($caseslist, glob($dir . '/*/*.case.php'));
        }
        return $caseslist;
    }


    static public function getDirsList($dir)
    {
        $dirs = glob($dir . "{" . DIRECTORY_SEPARATOR . "*, " . DIRECTORY_SEPARATOR . "*" . DIRECTORY_SEPARATOR . "*}", GLOB_ONLYDIR | GLOB_BRACE);
        return $dirs;
    }

    static public function getCategoriesList($dir)
    {
        $dirs = glob($dir . DIRECTORY_SEPARATOR . "*", GLOB_ONLYDIR);
        return $dirs;
    }
}

?>