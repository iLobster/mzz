<?php

class mzzCallbackException extends mzzException
{
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

    private function isValidObject($object)
    {
        return (is_object($object) || (is_string($object) && class_exists($object)));
    }

    private function getObjectName($object, $method)
    {
        return (is_object($object) ? ('$'.get_class($object).'->') : ($object.'::')).$method.'()';
    }
}

?>