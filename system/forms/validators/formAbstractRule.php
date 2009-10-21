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
    protected $notExists = false;

    protected $validation = null;

    protected $params;

    protected $data = array();

    public function __construct($message = '', $params = null)
    {
        if ($params) {
            $this->params = $params;
        }

        if ($message) {
            $this->message = $message;
        }
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function notExists()
    {
        $this->notExists = true;
    }

    public function validate($value = null)
    {
        if ($this->notExists) {
            return true;
        }

        $this->validation = $this->_validate($value);

        return $this->validation;
    }

    abstract protected function _validate($value);

    public function getErrorMsg()
    {
        if ($this->validation === false) {
            return $this->message;
        }
    }
}

abstract class oldformAbstractRule
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

    protected $multiple = false;
    protected $isMultiple = false;

    /**
     * Конструктор
     *
     * @param string $name
     * @param string $errorMsg
     * @param array $params
     * @param mixed $values values for validation
     */
    public function __construct($name = '', $errorMsg = '', $params = '', $values = null)
    {
        $this->isMultiple = $this->multiple && is_array($name);
        $this->name = $this->generateName($name);

        $this->value = $values;
        if (!$this->isMultiple && is_array($this->value)) {
            $this->value = array_shift($this->value);
        }

        $this->errorMsg = $errorMsg;
        $this->params = $params;
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
    public function setValue($value, $name = null)
    {
        if ($this->isMultiple && is_null($name)) {
            throw new mzzRuntimeException('The validator is multiple and setValue requires the name as the second argument.');
        } elseif ($this->isMultiple) {
            $this->value[$name] = $value;
        } else {
            $this->value = $value;
        }
        return $this;
    }

    /**
     * Получение валидируемого значения
     *
     * @param mixed $value
     */
    public function getValue($name = null)
    {
        if ($this->isMultiple && !is_null($name)) {
            return array_key_exists($name, $this->value) ? $this->value[$name] : null;
        }
        return $this->value;
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

    protected function generateName($name)
    {
        if (is_array($name) && $this->multiple) {
            return implode(' ', array_map(array(
                $this,
                'deleteTypeFromName'), $name));
        } elseif (is_array($name)) {
            $name = array_shift($name);
        }
        return $this->deleteTypeFromName($name);
    }

    private function deleteTypeFromName($name)
    {
        return ($pos = strpos($name, ':')) ? substr($name, $pos + 1) : $name;
    }
}

?>