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
 * simple: ���������� ����� �������
 *
 * @package simple
 * @version 0.1
 */

abstract class simple
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

    /**
     * Map. �������� ���������� � ����� (����� ���������, ����� ���������...).
     *
     * @var array
     */
    protected $map;

    /**
     * ������ ���������� �������
     */
    protected $cacheable = array();

    /**
     * �����������.
     *
     * @param array $map ������, ���������� ���������� � �����
     */
    public function __construct(Array $map)
    {
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
            throw new mzzRuntimeException('����� �������������� ������ ' . get_class($this) . '::' . $name . '()');
        }
    }

    /**
     * ����������� ������ �� ������� $data.
     * ����� �������� �� ����� �������������,
     * ���� ��� ��� ���������� � ����� ���������������
     * ������ ���� ��� (���� ����� ������� once = true).
     * ��� ������� ��� ����� �������� ��� �������� ����� ������������
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
     * ������������ ����� �������� ��� ���������� �����
     *
     * @return array
     */
    public function export()
    {
        return $this->changedFields->export();
    }

    /**
     * ��������� ������� JIP.
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
    protected function validateAttribute($name)
    {
        foreach ($this->map as $key => $val) {
            if (($val['accessor'] == $name) || ($val['mutator'] == $name)) {
                return $key;
            }
        }
    }

    /**
     * ���������� ��� ������, ���� ��� ������� � �������� 'decorateClass',
     * ������� ���������� �������� ��� ������� ����
     *
     * @param string $name ��� ����
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
     * ���������� ����������� ����������� ������ $name
     *
     * @param string $name ��� ������
     * @return boolean ����������� �����������
     */
    public function isCacheable($name)
    {
        return in_array($name, $this->cacheable);
    }


}

?>