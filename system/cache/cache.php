<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage cache
 * @version $Id$
*/

/**
 * cache: ����� ��� ������ � �����
 *
 * @package system
 * @subpackage cache
 * @version 0.3.1
 */

class cache
{
    /**
     * ��������� ��� ������
     *
     * @var arrayDataspace
     */
    private $data;

    /**
     * �����������
     *
     */
    public function __construct()
    {
        $this->drop();
    }

    /**
     * ����� ��������� ������ � ���
     *
     * @param string $identifier ������������� ����
     * @param mixed $value ��������, ���������� � ���
     */
    public function save($identifier, $value)
    {
        $this->data->set($identifier, $value);
    }

    /**
     * ����� ���������� ������ �� ����
     *
     * @param string $identifier ������������� ����
     * @return mixed
     */
    public function load($identifier)
    {
        return $this->data->get($identifier);
    }

    /**
     * ����� ��� �������� ����������� ����
     *
     */
    public function drop()
    {
        $this->data = new arrayDataspace();
    }
}

?>