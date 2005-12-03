<?php

class testsFinder
{
    public function find($dir)
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
    
    static private function getDirsList($dir)
    {
        $dirs = array();
        if (is_dir($dir)) {
            $list = scandir($dir);
            foreach($list as $val) {
                $subdir = $dir . '/' . $val;
                if (is_dir($subdir) && $val != '.' && $val != '..') {
                    $dirs[] = $subdir;
                }
            }
        }
        return $dirs;
    }
}

?>