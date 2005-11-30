<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
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

fileLoader::load('Smarty/Smarty.class');

class mzzSmarty extends Smarty
{
    /**
     * Выполняет шаблон и возвращает результат
     * Декорирован для реализации вложенных шаблонов.
     *
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     * @param boolean $display
     */
    public function fetch($resource_name, $cache_id = null, $compile_id = null, $display = false)
    {
        $template = new Fs($this->template_dir . '/' . $resource_name, 'r');
        $template = $template->read(256);

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
     * Разбор первой строки вложенных (активных) шаблонов
     *
     * @access private
     * @static
     * @param string $str
     * @return array
     */
    private static function parse($str) {
        $params = array();
        if (preg_match('/\{\*\s*(.*?)\s*\*\}/', $str, $clean_str)) {
            $clean_str = preg_split('/\s+/', $clean_str[1]);
            foreach ($clean_str as $str) {
                $temp_str = explode('=', $str);
                $params[$temp_str[0]] = str_replace(array('\'', '"'), '', $temp_str[1]);
            }
        }
        return $params;
    }

}


?>
