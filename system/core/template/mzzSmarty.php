<?php

fileResolver::includer('../libs/smarty', 'Smarty.class');
class mzzSmarty extends Smarty
{
    private static $smarty;
    function fetch($resource_name, $cache_id = null, $compile_id = null, $display = false)
    {
        $file = fopen($this->template_dir.'/'.$resource_name,"rb");
        $template = fread($file, 100);
        fclose($file);
        $result = parent::fetch($resource_name);
        if(preg_match("/\{\*\s*main=/i", $template)) {
            $params = self::parse($template);
            $this->assign($params['placeholder'],$result);
            $result = self::fetch($params['main']);
        }
        return $result;


    }
    static function getInstance() {
        if(!is_object(self::$smarty)) {
            $classname = __CLASS__;
            $smarty = new $classname;
            $smarty->template_dir      = APPLICATION . '/templates';
            $smarty->compile_dir       = APPLICATION . '/templates';
            self::$smarty = $smarty;
        }
        return self::$smarty;
    }
    private function parse($str) {
        if(preg_match("/\{\*\s*(.*?)\s*\*\}/",$str, $clean_str)) {
            $clean_str = preg_split("/\s+/",$clean_str[1]);
            $params = array();
            foreach ($clean_str as $str) {
                $temp_str = explode("=",$str);
                $params[$temp_str[0]] = str_replace(array("'","\""),"",$temp_str[1]);
            }
        }
        return $params;
    }

}


?>
