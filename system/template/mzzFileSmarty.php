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
 * mzzFileSmarty: модификация Smarty для работы с файлами-шаблонами
 *
 * @version 0.3
 * @package system
 */

class mzzFileSmarty implements IMzzSmarty
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
    public function fetch($resource_name, $cache_id = null, $compile_id = null, $display = false, mzzSmarty $smarty)
    {
        $resource_name = $this->getResourceFileName($resource_name, $smarty);

        $template = new SplFileObject($smarty->template_dir . '/' . $resource_name, 'r');
        $template = $template->fgets(256);

        $result = $smarty->_fetch($resource_name, $cache_id, $compile_id, $display);

        // Если шаблон вложен, обработать получателя
        if (preg_match("/\{\*\s*main=/i", $template)) {
            $params = $smarty->parse($template);
            $smarty->assign($params['placeholder'], $result);
            $result = $this->fetch($params['main'], $cache_id, $compile_id, $display, $smarty);
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
    public function getResourceFileName($name, mzzSmarty $smarty)
    {
        if(!is_file($smarty->getTemplateDir() . '/' . $name)) {
            $subdir = substr($name, 0, strpos($name, '.'));
            return $subdir . '/' . $name;
        }
        return $name;
    }

}

?>
