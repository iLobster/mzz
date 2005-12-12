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
        for($list = new RecursiveDirectoryIterator($dir); $list->valid(); $list->next()) {
            if(!$list->isDir() && strpos($list->current(), 'case.php')) {
                $caseslist[] = $dir . '/' . $list->current();
            } elseif($list->isDir() && !$list->isDot() && strpos($list->current(), '.svn') === false) {
                $caseslist = self::getCasesList($dir . '/' . $list->current(), $caseslist);
            }
	    }

	   return $caseslist;
    }


    static public function getDirsList($dir)
    {
        for($list = new RecursiveDirectoryIterator($dir), $dirs = array(); $list->valid(); $list->next()) {
            if($list->isDir() && !$list->isDot() && ($item = (string) $list->current()) != ".svn") {
                $dirs[] = $dir . '/' . $item;
            }
	    }
        return $dirs;
   }
}

?>