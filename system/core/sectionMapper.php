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
 * sectionMapper: класс для определения имени шаблона по XML-файлу
 *
 * @package system
 * @version 0.1
 */
class sectionMapper
{
    /**
     * Префикс имени
     *
     */
    const TPL_PRE = "act.";

    /**
     * Расширение шаблона
     *
     */
    const TPL_EXT = ".tpl";

    /**
     * XML Result
     *
     * @var object
     */
    protected $xml;

    private $toolkit;

    /**
     * Construct
     *
     * @param string $mapFileName путь до файла конфигурации
     */
    public function __construct($mapFileName)
    {
        if (!is_file($mapFileName)) {
            throw new mzzIoException($mapFileName);
        }
        $this->xml = simplexml_load_file($mapFileName);
        $this->toolkit = systemToolkit::getInstance();
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
        if (!empty($this->xml->$section)) {
            foreach ($this->xml->$section->action as $_action) {
                if($_action['name'] == $action) {
                    return (string) $_action;
                }
            }
            return false;
        } else {
            return false;
        }
    }

    /**
     * Decorate pattern
     *
     * @param string $template_name
     * @return string
     */
    protected function templateNameDecorate($templateName)
    {
        return self::TPL_PRE . $templateName . self::TPL_EXT;
    }

    /**
     * Получение имени шаблона
     *
     * @param string $section
     * @param string $action
     * @return string|false
     */
    //public function getTemplateName($section, $action)
    public function getTemplateName()
    {
        $httprequest = $this->toolkit->getRequest();
        $section = $httprequest->getSection();
        $action = $httprequest->getAction();

        $template_name = $this->xmlRead($section, $action);
        if ($template_name === false) {
            // если шаблон не найден - пытаемся реврайтить path и искать заново
            $rewrite = $this->toolkit->getRewrite();
            $rewrite->loadRules($section);
            $rewrited_path = $rewrite->process($httprequest->get('path'));
            $httprequest->parse($rewrited_path);

            $section = $httprequest->getSection();
            $action = $httprequest->getAction();

            $template_name = $this->xmlRead($section, $action);

            if ($template_name === false) {
                return false;
            }
        }
        return self::templateNameDecorate($template_name);
    }
}

?>
