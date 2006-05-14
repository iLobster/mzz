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
 * @version 0.1.2
 */

class user
{
    /**
     * ѕол€
     *
     * @var arrayDataspace
     */
    protected $fields;

    /**
     * »змененные пол€
     *
     * @var arrayDataspace
     */
    protected $changedFields; // сменить им€?

    protected $new = true;

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
        $this->fields = new arrayDataspace();
        $this->changedFields = new arrayDataspace();
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
                if (!$this->fields->exists($attribute) || !$this->isOnce($attribute)) {

                    if($service = $this->isDecorated($attribute)) {
                        fileLoader::load('service/' . $service);
                        $service = new $service;
                        $args[0] = $service->apply($args[0]); 
                    }

                    $this->changedFields->set($attribute, $args[0]);
                }
            }
        } else {
            throw new mzzRuntimeException('¬ызов неопределЄнного метода ' . __CLASS__ . '::' . $name . '()');
        }
    }

    public function isLoggedIn()
    {
        $id = $this->getId();
        return ($id != 1 && !empty($id));
    }

    public function import($data)
    {
        $this->changedFields->clear();

        foreach($data as $key => $value) {
            if (!$this->fields->exists($key) || !$this->isOnce($key)) {
                $this->fields->set($key, $value);
            }
        }
    }

    public function export()
    {
        return $this->changedFields->export();
    }

    public function save()
    {
        $this->new = false;
        return $this->fields->merge($this->changedFields);
    }

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

    /**
     * ¬озвращает им€ decorate-класса, если он указан в decorateClass
     *
     * @return string|false
     */
    protected function isDecorated($name)
    {
        if (isset($this->map[$name]['decorateClass'])) {
                return $this->map[$name]['decorateClass']; 
        }        
        return false;
    }

    /**
     * ¬озвращает имена полей, у которых указан decorateClass
     *
     * @return array
     
    public function isDecorated($name)
    {
        foreach ($this->map as $key => $val) { 
            if (isset($val['decorateClass']) && $val['decorateClass'] != false) {
                if(isset($fields[$key])) { echo $key;
                    fileLoader::load('service/' . $val['decorateClass']);
                    $service = new $val['decorateClass'];
                    $fields[$key] = $service->apply($fields[$key]); 
                }
            }
        }
        return $fields;
    }*/

}

?>