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
 * fFileSmarty: модификация Smarty для работы с файлами-шаблонами
 *
 * @version 0.6
 * @package system
 * @subpackage template
 */
class fFileSmarty implements IfSmarty
{
    /**
     * Smarty object
     *
     * @var object
     */
    private $smarty;

    /**
     * конструктор
     *
     * @param object $smarty
     */
    function __construct(fSmarty $smarty)
    {
        $this->smarty = $smarty;
    }

    /**
     * Выполняет шаблон и возвращает результат
     *
     * @param string $resource
     * @param string $cache_id
     * @param string $compile_id
     * @param boolean $display
     */
    public function fetch($resource, $cache_id = null, $compile_id = null, $display = false)
    {
        // Для определения активного шаблоного достаточно прочитать первые 256 байтов из шаблона
        //$fileName = $this->getTemplateDir() . DIRECTORY_SEPARATOR . $resource[1];
        $resource['resource_name'] = $resource[1];
        $resource['resource_base_path'] = $this->smarty->template_dir;
        $this->smarty->_parse_resource_name($resource);

        $fileName = $resource['resource_name'];

        if (!file_exists($fileName)) {
            throw new mzzRuntimeException("Шаблон <em>'" . $fileName . "'</em> отсутствует.");
        }
        $template = new SplFileObject($fileName, 'r');
        $template = $template->fgets(256);

        $result = $this->smarty->fetchPassive($resource[1], $cache_id, $compile_id, $display);

        // Если шаблон вложен, обработать получателя
        if ($this->smarty->isActive($template)) {
            $result = $this->smarty->fetchActive($template, $cache_id, $compile_id, $display, $result);
        }
        return $result;

    }


    /**
     * Возвращает директорию с исходниками шаблонов
     *
     * @return string абсолютный путь
     */
    public function getTemplateDir()
    {
        return $this->smarty->template_dir;
    }

}

?>