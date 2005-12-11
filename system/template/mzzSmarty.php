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
 * @version 0.2
 * @access public
 */

fileLoader::load('libs/Smarty/Smarty.class');

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
        if(strpos($resource_name, ':')) {
            throw new systemException('Поддержка других ресурсов Smarty не реализована. Не используйте "file:" в именах шаблонах.');
        }
        $resource_name = $this->getResourceFileName($resource_name);

        $template = new SplFileObject($this->template_dir . '/' . $resource_name, 'r');
        $template = $template->fgets(256);

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
     * Получает и возвращает относительный путь к исходнику шаблонов.
     * Если нужный шаблон находится в корне папки с шаблонами, то изменений нет,
     * если в корне нет, то к относительному путю прибавляется первая часть имени до точки.
     *
     * Пример:
     * <code>
     * news.view.tpl -> news/news.view.tpl
     * main.tpl -> main.tpl
     * </code>
     *
     * @param string $name
     * @return string
     */
    protected function getResourceFileName($name)
    {
        //$with_resource = strpos($name, ':');
        // $this->template_exists($name)
        //if(!is_file($this->getTemplateDir() . '/' . $name) && ($with_resource === false || substr($name, 0, 4) == 'file')) {

        if(!is_file($this->getTemplateDir() . '/' . $name)) {
            $subdir = substr($name, 0, strpos($name, '.'));
            return $subdir . '/' . $name;
        }
        return $name;
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
    private static function parse($str)
    {
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

    /**
     * Возвращает директорию с исходниками шаблонов
     *
     * @return string абсолютный путь
     */
    protected function getTemplateDir()
    {
        return $this->template_dir;
    }
}

?>
