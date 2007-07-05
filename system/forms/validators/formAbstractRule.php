<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * formAbstractRule
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
abstract class formAbstractRule
{
    /**
     * Имя валидируемого поля
     *
     * @var string
     */
    protected $name;

    /**
     * Валидируемое значение
     *
     * @var mixed
     */
    protected $value;

    /**
     * Сообщение об ошибке
     *
     * @var string
     */
    protected $errorMsg;

    /**
     * Дополнительные параметры
     *
     * @var array
     */
    protected $params;

    /**
     * Конструктор
     *
     * @param string $name
     * @param string $errorMsg
     * @param array $params
     */
    public function __construct($name, $errorMsg = '', $params = '')
    {
        $this->name = $name;
        $this->errorMsg = $errorMsg;
        $this->params = $params;

        $request = systemToolkit::getInstance()->getRequest();
        $this->value = $request->get($name, 'string', SC_REQUEST);
    }

    /**
     * Метод, содержащий алгоритм валидации. Должен быть определён в наследнике
     *
     */
    abstract public function validate();

    /**
     * Получение сообщения об ошибке
     *
     * @return string
     */
    public function getErrorMsg()
    {
        return $this->errorMsg;
    }

    /**
     * Получение имени поля
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}

?>