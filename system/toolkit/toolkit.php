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
 * @subpackage toolkit
 * @version $Id$
*/

fileLoader::load('toolkit/iToolkit');

/**
 * toolkit: абстрактный класс
 *
 * @package system
 * @subpackage toolkit
 * @version 0.1
 */
abstract class toolkit implements iToolkit
{
    /**
     * Методы Toolkit-ов
     *
     * @var array
     */
    private $tools = array();

    /**
     * Конструктор. Сохраняет методы Toolkit-а
     *
     */
    public function __construct()
    {
        $selfMethods = get_class_methods('toolkit');
        $toolkitMethods = get_class_methods($this);
        foreach ($toolkitMethods as $value) {
            if (!in_array($value, $selfMethods)) {
                $this->tools[] = strtolower($value);
            }
        }
    }

    /**
     * Возвращает данный toolkit если в нем содержится метод $toolName
     *
     * @param string $toolName
     * @return object|false
     */
    final public function getToolkit($toolName)
    {
        return in_array(strtolower($toolName), $this->tools) ? $this : false;
    }
}
?>