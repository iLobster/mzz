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

    protected $multiple = false;
    protected $isMultiple = false;

    /**
     * Конструктор
     *
     * @param string $name
     * @param string $errorMsg
     * @param array $params
     */
    public function __construct($name = '', $errorMsg = '', $params = '')
    {
        $this->isMultiple = $this->multiple && is_array($name);
        $this->name = $this->generateName($name);
        $this->initRequestValue($name);
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
            return implode(' ', array_map(array($this, 'deleteTypeFromName'), $name));
        } elseif (is_array($name)) {
            $name = array_shift($name);
        }
        return $this->deleteTypeFromName($name);
    }

    protected function getFromRequest($name, $type)
    {
        $funcName = 'get' . ucfirst(strtolower($type));
        $request = systemToolkit::getInstance()->getRequest();
        return $request->$funcName($name, SC_REQUEST);
    }

    protected function initRequestValue($names)
    {
        foreach ((array)$names as $key => $name) {
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

            // just for handy :)
            $handynames = array('first', 'second', 'third');
            if (is_integer($key) && $key < 3) {
                $key = $handynames[$key];
            }

            $this->value[$key] = $this->getFromRequest($name, $type);
        }

        if (!$this->isMultiple && is_array($this->value)) {
            $this->value = array_shift($this->value);
        }
    }

    private function deleteTypeFromName($name)
    {
        return ($pos = strpos($name, ':')) ? substr($name, $pos + 1) : $name;
    }
}

?>