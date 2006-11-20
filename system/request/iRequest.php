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
 * @subpackage request
 * @version $Id$
*/

/**
 * iRequest: интерфейс для работы с внешними запросами
 *
 * @package system
 * @subpackage request
 * @version 0.7
 */

interface iRequest
{
    /**
     * Метод получения переменной из запроса
     *
     * @param string $name имя переменной
     * @param string  $type  тип, в который будет преобразовано значение
     * @param boolean $scope бинарное число, определяющее в каких массивах искать переменную
     * @return string|null
     */
    public function get($name, $type = 'mixed', $scope = null);

    /**
     * Метод возвращает протокол, который был использован для передачи данных.
     *
     */
    public function getMethod();

    /**
     * Возвращает true если используется AJAX
     *
     * @return boolean
     */
    public function isAjax();

    /**
     * Возвращает текущую секцию
     *
     * @return string
     */
    public function getSection();

    /**
     * Устанавливает текущую секцию
     *
     * @param string $section
     */
    public function setSection($section);

    /**
     * Возвращает текущее действие
     *
     * @return string
     */
    public function getAction();

    /**
     * Устанавливает текущее действие
     *
     * @param string $action
     */
    public function setAction($action);

    /**
     * Установка определенного параметра
     *
     * @param string $name
     * @param string $value
     */
    public function setParam($name, $value);

    /**
     * Установка массива параметров. Существующие параметры будут уничтожены
     *
     * @param array $params
     */
    public function setParams(Array $params);

    /**
     * Возврат массива параметров
     *
     * @return array
     */
    public function & getParams();

    /**
    * Получение текущего урла без путя
    *
    * @return string URL
    */
    public function getUrl();

    /**
    * Получение текущего урла c путем
    *
    * @return string URL
    */
    public function getRequestUrl();

    /**
    * Получение текущего пути
    *
    * @return string PATH
    */
    public function getPath();
}

?>