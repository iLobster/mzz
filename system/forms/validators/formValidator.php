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
     * ������ ����������� �����
     *
     * @var array
     */
    private $validators = array();

    /**
     * ��������� ��� �������� ������ ���������
     *
     * @var arrayDataspace
     */
    private $errors;

    /**
     * ��� submit'� �����. ������ �� ���� ������������, ��� ����� ��� ���� ����������
     *
     * @var string
     */
    private $submit;

    /**
     * �����������
     *
     * @param string $submit
     */
    public function __construct($submit = 'submit')
    {
        $this->errors = new arrayDataspace();

        if (!is_string($submit)) {
            throw new mzzInvalidParameterException('�������� submit ������ ���� ���������', $submit);
        }

        $this->submit = $submit;

        fileLoader::load('forms/validators/formAbstractRule');
        systemToolkit::getInstance()->setValidator($this);
    }

    /**
     * ���������� �������
     *
     * @param string $validator ��� ����������
     * @param string $name ��� ������������ ����
     * @param string $errorMsg ��������� �� ������
     * @param mixed $params ����� �������������� ���������� ��� ���������
     */
    public function add($validator, $name, $errorMsg = '', $params = '')
    {
        $validatorName = 'form' . ucfirst($validator) . 'Rule';
        fileLoader::load('forms/validators/' . $validatorName);

        $this->validators[] = new $validatorName($name, $errorMsg, $params);
    }

    /**
     * ������ �����������
     *
     * @return boolean true - � ������, ���� �� ���� �� ����������� �� ��������� ������, false - � ��������� ������
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
     * �����������, �������� �� ���� ������������ � ����������
     *
     * @param string $name ��� ����
     * @return boolean true - �������� ������������, false - �� �������� ������������
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
     * ��������� ������ ���������
     *
     * @return arrayDataspace
     */
    public function getErrors()
    {
        return $this->errors;
    }
}

?>