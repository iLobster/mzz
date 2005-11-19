<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2005
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * mzzSmarty: модификация Smarty для работы с шаблонами
 *
 * @version 0.1
 * @access public
 */

/* fileResolver::includer('./libs/smarty', 'Smarty.class'); */
require_once SYSTEM_DIR . 'libs/smarty/Smarty.class.php';

class mzzSmarty extends Smarty
{
    /**
     * Hold an instance of the class
     *
     * @access private
     * @static object
     */
    private static $smarty;

    /**
     * Выполняет шаблон и возвращает результат
     * Модифицирован для реализации вложенных шаблонов.
     *
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     * @param boolean $display
     */
    public function fetch($resource_name, $cache_id = null, $compile_id = null, $display = false)
    {
        $template = new Fs($this->template_dir . '/' . $resource_name, "r");
        $template = $template->read(512);

        $result = parent::fetch($resource_name, $cache_id, $compile_id, $display);

        // Если шаблон вложен, обработать получателя
        if (preg_match("/\{\*\s*main=/i", $template)) {
            $params = self::parse($template);
            $this->assign($params['placeholder'], $result);
            $result = self::fetch($params['main'], $cache_id, $compile_id, $display);
        }
        return $result;
    }

    /**
     * Выполняет шаблон и отображает результат.
     *
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     */
    public function display($resource_name, $cache_id = null, $compile_id = null)
    {
        $this->fetch($resource_name, $cache_id, $compile_id, true);
    }

    /**
     * Singleton
     *
     * @static
     * @return object
     */
    public static function getInstance() {
        if(!is_object(self::$smarty)) {
            $classname = __CLASS__;
            $smarty = new $classname;
            $smarty->template_dir      = APPLICATION_DIR . 'templates';
            $smarty->compile_dir       = APPLICATION_DIR . 'templates/compiled';
            $smarty->plugins_dir[] = SYSTEM_DIR . 'template/plugins';
            $smarty->debugging = true;
            self::$smarty = $smarty;
        }
        return self::$smarty;
    }

    /**
     * Разбор первой строки вложенных шаблонов
     *
     * @access private
     * @static
     * @param string $str
     * @return array
     */
    private static function parse($str) {
        $params = array();
        if (preg_match("/\{\*\s*(.*?)\s*\*\}/", $str, $clean_str)) {
            $clean_str = preg_split("/\s+/", $clean_str[1]);
            foreach ($clean_str as $str) {
                $temp_str = explode("=", $str);
                $params[$temp_str[0]] = str_replace(array("'", "\""), "", $temp_str[1]);
            }
        }
        return $params;
    }

}


?>
