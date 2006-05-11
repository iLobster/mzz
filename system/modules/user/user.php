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
 * @version 0.1.1
 */

class user
{
    /**
     * ����
     *
     * @var arrayDataspace
     */
    protected $fields;

    /**
     * ���������� ����
     *
     * @var arrayDataspace
     */
    protected $changedFields; // ������� ���?

    protected $new = true;

    /**
     * Map. �������� ���������� � ����� (����� ���������, ����� ���������...).
     *
     * @var array
     */
    protected $map;

    protected $mapper;

    /**
     * �����������.
     *
     * @param array $map ������, ���������� ���������� � �����
     */
    public function __construct($mapper, Array $map)
    {
        $this->mapper = $mapper;
        $this->map = $map;
        $this->fields = new arrayDataspace();
        $this->changedFields = new arrayDataspace();
    }

    /**
     * __call �����. ���� ����� �� ��������� � ������, ��������� ���������� �� $name
     * � ���������� � ����� � ���������� �������� ����, ��� �������� �������� �
     * ���������. ������������� �������� ��� ����� ���� ���� ����� ����� ������� 'set'
     * � �������� ���� 'get' ����� ������� ����������
     *
     *
     * @param string $name ��� ������
     * @param array $args ���������
     * @return mixed
     */
    public function __call($name, $args)
    {
        if (preg_match('/^(get|set)(\w+)/', strtolower($name), $match) && $attribute = $this->validateAttribute($name)) {
            if ('get' == $match[1]) {
                return $this->fields->get($attribute);
            } else {
                // ������������� �������� ������ � ��� ������, ���� ��������
                // ���� �� ����������� ����� ��� ��� ����� ���������� ����� ������ ����
                if ( ($this->isOnce($attribute) && $this->fields->exists($attribute) == false) || !$this->isOnce($attribute) ) {
                    $this->changedFields->set($attribute, $args[0]);
                }
            }
        } else {
            throw new mzzRuntimeException('����� �������������� ������ ' . __CLASS__ . '::' . $name . '()');
        }
    }

    public function isLoggedIn()
    {
        $id = $this->getId();
        return ($id != 1 && !empty($id));
    }

    public function uploadData($data)
    {
        $this->changedFields->clear();

        foreach($data as $key => $val) {
            $this->fields->set($key, $val);
        }
    }

    public function extract()
    {
        return $this->changedFields->export();
    }

    public function save()
    {
        $this->new = false;
        return $this->fields->merge($this->changedFields);
    }

    /**
     * ��������� ����� �� ���� ���������� ����� ������ ����
     *
     * @param string $attribute
     * @return boolean false ���� ����� ���������� ����� ������ ����, true ������ ���� ���
     */
    protected function isOnce($attribute)
    {
        return isset($this->map[$attribute]['once']) && $this->map[$attribute]['once'];
    }

    /**
     * ���������� ��� ���� ���� ���������� ����� $name � ���������� � �����
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