<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage template
 * @version $Id$
*/

/**
 * mzzFileSmarty: модификаци€ Smarty дл€ работы с файлами-шаблонами
 *
 * @version 0.5
 * @package system
 * @subpackage template
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
     *
     * @param string $resource
     * @param string $cache_id
     * @param string $compile_id
     * @param boolean $display
     * @param mzzSmarty $smarty
     */
    public function fetch($resource, $cache_id = null, $compile_id = null, $display = false, mzzSmarty $smarty)
    {
        $this->smarty = $smarty;
        //$resource_name = $this->getResourceFileName($resource[1], $this->smarty);

        // ƒл€ определени€ активного шаблоного достаточно прочитать первые 256 байтов из шаблона
        $fileName = $this->getTemplateDir() . '/' . $resource[1];
        if (!file_exists($fileName)) {
            throw new mzzRuntimeException("Ўаблон <em>'" . $fileName . "'</em> отсутствует.");
        }
        $template = new SplFileObject($fileName, 'r');
        $template = $template->fgets(256);

        $result = $this->smarty->fetchPassive($resource[1], $cache_id, $compile_id, $display);

        // ≈сли шаблон вложен, обработать получател€
        if ($this->smarty->isActive($template)) {
            $result = $this->smarty->fetchActive($template, $cache_id, $compile_id, $display, $result);
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
     * @deprecated вместо news.view.tpl использовать news/view.tpl
     */
    /*public function getResourceFileName($name)
    {
        if (!is_file($this->getTemplateDir() . '/' . $name)) {
            $subdir = substr($name, 0, strpos($name, '.'));
            return $subdir . '/' . $name;
        }
        return $name;
    }*/

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
