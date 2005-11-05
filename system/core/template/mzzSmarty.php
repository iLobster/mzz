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

// Модификация Smarty для работы с шаблонами
fileResolver::includer('../libs/smarty', 'Smarty.class');

/**
 * mzzSmarty
 *
 * @version 0.1
 * @access public
 */
class mzzSmarty extends Smarty
{
    /**
     * @access private
     * @var object
     */
    private static $smarty;

    /**
     * Модифицированный Smarty::fetch(). Используется для
     * реализации вложенных шаблонов.
     *
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     * @param boolean $display
     */
    function fetch($resource_name, $cache_id = null, $compile_id = null, $display = false)
    {
        // {{{ TODO: Изменить использование стандартных функций на ООП-методы
        $file = fopen($this->template_dir.'/'.$resource_name, "rb");
        $template = fread($file, 100);
        fclose($file);
        // }}}

        $result = parent::fetch($resource_name);

        // Если шаблон вложен, обработать получателя
        if (preg_match("/\{\*\s*main=/i", $template)) {
            $params = self::parse($template);
            $this->assign($params['placeholder'], $result);
            $result = self::fetch($params['main']);
        }
        return $result;
    }

    /**
     * Singleton
     *
     * @return object
     */
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

    /**
     * Разбор первой строки вложенных шаблонов
     *
     * @access private
     * @param string $str
     * @return array
     */
    private function parse($str) {
        if (preg_match("/\{\*\s*(.*?)\s*\*\}/", $str, $clean_str)) {
            $clean_str = preg_split("/\s+/", $clean_str[1]);
            $params = array();
            foreach ($clean_str as $str) {
                $temp_str = explode("=", $str);
                $params[$temp_str[0]] = str_replace(array("'", "\""), "", $temp_str[1]);
            }
        }
        return $params;
    }

}


?>
