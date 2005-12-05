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
 * Registry: реализация класса для хранения объектов
 *
 * @package system
 * @version 0.1
 */

class Registry {
    /**
     * Registry Stack
     *
     * @var array
     */
    protected $stack;

    /**
     * Registry
     *
     * @var Registry
     * @static
     */
    static $registry = false;

    /**
     * Construct
     *
     * @access private
     */
    private function __construct()
    {
        $this->stack = array(array());
    }

    /**
     * Сохранение объекта или имени класса
     *
     * @param string $key имя в registry
     * @param object|string $item объект или имя класса
     * @access public
     */
    public function setEntry($key, $item)
    {
        $this->stack[0][$key] = $item;
    }

    /**
     * Получение объекта сохраненного ранее под определенным именем.
     * Если была сохранена строка и существует класс с таким именем, то будет возвращен
     * объект и этот объект перезапишет запись со строкой.
     *
     * @param string $key
     * @return object|false
     */
    public function getEntry($key)
    {
        if(isset($this->stack[0][$key])) {
            if(!is_object($this->stack[0][$key])) {
                $classname = $this->stack[0][$key];
                try {
                    if(!class_exists($classname)) {
                        throw new registryException("Create object error: class " . $classname . "not found.");
                        return false;
                    } else {
                        $this->stack[0][$key] = new $classname;
                    }
                } catch (registryException $e) {
                    $e->printHtml();
                }
            }
            return $this->stack[0][$key];
        } else {
            return false;
        }
    }

    /**
     * Проверяет существует ли объект сохраненный под именем '$key'
     *
     * @param string $key
     * @return boolean
     */
    public function isEntry($key)
    {
        return ($this->getEntry($key) !== false);
    }

    /**
     * Создание объекта Registry, если объект уже создан, то
     * вернуть созданный ранее.
     *
     * @return object
     */
    public static function instance()
    {
        if (self::$registry === false) {
            self::$registry = new Registry();
        }
        return self::$registry;
    }

    /**
     * Сохранение текущего и создание нового стека для хранения
     * объектов.
     *
     * @return false если стек потерян
     */
    public function save()
    {
        array_unshift($this->stack, array());
    }

    /**
     * Удаляет текущий и восстанавливает ранее сохраненный стек.
     *
     */
    public function restore()
    {
        array_shift($this->stack);

        try {
            if (!count($this->stack)) {
                throw new registryException("Registry lost.");
                return false;
            }
        } catch (registryException $e) {
            $e->printHtml();
        }
    }
}
?>