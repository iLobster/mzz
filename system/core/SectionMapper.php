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
 * SectionMapper: класс для определения имени шаблона по XML-файлу
 *
 * @package system
 * @version 0.1
 */
class SectionMapper
{

    /**
     * Имя шаблона
     *
     * @var array
     * @access protected
     */
    protected $template_name;

    /**
     * Префикс имени
     */
    const TPL_PRE = "act.";

    /**
     * Расширение шаблона
     */
    const TPL_EXT = ".tpl";
    /**
     * Construct
     *
     * @access public
     * @param string $section
     * @param string $action
     */
    public function __construct($section, $action)
    {
        $this->xmlRead($section, $action);
    }

    /**
     * Чтение XML-конфига с правилами для Mapper.
     *
     * @param string $section
     * @param string $action
     * @return false если требуемой секции нет
     */
    private function xmlRead($section, $action)
    {
        $xml = simplexml_load_file(FileLoader::resolve('configs/map.xml'));
        if (!empty($xml->$section)) {
            foreach ($xml->$section->action as $_action) {
                if($_action['name'] == $action) {
                    $this->template_name = (string) $_action;
                    return true;
                }
            }
            $this->template_name = false;
        } else {
            $this->template_name = false;
        }
    }

    /**
     * Decorate pattern
     *
     * @param string $template_name
     * @return string
     */
    protected function templateNameDecorate($template_name)
    {
        return self::TPL_PRE . $template_name . self::TPL_EXT;
    }

    /**
     * Получение имени шаблона
     *
     * @return string
     */
    public function getTemplateName()
    {
        if($this->template_name === false) {
            return false;
        } else {
            return self::templateNameDecorate($this->template_name);
        }
    }
}

?>
