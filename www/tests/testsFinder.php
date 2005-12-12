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
        $list = new RecursiveDirectoryIterator($dir);
        for( ; $list->valid(); $list->next()) {
            if(!$list->isDir() && preg_match('/case.php/i', $list->current())) {
                $caseslist[] = $dir . '/' . $list->current();
            } elseif($list->isDir() && !$list->isDot() && strpos($list->current(), '.svn') === false) {
                $caseslist = self::getCasesList($dir . '/' . $list->current(), $caseslist);
            }
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