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
 * simple: ���������� ����� �������
 *
 * @package modules
 * @subpackage simple
 * @version 0.1.5
 */

abstract class simple
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = '';

    /**
     * ����
     *
     * @var arrayDataspace
     */
    protected $fields;

    /**
     * ��������� ��� ��������, ������� ������� �� �� ����� ��, � ����������� � �������
     *
     * @var arrayDataspace
     */
    protected $fakeFields;

    /**
     * ���������� ����
     *
     * @var arrayDataspace
     */
    protected $changedFields; // ������� ���?

    /**
     * Map. �������� ���������� � ����� (����� ���������, ����� ���������, ���������...).
     *
     * @var array
     */
    protected $map;

    /**
     * ������
     *
     * @var simpleMapper
     */
    protected $mapper;

    /**
     * ��� �������, � ��������� �������� � ������ ������ �������� ������ ������
     *
     * @var string
     */
    protected $section;

    /**
     * �����������.
     *
     * @param simpleMapper $mapper ������������� ������
     * @param array $map ������, ���������� ���������� � �����
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
     * ��������� �������
     *
     * @return simpleMapper
     */
    public function getMapper()
    {
        return $this->mapper;
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
        if ($attribute = $this->validateAttribute($name)) {
            list($method, $field) = $attribute;
            if ('accessor' == $method) {
                // ���� �������� ��� �������� �������� (������, �����) - �� ������� ��������� ����������� � ���� ������
                if (is_scalar($this->fields->get($field)) || is_null($this->fields->get($field))) {
                    $this->doLazyLoading($field, $args);
                }
                return $this->fields->get($field);
            } else {
                // ������������� �������� ������ � ��� ������, ���� ��������
                // ���� �� ����������� ����� ��� ��� ����� ���������� ����� ������ ����
                if (sizeof($args) < 1) {
                    throw new mzzRuntimeException('����� �������� ' . get_class($this) . '::' . $name . '() ��� ���������');
                }

                if (!$this->fields->exists($field) || !$this->isOnce($field)) {

                    if ($service = $this->isDecorated($field)) {
                        fileLoader::load('service/' . $service);
                        $service = new $service;
                        $args[0] = $service->apply($args[0]);
                    }

                    $this->changedFields->set($field, $args[0]);
                } elseif ($this->isOnce($field)) {
                    throw new mzzRuntimeException('���������� ���� ' . $field . ' �������� ������ ��� ������');
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
            if (isset($this->map[$key]) && (!$this->fields->exists($key) || !$this->isOnce($key))) {
                $this->fields->set($key, $value);
            } else {
                $this->fakeFields->set($key, $value);
            }
        }
    }

    /**
     * ���������� �������� ������������ ����
     *
     * @param string $name ��� ����
     * @return mixed
     */
    public function fakeField($name)
    {
        return $this->fakeFields->get($name);
    }

    /**
     * ������������ ����� �������� ��� ���������� �����
     *
     * @return array
     */
    public function & export()
    {
        return $this->changedFields->export();
    }

    /**
     * ������� ������ ��������
     *
     * @return array
     */
    public function & exportOld()
    {
        return $this->fields->export();
    }

    /**
     * ��������� ������� JIP.
     *
     * @param string $module
     * @param string $id
     * @param string $type
     * @param string $tpl ������ JIP-����
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
     * ��������� ������� JIP.
     * ���������������� ���� ��������� ������������ ������ ������ ��� ���������� JIP-����
     *
     * @param string $tpl ������ JIP-����
     * @return string
     */
    public function getJip($tpl = jip::DEFAULT_TEMPLATE)
    {
        return $this->getJipView($this->name, $this->getId(), get_class($this), $tpl);
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
            if (isset($val['accessor']) && $val['accessor'] == $name) {
                return array('accessor', $key);
            } elseif (isset($val['mutator']) && $val['mutator'] == $name) {
                return array('mutator', $key);
            }
        }
    }

    /**
     * ����� ��� ���������� �������� �������
     *
     * @param string $name ��� ��������
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
     * ��������� ������� �������� � �������
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
     * �����, ��������������� � ������������ ������
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
     * ����� ��� ��������� ������(�����) �����
     *
     * @return array
     */

    public function getMap()
    {
        return $this->map;
    }

    /**
     * �����, ������������ ������������� ������
     *
     * @return simpleMapper
     */

    public function mapper()
    {
        return $this->mapper;
    }
}

?>
