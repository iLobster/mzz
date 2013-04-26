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
 * @subpackage exceptions
 * @version $Id$
*/

/**
 * mzzCallbackException
 *
 * @package system
 * @subpackage exceptions
 * @version 0.1
*/
class mzzCallbackException extends mzzException
{
    /**
     * Конструктор
     *
     * @param array|string $callback
     */
    public function __construct($callback)
    {
        $message = 'Ошибка при использоании callback-методов. ';
        if (is_array($callback)) {
            $objDescription = $this->getObjectName($callback[0], $callback[1]);
            if (!$this->isValidObject($callback[0])) {
                $message .= 'Объект не того типа / неверное имя класса: <i>' . $objDescription;
            } else {
                $message .= 'Неверное имя метода: <i>' . $objDescription . '</i>';
            }
        } else {
            $message .= 'Неверное имя функции: <i>' . $callback . '</i>';
        }
        parent::__construct($message);
        $this->setName('Callback Exception');
    }

    /**
     * Проверяет является ли $object объектом или именем класса
     *
     * @param mixed $object
     * @return boolean
     */
    private function isValidObject($object)
    {
        return (is_object($object) || (is_string($object) && class_exists($object)));
    }

    /**
     * Возвращает строку вызова метода статически или объекта
     * в зависимости от типа $object
     *
     * @param object|string $object
     * @param string $method
     * @return string
     */
    private function getObjectName($object, $method)
    {
        return (is_object($object) ? ('$'.get_class($object).'->') : ($object.'::')).$method.'()';
    }
}

?>