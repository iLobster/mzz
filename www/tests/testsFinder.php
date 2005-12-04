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

        $cases = array_merge($cases, self::getCasesList($dir));

        return $cases;
    }

    static private function getCasesList($dir)
    {
        $caseslist = array();

        if (is_dir($dir)) {
            $caseslist = glob($dir . '/*case.php');
        }

        return $caseslist;
    }


    static public function getDirsList($dir)
    {
        $dirs = array();
        $list = new RecursiveDirectoryIterator($dir);
        for( ; $list->valid(); $list->next()) {
            if($list->isDir() && !$list->isDot() && ($item = (string) $list->current()) != ".svn") {
                $dirs[] = $dir . '/' . $item;
            }
	    }
        return $dirs;
   }
}

?>