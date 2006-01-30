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
 * mzzFileSmarty: модификаци€ Smarty дл€ работы с файлами-шаблонами
 *
 * @version 0.3
 * @package system
 */
class mzzFileSmarty implements IMzzSmarty
{

    /**
     * Smarty object
     *
     * @var object
     */
    private $smarty;

    /**
     * ¬ыполн€ет шаблон и возвращает результат
     * ƒекорирован дл€ реализации вложенных шаблонов.
     *
     * @param string $resource
     * @param string $cache_id
     * @param string $compile_id
     * @param boolean $display
     */
    public function fetch($resource, $cache_id = null, $compile_id = null, $display = false, mzzSmarty $smarty)
    {
        $this->smarty = $smarty;
        $resource_name = $this->getResourceFileName($resource[1], $this->smarty);

        $template = new SplFileObject($this->smarty->template_dir . '/' . $resource_name, 'r');
        $template = $template->fgets(256);

        $result = $this->smarty->_fetch($resource_name, $cache_id, $compile_id, $display);

        // ≈сли шаблон вложен, обработать получател€
        if ($this->smarty->isActive($template)) {
            $params = $this->smarty->parse($template);
            $smarty->assign($params['placeholder'], $result);
            $result = $this->smarty->fetch($params['main'], $cache_id, $compile_id, $display, $this->smarty);
        }
        return $result;

    }

    /**
     * ѕолучает и возвращает относительный путь к исходнику шаблонов.
     * ≈сли нужный шаблон находитс€ в корне папки с шаблонами, то изменений нет,
     * если в корне нет, то к относительному путю прибавл€етс€ перва€ часть имени до точки.
     *
     * ѕример:
     * <code>
     * news.view.tpl -> news/news.view.tpl
     * main.tpl -> main.tpl
     * </code>
     *
     * @param string $name
     * @return string
     */
    public function getResourceFileName($name)
    {
        if(!is_file($this->getTemplateDir() . '/' . $name)) {
            $subdir = substr($name, 0, strpos($name, '.'));
            return $subdir . '/' . $name;
        }
        return $name;
    }

    /**
     * ¬озвращает директорию с исходниками шаблонов
     *
     * @return string абсолютный путь
     */
    public function getTemplateDir()
    {
        return $this->smarty->template_dir;
    }

}

?>
