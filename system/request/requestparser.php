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
        $path = httprequest::get('path');
        preg_match_all("#\/?([-_a-zA-Z0-9]+)\/?#", $path, $params);

        // Отделяем
        $action = array(array_pop($params[1]));
        self::setData('section', array_shift($params[1]));
        self::setData('action', $action);
        self::setData('params', array_merge($params[1], $action));

    }

    public function setData( $field, $value )
    {
        $this->data[$field] = $value;
    }

    public function get( $field )
    {
        return isset( $this->data[$field] ) ? $this->data[$field] : null;
    }

    public function debug()
    {
        return print_r($this->data,1);
    }
}

/***********************************
// for debuging:
$b = requestParser::getInstance();
echo $b->debug();
***********************************/
?>