<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2005
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * RequestParser: класс для получения секции, действия и других параметров
 *
 * @package system
 * @version 0.1
 */
class requestParser
{
    /**
     * Хранение результата разборки URL
     *
     * @var string
     * @access private
     */
    private $data;

    /**
     * Hold an instance of the class
     *
     * @var object
     * @access private
     * @staticvar
     */
    private static $instance;

    /**
     * Синглетон
     *
     * @static
     * @access public
     * @return object
     */
    public static function getInstance()
    {
        if ( !isset( self::$instance ) ) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }

    /**
     * Конструктор, при создании объекта вызывает функцию
     * разбора URL
     *
     * @access private
     * @return void
     */
    private function __construct()
    {
        self::parse();
    }

    /**
     * Разборка URL на section, action, params.
     *
     * @access private
     * @return void
     */
    private function parse()
    {
        $path = httprequest::get('path');

        $path = preg_replace('/\/{2,}/', '/', $path);

        // Преобразовываем /path/to/document/ в path/to/document
        $path = substr($path, 1, (strlen($path) - 1) - (strrpos($path, '/') == strlen($path) - 1));

        $params = explode('/', $path);

        self::setData('section', array_shift($params));
        $action = array_pop($params);
        self::setData('action', $action);
        // Если action задан, то заносим его так же и в params,
        // который будет использован как параметр,
        // если указанный action не существует
        if (!empty($action)) {
            $params = array_merge($params, array($action));
        }
        self::setData('params', $params);
    }

    /**
     * Сохранение результата разборки
     *
     * @param string $field
     * @param string|array $value
     * @access public
     */
    public function setData($field, $value)
    {
        $this->data[$field] = $value;
    }

    /**
     * Получение значения из результата разборки
     *
     * @param string $field
     * @return string|array|null
     * @access public
     */
    public function get($field)
    {
        return isset($this->data[$field]) ? $this->data[$field] : null;
    }
}

?>