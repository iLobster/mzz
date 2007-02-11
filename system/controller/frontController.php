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
 * @version $Id$
*/

/**
 * frontController: фронтконтроллер проекта
 *
 * @package system
 * @version 0.5
 */

class frontController
{
    /**
     * Префикс имени шаблона
     *
     */
    const TPL_PRE = "act/";

    /**
     * Расширение шаблона
     *
     */
    const TPL_EXT = ".tpl";
    /**
     * iRequest
     *
     * @var iRequest
     */
    protected $request;

    /**
     * Путь до папки с шаблонами
     *
     * @var string
     */
    protected $path;

    /**
     * конструктор класса
     *
     * @param iRequest $request
     * @param $path путь до папки с шаблонами
     */
    public function __construct($request, $path)
    {
        $this->request = $request;
        $this->path = $path;
    }

    /**
     * получение имени шаблона
     *
     * @return string имя шаблона в соответствии с запрошенной секцией и экшном
     */
    public function getTemplateName()
    {
        $section = $this->request->getSection();
        $action = $this->request->getAction();

        $tpl_name = self::TPL_PRE . $section . '/' . $action . self::TPL_EXT;
        if (file_exists($this->path . '/' . $tpl_name)) {
            return $tpl_name;
        }
        throw new mzzRuntimeException('Не найден активный шаблон для section = <i>"' . $section . '"</i>, action = <i>"' . $action . '"</i>');
    }
}

?>