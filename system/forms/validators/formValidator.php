<?php

fileLoader::load('forms/validators/validator');

class formValidator extends validator
{
    /**
     * Имя поля по которому проверяется отправлена форма или нет
     *
     * @var string
     */
    protected $submit = 'submit';

    /**
     * Проверять csrf или нет
     *
     * @var boolean
     */
    protected $csrf = true;

    /**
     * Конструктор
     *
     * @param array|null $data - массив данных для проверки, если не задан,
     *                           то берутся из POST и GET данные из $request
     * @param boolean $csrf - флаг проверки CSRF-атак
     */
    public function __construct($data = null, $csrf = true)
    {
        parent::__construct($data);

        if (is_null($data)) {
            $request = systemToolkit::getInstance()->getRequest();
            $this->data = $request->exportPost() + $request->exportGet();
        }

        $this->csrf = ($csrf === false) ? false : true;
    }

    /**
     * Выключает проверку от CSRF-атак
     *
     */
    public function disableCSRF()
    {
        $this->csrf = false;
    }

    /**
     * Включает проверку от CSRF-атак
     *
     */
    public function enableCSRF()
    {
        $this->csrf = true;
    }


    /**
     * Задает имя поля, по которому проверяется отправлена форма или нет
     *
     * @param string $submit
     */
    public function submit($submit)
    {
        foreach ($this->rules as $key => $rule) {
            if ($rule['name'] == $this->submit) {
                unset($this->rules[$key]);
                break;
            }
        }

        $this->submit = $submit;
    }

    public function validate()
    {
        if (!$this->getValue($this->submit, $submit)) {
            return;
        }

        if (!$this->filtered) {
            $this->runFilters();
        }

        foreach ($this->rules() as $rule) {
            if ($this->isFieldError($rule['name'])) {
                continue;
            }

            $this->getValue($rule['name'], $value);

            if (is_null($value) || $value === '') {
                $rule['validator']->notExists();
            }

            if (!$rule['validator']->validate($value, $rule['name'])) {
                $this->setError($rule['name'], $rule['validator']->getErrorMsg());
            }
        }

        return $this->isValid();
    }

    private function rules()
    {

        if (!$this->csrf) {
            return $this->rules;
        }

        $required = $this->loadValidator('required');
        $required->setData($this->data);
        $csrf = $this->loadValidator('csrf');
        $csrf->setData($this->data);

        $csrf_rules = array(
            array(
                'name' => '_csrf_token',
                'validator' => $required),
            array(
                'name' => '_csrf_token',
                'validator' => $csrf));

        return array_merge($this->rules, $csrf_rules);

    }

    private function getValue($name, & $value)
    {
        $indexName = $this->hasBrackets($name);

        if (!isset($this->data[$name])) {
            $value = null;
            return false;
        }

        $value = $this->data[$name];

        if ($indexName) {
            $value = arrayDataspace::extractFromArray($indexName, $value);
        }

        return true;
    }

    private function hasBrackets(&$name)
    {
        if ($bracket = strpos($name, '[')) {
            $indexName = substr($name, $bracket);
            $name = substr($name, 0, $bracket);

            return $indexName;
        }
    }

    protected function getFromRequest($name, $type = 'string')
    {
        $funcName = 'get' . ucfirst(strtolower($type));
        $request = systemToolkit::getInstance()->getRequest();
        return $request->$funcName($name, SC_REQUEST);
    }
}

?>