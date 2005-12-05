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
     * ���������� ������� ��� ����� ������
     *
     * @param string $key ��� � registry
     * @param object|string $item ������ ��� ��� ������
     * @access public
     */
    public function setEntry($key, $item)
    {
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
     * ��������� ���������� �� ������ ����������� ��� ������ '$key'
     *
     * @param string $key
     * @return boolean
     */
    public function isEntry($key)
    {
        return ($this->getEntry($key) !== false);
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
     * @return false ���� ���� �������
     */
    public function save()
    {
        array_unshift($this->stack, array());
    }

    /**
     * ������� ������� � ��������������� ����� ����������� ����.
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