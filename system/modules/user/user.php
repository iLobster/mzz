<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

fileLoader::load('dataspace/arrayDataspace');

/**
 * user: user
 *
 * @package user
 * @version 0.1
 */

class user
{
    /**
     * ѕол€
     *
     * @var array
     */
    protected $fields = array();

    /**
     * Map. —одержит информацию о пол€х (метод изменени€, метод получени€...).
     *
     * @var array
     */
    protected $map;

    protected $mapper;

    /**
     *  онструктор.
     *
     * @param array $map массив, содержащий информацию о пол€х
     */
    public function __construct($mapper, Array $map)
    {
        $this->mapper = $mapper;
        $this->map = $map;
        $this->fields = new arrayDataspace($this->fields);
    }

    /**
     * __call метод. ≈сли метод не определен в классе, провер€ет существует ли $name
     * в информации о пол€х и возвращает значение пол€, им€ которого передано в
     * аргументе. ”станавливает значение дл€ этого пол€ если метод имеет префикс 'set'
     * и получает если 'get' иначе бросает исключение
     *
     *
     * @param string $name им€ метода
     * @param array $args аргументы
     * @return mixed
     */
    public function __call($name, $args)
    {
        if (preg_match('/^(get|set)(\w+)/', strtolower($name), $match) && $attribute = $this->validateAttribute($name)) {
            if ('get' == $match[1]) {
                return $this->fields->get($attribute);
            } else {
                // ”станавливает значение только в том случае, если значение
                // пол€ не установлено ранее или оно может измен€тьс€ более одного раза
                if ( ($this->isOnce($attribute) && $this->fields->exists($attribute) == false) || !$this->isOnce($attribute) ) {
                    $this->fields->set($attribute, $args[0]);
                }
            }
        } else {
            throw new mzzRuntimeException('¬ызов неопределЄнного метода ' . __CLASS__ . '::' . $name . '()');
        }
    }
/*
    public function setPassword($password)
    {
        $this->__call('setPassword', array(md5($password)));
        var_dump($password);
    }*/

    /**
     * ѕровер€ет может ли поле измен€тьс€ более одного раза
     *
     * @param string $attribute
     * @return boolean false если может измен€тьс€ более одного раза, true только один раз
     */
    protected function isOnce($attribute)
    {
        return isset($this->map[$attribute]['once']) && $this->map[$attribute]['once'];
    }

    /**
     * ¬озвращает им€ пол€ если существует метод $name в информации о пол€х
     *
     * @param string $name
     * @return string
     */
    private function validateAttribute($name)
    {
        foreach ($this->map as $key => $val) {
            if (($val['accessor'] == $name) || ($val['mutator'] == $name)) {
                return $key;
            }
        }
    }

}

?>