<?php
// парсер урла
class requestParser
{
    private $data;
    private static $instance;

    public static function getInstance()
    {
        if ( !isset( self::$instance ) ) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }
    private function __construct()
    {
        self::parse();
    }
    private function parse()
    {
        // В будущем получать будет httprequest
        $path = isset($_GET['path'])?$_GET['path']:'';

        // Выборка всех параметров
        preg_match_all("#(?<=\/(?!do\-))[-a-z0-9]+(?=\/|\/?$)#i",$path,$params);

        // Отделяем названия модуля
        self::setData('section', array_shift($params[0]));
        self::setData('params', $params[0]);
/*
        // Дополнительные GET параметры
        $get_position = strpos( $path, '/?' );
        if($get_position !== false) {
            $get = substr($path, $get_position+1);
            self::setData('get', $get);
        }
        */

        // Выборка action
        $action_position = strpos( $path, 'do-' );
        if($action_position !== false) {
            $action = substr($path, $action_position+3);
            $action_position_end = strpos( $action, '/' );
            if($action_position_end === false) {
                $action_position_end = strlen($action);
            }
            $action = substr($path, $action_position+3,$action_position_end);
            self::setData('action', $action);
        }

    }
    public function setData( $field, $value )
    {
        $this->data[$field] = $value;
    }
    public function get( $field )
    {
        return isset( $this->data[$field] ) ? $this->data[$field] : null;
    }
    public function debug() {
        return print_r($this->data,1);
    }
}

/***********************************
// for debuging:
$b = requestParser::getInstance();
echo $b->debug();
***********************************/
?>