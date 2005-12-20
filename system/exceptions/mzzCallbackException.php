<?php

class mzzCallbackException extends mzzException
{
    public function __construct($callback)
    {
        $message = 'Ошибка при использоании callback-методов. ';
        if (is_array($callback)) {
            $objDescription = $this->getObjectName($callback[0], $callback[1]);
            if (!$this->isValidObject($callback[0])) {
                $message .= 'Объект не того типа / неверное имя класса: <i>' . $objDescription;
            } else {
                $message .= 'Неверное имя метода: <i>' . $objDescription . '</i>';
            }
        } else {
            $message .= 'Неверное имя функции: <i>' . $callback . '</i>';
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