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
 * mzzCallbackException
 *
 * @package system
 * @version 0.1
*/
class mzzCallbackException extends mzzException
{
    /**
     * �����������
     *
     * @param array|string $callback
     */
    public function __construct($callback)
    {
        $message = '������ ��� ������������ callback-�������. ';
        if (is_array($callback)) {
            $objDescription = $this->getObjectName($callback[0], $callback[1]);
            if (!$this->isValidObject($callback[0])) {
                $message .= '������ �� ���� ���� / �������� ��� ������: <i>' . $objDescription;
            } else {
                $message .= '�������� ��� ������: <i>' . $objDescription . '</i>';
            }
        } else {
            $message .= '�������� ��� �������: <i>' . $callback . '</i>';
        }
        parent::__construct($message);
        $this->setName('Callback Exception');
    }

    /**
     * ��������� �������� �� $object �������� ��� ������ ������
     *
     * @param mixed $object
     * @return boolean
     */
    private function isValidObject($object)
    {
        return (is_object($object) || (is_string($object) && class_exists($object)));
    }

    /**
     * ���������� ������ ������ ������ ���������� ��� �������
     * � ����������� �� ���� $object
     *
     * @param object|string $object
     * @param string $method
     * @return string
     */
    private function getObjectName($object, $method)
    {
        return (is_object($object) ? ('$'.get_class($object).'->') : ($object.'::')).$method.'()';
    }
}

?>