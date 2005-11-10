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
        self::setData('section', array_shift($params[1]));
        $action = array_pop($params[1]);
        self::setData('action', $action);
        if(!empty($action)) {
            $params[1] = array_merge($params[1], array($action));
        }
        self::setData('params', $params[1]);
        print_r($this->data);

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

?>