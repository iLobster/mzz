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

fileLoader::load('jip/jip');

/**
 * simple: реализация общих методов
 *
 * @package modules
 * @subpackage simple
 * @version 0.1.5
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
     * Датаспейс для значений, которые берутся не из полей БД, а вычисляются в запросе
     *
     * @var arrayDataspace
     */
    protected $fakeFields;

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
     * Маппер
     *
     * @var simpleMapper
     */
    protected $mapper;

    /**
     * Имя раздела, в контексте которого в данный момент работает данный модуль
     *
     * @var string
     */
    protected $section;

    /**
     * Конструктор.
     *
     * @param simpleMapper $mapper обслуживающий маппер
     * @param array $map массив, содержащий информацию о полях
     */
    public function __construct($mapper, Array $map)
    {
        $this->map = $map;
        $this->mapper = $mapper;

        $this->mapper->addObjId($this->map);

        $this->fields = new arrayDataspace();
        $this->changedFields = new arrayDataspace();
        $this->fakeFields = new arrayDataspace();
    }

    /**
     * Получение маппера
     *
     * @return simpleMapper
     */
    public function getMapper()
    {
        return $this->mapper;
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
        if ($attribute = $this->validateAttribute($name)) {
            list($method, $field) = $attribute;
            if ('accessor' == $method) {
                // если свойство ещё является скаляром (строка, число) - то пробуем загрузить относящийся к нему объект
                if (is_scalar($this->fields->get($field)) || is_null($this->fields->get($field))) {
                    $this->doLazyLoading($field, $args);
                }
                return $this->fields->get($field);
            } else {
                // Устанавливает значение только в том случае, если значение
                // поля не установлено ранее или оно может изменяться более одного раза
                if (sizeof($args) < 1) {
                    throw new mzzRuntimeException('Вызов мутатора ' . get_class($this) . '::' . $name . '() без аргумента');
                }

                if (!$this->fields->exists($field) || !$this->isOnce($field)) {

                    if ($service = $this->isDecorated($field)) {
                        fileLoader::load('service/' . $service);
                        $service = new $service;
                        $args[0] = $service->apply($args[0]);
                    }

                    $this->changedFields->set($field, $args[0]);
                } elseif ($this->isOnce($field)) {
                    throw new mzzRuntimeException('Изменяемое поле ' . $field . ' доступно только для чтения');
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
            if (isset($this->map[$key]) && (!$this->fields->exists($key) || !$this->isOnce($key))) {
                $this->fields->set($key, $value);
            } else {
                $this->fakeFields->set($key, $value);
            }
        }
    }

    /**
     * Возвращает значение вычисленного поля
     *
     * @param string $name имя поля
     * @return mixed
     */
    public function fakeField($name)
    {
        return $this->fakeFields->get($name);
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

    /**
     * Экспорт старых значений
     *
     * @return array
     */
    public function & exportOld()
    {
        return $this->fields->export();
    }

    /**
     * Получение объекта JIP.
     *
     * @param string $module
     * @param string $id
     * @param string $type
     * @param string $tpl шаблон JIP-меню
     * @return string
     */
    protected function getJipView($module, $id, $type, $tpl = jip::DEFAULT_TEMPLATE)
    {
        $toolkit = systemToolkit::getInstance();
        $action = $toolkit->getAction($module);
        $request = $toolkit->getRequest();
        $jip = new jip($request->getSection(), $module, $id, $type, $action->getJipActions($type), $this->getObjId(), $tpl);
        return $jip->draw();
    }

    /**
     * Получение объекта JIP.
     * Переопределяется если требуется использовать другие данные для построения JIP-меню
     *
     * @param string $tpl шаблон JIP-меню
     * @return string
     */
    public function getJip($tpl = jip::DEFAULT_TEMPLATE)
    {
        return $this->getJipView($this->name, $this->getId(), get_class($this), $tpl);
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
            if (isset($val['accessor']) && $val['accessor'] == $name) {
                return array('accessor', $key);
            } elseif (isset($val['mutator']) && $val['mutator'] == $name) {
                return array('mutator', $key);
            }
        }
    }

    /**
     * Метод для отложенной загрузки объекта
     *
     * @param string $name имя свойства
     */
    protected function doLazyLoading($name, $args)
    {
        if (isset($this->map[$name]['owns'])) {
            list($className, $fieldName) = explode('.', $this->map[$name]['owns'], 2);
            if (isset($this->map[$name]['do'])) {
                $className = $this->map[$name]['do'];
            }

            $sectionName = isset($this->map[$name]['section']) ? $this->map[$name]['section'] : $this->section();
            $moduleName = isset($this->map[$name]['module']) ? $this->map[$name]['module'] : $this->name;

            $toolkit = systemToolkit::getInstance();
            $mapper = $toolkit->getMapper($moduleName, $className, $sectionName);

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

            $toolkit = systemToolkit::getInstance();
            $mapper = $toolkit->getMapper($moduleName, $className, $sectionName);

            $accessor = $this->map[$field]['accessor'];

            $criteria = new criteria();
            $criteria->add($fieldName, $this->$accessor());

            if (isset($args[0]) && $args[0] instanceof criteria) {
                $criteria->append($args[0]);
            }

            $this->fields->set($name, $mapper->searchAllByCriteria($criteria));
        }
    }

    /**
     * установка объекта пейджера в маппере
     *
     * @param pager $pager
     */
    public function setPager($pager)
    {
        $this->mapper->setPager($pager);
    }

    public function removePager()
    {
        $this->mapper->removePager();
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
    /**
     * Метод для получения списка(карты) полей
     *
     * @return array
     */

    public function getMap()
    {
        return $this->map;
    }

    /**
     * Метод, возвращающий обслуживающий маппер
     *
     * @return simpleMapper
     */

    public function mapper()
    {
        return $this->mapper;
    }
}

?>
