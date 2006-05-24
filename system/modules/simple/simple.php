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

fileLoader::load('jip/jip');
fileLoader::load('dataspace/arrayDataspace');

/**
 * simple: реализаци€ общих методов
 *
 * @package simple
 * @version 0.1
 */

abstract class simple
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

    /**
     * Map. —одержит информацию о пол€х (метод изменени€, метод получени€...).
     *
     * @var array
     */
    protected $map;

    /**
     * ћассив кешируемых методов
     */
    protected $cacheable = array();

    /**
     *  онструктор.
     *
     * @param array $map массив, содержащий информацию о пол€х
     */
    public function __construct(Array $map)
    {
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
            throw new mzzRuntimeException('¬ызов неопределЄнного метода ' . get_class($this) . '::' . $name . '()');
        }
    }

    /**
     * »мпортирует данные из массива $data.
     * Ќовое значение не будет импортировано,
     * если оно уже существует и может устанавливатьс€
     * только один раз (поле имеет атрибут once = true).
     * ѕри импорте все новые значени€ дл€ изменных полей сбрасываютс€
     *
     * @param array $data
     */
    public function import(Array $data)
    {
        $this->changedFields->clear();

        foreach($data as $key => $value) {
            if (!$this->fields->exists($key) || !$this->isOnce($key)) {
                $this->fields->set($key, $value);
            }
        }
    }

    /**
     * Ёкспортирует новые значени€ дл€ измененных полей
     *
     * @return array
     */
    public function export()
    {
        return $this->changedFields->export();
    }

    /**
     * ѕолучение объекта JIP.
     *
     * @param string $section
     * @param string $module
     * @param string $id
     * @param string $type
     * @return string
     */
    protected function getJip($section, $module, $id, $type)
    {
        $toolkit = systemToolkit::getInstance();
        $action = $toolkit->getAction($module);

        $jip = new jip($section, $module, $id, $type, $action->getJipActions());
        return $jip->draw();
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
    protected function validateAttribute($name)
    {
        foreach ($this->map as $key => $val) {
            if (($val['accessor'] == $name) || ($val['mutator'] == $name)) {
                return $key;
            }
        }
    }

    /**
     * ¬озвращает им€ класса, если оно указано в атрибуте 'decorateClass',
     * который декорирует значение дл€ данного пол€
     *
     * @param string $name им€ пол€
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
     * возвращает возможность кешировани€ метода $name
     *
     * @param string $name им€ метода
     * @return boolean возможность кешировани€
     */
    public function isCacheable($name)
    {
        return in_array($name, $this->cacheable);
    }


}

?>