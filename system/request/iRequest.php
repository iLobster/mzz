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
 * iRequest: интерфейс для работы с запросами
 *
 * @package system
 * @subpackage request
 * @version 0.1
 */

interface iRequest
{
    /**
     * Метод получения переменной из запроса
     *
     * @param string $name имя переменной
     * @param boolean $scope бинарное число, определяющее в каких массивах искать переменную
     * @return string|null
     */
    public function get($name, $scope = null);

    /**
     * Возвращает section
     *
     * @return string
     */
    public function getSection();

    /**
     * Возвращает action
     *
     * @return string
     */
    public function getAction();

    /**
     * Установка section
     *
     * @param string $value
     */
    public function setSection($value);

    /**
     * Установка action
     *
     * @param string $value
     */
    public function setAction($value);

    /**
     * Установка определенного параметра
     *
     * @param string $name
     * @param string $value
     */
    public function setParam($name, $value);

}

?>