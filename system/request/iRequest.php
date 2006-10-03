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
 * @version 0.2
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
     * Метод возвращает протокол, который был использован для передачи данных.
     *
     */
    public function getMethod();

    /**
     * Возвращает true если используется защищенный протокол
     *
     * @return boolean
     */
    public function isSecure();

    /**
     * Установка определенного параметра
     *
     * @param string $name
     * @param string $value
     */
    public function setParam($name, $value);

    /**
     * Установка массива параметров
     *
     * @param array $params
     */
    public function setParams(Array $params);
}

?>