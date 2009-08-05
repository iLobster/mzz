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

fileLoader::load('forms/formArrayDataspace');

/**
 * formValidator
 *
 * @package system
 * @subpackage forms
 * @version 0.1.1
 */

class formValidator
{
    /**
     * Массив валидаторов формы
     *
     * @var array
     */
    private $validators = array();

    /**
     * Датаспейс для хранения ошибок валидации
     *
     * @var arrayDataspace
     */
    private $errors;

    /**
     * Имя submit'а формы. Именно по нему определяется, что форма уже была отправлена
     *
     * @var string
     */
    private $submit;

    /**
     * Устанавлиает проверку от CSRF-аттак
     *
     * @var boolean
     */
    private $csrf = true;

    /**
     * Конструктор
     *
     * @param string $submit
     */
    public function __construct($submit = 'submit')
    {
        $this->errors = new formArrayDataspace($this);

        if (!is_string($submit)) {
            throw new mzzInvalidParameterException('Параметр submit должен быть строковым', $submit);
        }

        $this->submit = $submit;

        fileLoader::load('forms/validators/formAbstractRule');
        systemToolkit::getInstance()->setValidator($this);
    }

    /**
     * Добавление правила
     *
     * @param string $validator имя валидатора
     * @param string $name имя проверяемого поля
     * @param string $errorMsg сообщение об ошибке
     * @param mixed $params набор дополнительных параметров для валидтора
     */
    public function add($validator, $name, $errorMsg = '', $params = '')
    {
        $validatorName = 'form' . ucfirst($validator) . 'Rule';
        fileLoader::load('forms/validators/' . $validatorName);

        $validator = new $validatorName($name, $errorMsg, $params, $this->getRequestValues($name));
        $this->validators[] = $validator;
        return $validator;
    }

    /**
     * Запуск валидаторов
     *
     * @param array $data массив с валидируемыми данными
     * @return boolean true - в случае, если ни один из валидаторов не возвратил ошибку, false - в противном случае
     */
    public function validate($data = array())
    {
        if ($this->csrf) {
            $this->add('required', form::$CSRFField, 'CSRF Attack detected');
            $this->add('csrf', form::$CSRFField, 'CSRF Attack detected');
        }

        $this->errors->set('_validators', $this->validators);
        systemToolkit::getInstance()->getSmarty()->assign('form', $this->errors);

        if (systemToolkit::getInstance()->getRequest()->getString($this->submit, SC_REQUEST)) {
            $valid = true;

            foreach ($this->validators as $validator) {
                if ($this->errors->exists($name = $validator->getName())) {
                    continue;
                }

                if (isset($data[$name])) {
                    $validator->setValue($data[$name]);
                } elseif (!empty($data)) {
                    $validator->setValue(null);
                }

                $result = $validator->validate();

                if (!$result) {
                    $this->errors->set($name, $validator->getErrorMsg());
                }

                $valid &= $result;
            }

            return (bool)$valid;
        }

        return false;
    }

    /**
     * Отключает проверку от CSRF-атак
     */
    public function disableCSRF()
    {
        $this->csrf = false;
    }

    /**
     * Включает проверку от CSRF-атак
     */
    public function enableCSRF()
    {
        $this->csrf = true;
    }

    /**
     * Определение, является ли поле обязательным к заполнению
     *
     * @param string $name имя поля
     * @return boolean true - является обязательным, false - не является обязательным
     */
    public function isFieldRequired($name)
    {
        foreach ($this->validators as $validator) {
            if ($validator instanceof formRequiredRule && $validator->getName() == $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * Получение ошибок валидации
     *
     * @return arrayDataspace
     */
    public function getErrors()
    {
        return $this->errors;
    }

    protected function getRequestValues($names)
    {
        $values = array();
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

            $values[$key] = $this->getFromRequest($name, $type);
        }

        return $values;
    }

    protected function getFromRequest($name, $type)
    {
        $funcName = 'get' . ucfirst(strtolower($type));
        $request = systemToolkit::getInstance()->getRequest();
        return $request->$funcName($name, SC_REQUEST);
    }
}

?>