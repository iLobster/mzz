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
 * formValidator
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */

class formValidator
{
    /**
     * ћассив валидаторов формы
     *
     * @var array
     */
    private $validators = array();

    /**
     * ƒатаспейс дл€ хранени€ ошибок валидации
     *
     * @var arrayDataspace
     */
    private $errors;

    /**
     * »м€ submit'а формы. »менно по нему определ€етс€, что форма уже была отправлена
     *
     * @var string
     */
    private $submit;

    /**
     *  онструктор
     *
     * @param string $submit
     */
    public function __construct($submit = 'submit')
    {
        $this->errors = new arrayDataspace();

        if (!is_string($submit)) {
            throw new mzzInvalidParameterException('ѕараметр submit должен быть строковым', $submit);
        }

        $this->submit = $submit;

        fileLoader::load('forms/validators/formAbstractRule');
        systemToolkit::getInstance()->setValidator($this);
    }

    /**
     * ƒобавление правила
     *
     * @param string $validator им€ валидатора
     * @param string $name им€ провер€емого пол€
     * @param string $errorMsg сообщение об ошибке
     * @param mixed $params набор дополнительных параметров дл€ валидтора
     */
    public function add($validator, $name, $errorMsg = '', $params = '')
    {
        $validatorName = 'form' . ucfirst($validator) . 'Rule';
        fileLoader::load('forms/validators/' . $validatorName);

        $this->validators[] = new $validatorName($name, $errorMsg, $params);
    }

    /**
     * «апуск валидаторов
     *
     * @return boolean true - в случае, если ни один из валидаторов не возвратил ошибку, false - в противном случае
     */
    public function validate()
    {
        if (systemToolkit::getInstance()->getRequest()->get($this->submit, 'string', SC_REQUEST)) {
            $valid = true;

            foreach ($this->validators as $validator) {
                if ($this->errors->exists($name = $validator->getName())) {
                    continue;
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
     * ќпределение, €вл€етс€ ли поле об€зательным к заполнению
     *
     * @param string $name им€ пол€
     * @return boolean true - €вл€етс€ об€зательным, false - не €вл€етс€ об€зательным
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
     * ѕолучение ошибок валидации
     *
     * @return arrayDataspace
     */
    public function getErrors()
    {
        return $this->errors;
    }
}

?>