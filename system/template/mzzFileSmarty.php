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
 * mzzFileSmarty: модификация Smarty для работы с файлами-шаблонами
 *
 * @version 0.6
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
     * конструктор
     *
     * @param object $smarty
     */
    function __construct(mzzSmarty $smarty)
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
        $isActive = $this->smarty->isActive($template);

        if ($main = $this->smarty->getActiveTemplate()) {
            $template = '{* main="' . $main['main'] . '" placeholder="' . $main['placeholder'] . '" *}'  . '\r\n' . $template;
            $this->smarty->setActiveTemplate(null);
        }

        $result = $this->smarty->fetchPassive($resource[1], $cache_id, $compile_id, $display);

        // Если шаблон вложен, обработать получателя
        $isActive = $this->smarty->isActive($template);
        if ($isActive) {
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