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

/**
 * newsFolder: newsFolder
 *
 * @package news
 * @version 0.1
 */

class newsFolder
{
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

    protected $map;
    private $mapper;
    private $folders;
    private $items;

    public function __construct($mapper, Array $map)
    {
        $this->mapper = $mapper;
        $this->map = $map;
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
                return $this->fields->get($attribute);
            } else {
                // Устанавливает значение только в том случае, если значение
                // поля не установлено ранее или оно может изменяться более одного раза
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
            throw new mzzRuntimeException('Вызов неопределённого метода ' . __CLASS__ . '::' . $name . '()');
        }
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
    private  function validateAttribute($name)
    {
        foreach ($this->map as $key => $val) {
            if (($val['accessor'] == $name) || ($val['mutator'] == $name)) {
                return $key;
            }
        }
    }

    protected function isDecorated($name)
    {
        if (isset($this->map[$name]['decorateClass'])) {
                return $this->map[$name]['decorateClass'];
        }
        return false;
    }

    public function getFolders()
    {
        // может тут как то сделать "кеширование" ? а то при запросе дважды ->getFolders() маппер будет опрошен тоже дважды.. появится трабла если папки будут изменены между первым и вторым запросом - но опять же, пока прецедента нет - может сделать кеширование?
        if (!$this->fields->exists('folders')) {
            $this->fields->set('folders', $this->mapper->getFolders($this->getId()));
        }
        return $this->fields->get('folders');
    }

    public function getItems()
    {
        if (!$this->fields->exists('items')) {
            $this->fields->set('items', $this->mapper->getItems($this->getId()));
        }
        return $this->fields->get('items');
    }
}

?>