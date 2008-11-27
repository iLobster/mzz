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
 * @version 0.1.3
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
    public function __construct($name = '', $errorMsg = '', $params = '')
    {
        $name = explode(':', $name, 2);
        $type = 'string';
        if (sizeof($name) > 1) {
            if (in_array($name[0], array('array', 'integer', 'numeric', 'string', 'boolean'))) {
                $type = $name[0];
            }
            $name = $name[1];
        } else {
            $name = $name[0];
        }

        $this->name = $name;
        $this->errorMsg = $errorMsg;
        $this->params = $params;

        $request = systemToolkit::getInstance()->getRequest();
        $funcName = 'get' . ucfirst(strtolower($type));
        $this->value = $request->$funcName($name, SC_REQUEST);
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
     * Установка валидируемого значения
     *
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
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

    /**
     * Проверяет значение на пустоту
     *
     * @return boolean
     */
    public function isEmpty()
    {
        if (!is_scalar($this->value)) {
            return empty($this->value);
        }
        return $this->value == '';
    }
}

?>