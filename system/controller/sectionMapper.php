<?php
/**
 * Класс для определения имени шаблона по XML-файлу
 *
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
 * @subpackage core
 * @version $Id$
*/

/**
 * sectionMapper: класс для определения имени шаблона
 *
 * @package system
 * @subpackage core
 * @version 0.2
 */
class sectionMapper
{
    /**
     * Префикс имени
     *
     */
    const TPL_PRE = "act/";

    /**
     * Расширение шаблона
     *
     */
    const TPL_EXT = ".tpl";

    /**
     * Путь до папки с активными шаблонами
     *
     * @var string
     */
    protected $path;

    /**
     * Construct
     *
     * @param string $path путь до папки с активными шаблонами
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Decorate pattern
     *
     * @param string $templateName
     * @return string
     */
    public function templateNameDecorate($templateName)
    {
        return self::TPL_PRE . $templateName . self::TPL_EXT;
    }

    /**
     * Получение имени шаблона
     *
     * @param string $section
     * @param string $action
     * @return string
     */
    public function getTemplateName($section, $action)
    {
        $templateName = $this->templateNameDecorate($section . '/' . $action);
        if (file_exists($this->path . '/' . $templateName)) {
            return $templateName;
        }
        throw new mzzRuntimeException('Не найден активный шаблон для section = <i>"' . $section . '"</i>, action = <i>"' . $action . '"</i>');
    }
}

?>