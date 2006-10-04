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
 * simple: реализация общих методов
 *
 * @package modules
 * @subpackage simple
 * @version 0.1
 */

abstract class simple
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = '';

    /**
     * Поля
     *
     * @var arrayDataspace
     */
    protected $fields;

    /**
     * Измененные поля
     *
     * @var arrayDataspace
     */
    protected $changedFields; // сменить имя?

    /**
     * Map. Содержит информацию о полях (метод изменения, метод получения, отношения...).
     *
     * @var array
     */
    protected $map;

    /**
     * Поле в таблице для хранения уникального идентификатора доменного объекта
     * Если это поле используется в других целях переопределяйте его в наследуемом классе
     *
     * @var string
     */
    protected $obj_id_field = "obj_id";

    /**
     * Имя раздела, в контексте которого в данный момент работает данный модуль
     *
     * @var string
     */
    protected $section;

    /**
     * Массив кешируемых методов
     *
     * @deprecated
     */
    //protected $cacheable = array();

    /**
     * Конструктор.
     *
     * @param array $map массив, содержащий информацию о полях
     */
    public function __construct(Array $map)
    {
        $this->map = $map;

        $this->map[$this->obj_id_field] = array (
        'name' => $this->obj_id_field,
        'accessor' => 'getObjId',
        'mutator' => 'setObjId',
        'once' => 'true'
        );

        $this->fields = new arrayDataspace();
        $this->changedFields = new arrayDataspace();
    }

    /**
     * __call метод. Если метод не определен в классе, проверяет существует ли $name
     * в информации о полях и возвращает значение поля, имя которого передано в
     * аргументе. Устанавливает значение для этого поля если метод имеет префикс 'set'
     * и получает если 'get' иначе бросает исключение
     *
     *
     * @param string $name имя метода
     * @param array $args аргументы
     * @return mixed
     */
    public function __call($name, $args)
    {
        if (preg_match('/^(get|set)(\w+)/', strtolower($name), $match) && $attribute = $this->validateAttribute($name)) {
            if ('get' == $match[1]) {
                // если свойство ещё является скаляром (строка, число) - то пробуем загрузить относящийся к нему объект
                if (is_scalar($this->fields->get($attribute)) || is_null($this->fields->get($attribute))) {
                    $this->doLazyLoading($attribute);
                }
                return $this->fields->get($attribute);
            } else {
                // Устанавливает значение только в том случае, если значение
                // поля не установлено ранее или оно может изменяться более одного раза
                if (sizeof($args) < 1) {
                    throw new mzzRuntimeException('Вызов метода ' . get_class($this) . '::' . $name . '() без аргумента');
                }

                if (!$this->fields->exists($attribute) || !$this->isOnce($attribute)) {

                    if ($service = $this->isDecorated($attribute)) {
                        fileLoader::load('service/' . $service);
                        $service = new $service;
                        $args[0] = $service->apply($args[0]);
                    }

                    $this->changedFields->set($attribute, $args[0]);
                }
            }
        } else {
            throw new mzzRuntimeException('Вызов неопределённого метода ' . get_class($this) . '::' . $name . '()');
        }
    }

    /**
     * Импортирует данные из массива $data.
     * Новое значение не будет импортировано,
     * если оно уже существует и может устанавливаться
     * только один раз (поле имеет атрибут once = true).
     * При импорте все новые значения для изменных полей сбрасываются
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
     * Экспортирует новые значения для измененных полей
     *
     * @return array
     */
    public function & export()
    {
        return $this->changedFields->export();
    }

    public function exportOld()
    {
        return $this->fields->export();
    }

    /**
     * Получение объекта JIP.
     *
     * @param string $module
     * @param string $id
     * @param string $type
     * @return string
     */
    protected function getJipView($module, $id, $type)
    {
        $toolkit = systemToolkit::getInstance();
        $action = $toolkit->getAction($module);
        $request = $toolkit->getRequest();
        $jip = new jip($request->getSection(), $module, $id, $type, $action->getJipActions($type));
        return $jip->draw();
    }

    /**
     * Проверяет может ли поле изменяться более одного раза
     *
     * @param string $attribute
     * @return boolean false если может изменяться более одного раза, true только один раз
     */
    protected function isOnce($attribute)
    {
        return isset($this->map[$attribute]['once']) && $this->map[$attribute]['once'];
    }

    /**
     * Возвращает имя поля если существует метод $name в информации о полях
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
     * Метод для отложенной загрузки объекта
     *
     * @param string $name имя свойства
     */
    protected function doLazyLoading($name)
    {
        if (isset($this->map[$name]['owns'])) {
            list($className, $fieldName) = explode('.', $this->map[$name]['owns'], 2);
            if (isset($this->map[$name]['do'])) {
                $className = $this->map[$name]['do'];
            }

            $sectionName = isset($this->map[$name]['section']) ? $this->map[$name]['section'] : $this->section();
            $moduleName = isset($this->map[$name]['module']) ? $this->map[$name]['module'] : $this->name;
            $alias = isset($this->map[$name]['alias']) ? $this->map[$name]['alias'] : 'default';

            $toolkit = systemToolkit::getInstance();
            $mapper = $toolkit->getMapper($moduleName, $className, $sectionName, $alias);

            $object = $mapper->searchOneByField($fieldName, $this->fields->get($name));

            $this->fields->set($name, $object);
        }

        if (isset($this->map[$name]['hasMany'])) {
            list($field, $tmp) = explode('->', $this->map[$name]['hasMany'], 2);
            list($className, $fieldName) = explode('.', $tmp);
            if (isset($this->map[$name]['do'])) {
                $className = $this->map[$name]['do'];
            }

            $sectionName = isset($this->map[$name]['section']) ? $this->map[$name]['section'] : $this->section();
            $moduleName = isset($this->map[$name]['module']) ? $this->map[$name]['module'] : $this->name;
            $alias = isset($this->map[$name]['alias']) ? $this->map[$name]['alias'] : 'default';

            $toolkit = systemToolkit::getInstance();
            $mapper = $toolkit->getMapper($moduleName, $className, $sectionName, $alias);

            $accessor = $this->map[$field]['accessor'];

            $this->fields->set($name, $mapper->searchAllByField($fieldName, $this->$accessor()));
        }
    }

    /**
     * Возвращает имя класса, если оно указано в атрибуте 'decorateClass',
     * который декорирует значение для данного поля
     *
     * @param string $name имя поля
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
     * Метод, устанавливающий и возвращающий секцию
     *
     * @param string $section
     * @return string
     */
    public function section($section = null)
    {
        if (!is_null($section)) {
            $this->section = $section;
        }
        return $this->section;
    }

    public function getMap()
    {
        return $this->map;
    }

    /**
     * возвращает возможность кеширования метода $name
     *
     * @param string $name имя метода
     * @return boolean возможность кеширования
     */
    /*
    public function isCacheable($name)
    {
    return in_array($name, $this->cacheable);
    }
    */
}

?>