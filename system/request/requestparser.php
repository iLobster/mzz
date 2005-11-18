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
 * RequestParser: ����� ��� ��������� ������, �������� � ������ ����������
 *
 * @package system
 * @version 0.1
 */
class requestParser
{
    /**
     * �������� ���������� �������� URL
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
     * @static
     */
    private static $instance;

    /**
     * HttpRequest object
     *
     * @var object
     * @access private
     */
    private $httprequest;

    /**
     * ��������
     *
     * @static
     * @access public
     * @return object
     */
    public static function getInstance($httprequest)
    {
        if ( !isset( self::$instance ) ) {
            $c = __CLASS__;
            self::$instance = new $c($httprequest);
        }
        return self::$instance;
    }

    /**
     * �����������, ��� �������� ������� �������� �������
     * ������� URL
     *
     * @access private
     * @return void
     */
    private function __construct($httprequest)
    {
        $this->httprequest = $httprequest;
        self::parse();
    }

    /**
     * �������� URL �� section, action, params.
     *
     * @access private
     * @return void
     */
    private function parse()
    {
        $path = preg_replace('/\/{2,}/', '/', $this->httprequest->get('path'));

        // ��������������� /path/to/document/ � path/to/document
        $path = substr($path, 1, (strlen($path) - 1) - (strrpos($path, '/') == strlen($path) - 1));

        $params = explode('/', $path);

        self::set('section', array_shift($params));
        $action = array_pop($params);
        self::set('action', $action);
        // ���� action �����, �� ������� ��� ��� �� � � params,
        // ������� ����� ����������� ��� ��������,
        // ���� ��������� action �� ����������
        if (!empty($action)) {
            $params = array_merge($params, array($action));
        }
        self::set('params', $params);
    }

    /**
     * ���������� ���������� ��������
     *
     * @param string $field
     * @param string|array $value
     * @access public
     */
    public function set($field, $value)
    {
        $this->data[$field] = $value;
    }

    /**
     * ��������� �������� �� ���������� ��������
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