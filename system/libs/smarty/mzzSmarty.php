<?php

fileResolver::includer('../libs/smarty', 'Smarty.class');
class mzzSmarty extends Smarty
{
    private static $smarty;
    function fetch($resource_name, $cache_id = null, $compile_id = null, $display = false)
    {
     //   $f
        $file = fopen($this->template_dir.'/'.$resource_name,"rb");
        $template = fread($file, 100);
        fclose($file);
        $regexp = "/\{\*\s*main=('|\")?(.*?)('|\")?\s*placeholder=('|\")?(.*?)('|\")?\s*\*\}/i";
        $result = parent::fetch($resource_name);
        if(preg_match($regexp, $template, $params)) {
            $this->assign($params[5],$result);
            $result = self::fetch($params[2]);
            //print_r($params);
        }
        ///print_r($params);echo $template;
        return $result;


    }
    static function getInstance() {
        if(!is_object(self::$smarty)) {
            $classname = __CLASS__;
            $smarty = new $classname;
            $smarty->template_dir      = APPLICATION . '/templates';
            $smarty->compile_dir       =  APPLICATION . '/templates';
            self::$smarty = $smarty;
        }
        return self::$smarty;
    }

}


?>
