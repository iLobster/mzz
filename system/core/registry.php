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
 * Registry: ���������� ������ ��� �������� ��������
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
     */
    static $registry = false;

    /**
     * Construct
     *
     */
    private function __construct()
    {
        $this->stack = array(array());
    }

    /**
     * ���������� ������� ��� ����� ������
     *
     * @param string $key ��� � registry
     * @param object|string $item ������ ��� ��� ������
     */
    public function setEntry($key, $item)
    {
        if($this->isEntry($key)) {
            throw new mzzRuntimeException("Registry: '" . $key . "' already registered.");
            return false;
        }
        $this->stack[0][$key] = $item;
    }

    /**
     * ��������� ������� ������������ ����� ��� ������������ ������.
     * ���� ���� ��������� ������ � ���������� ����� � ����� ������, �� ����� ���������
     * ������ � ���� ������ ����������� ������ �� �������.
     *
     * @param string $key
     * @return object|false
     */
    public function getEntry($key)
    {
        if(isset($this->stack[0][$key])) {
            if(!is_object($this->stack[0][$key])) {
                $classname = $this->stack[0][$key];

                if(!class_exists($classname)) {
                    throw new mzzRuntimeException("Registry: create object error: class '" . $classname ."' not found for entry '" . $key . "'.");
                    return false;
                } else {
                    $this->stack[0][$key] = new $classname;
                }
            }
            return $this->stack[0][$key];
        } else {
            return false;
        }
    }

    /**
     * ��������� ���������� �� ������ ����������� ��� ������ '$key'
     *
     * @param string $key
     * @return boolean
     */
    public function isEntry($key)
    {
        return isset($this->stack[0][$key]);
    }

    /**
     * �������� ������� Registry, ���� ������ ��� ������, ��
     * ������� ��������� �����.
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
     * ���������� �������� � �������� ������ ����� ��� ��������
     * ��������.
     *
     */
    public function save()
    {
        array_unshift($this->stack, array());
    }

    /**
     * ������� ������� � ��������������� ����� ����������� ����.
     *
     * @return false ���� ���� �������
     */
    public function restore()
    {
        array_shift($this->stack);

        if (!count($this->stack)) {
            throw new mzzRuntimeException("Registry lost.");
            return false;
        }
    }
}
?>