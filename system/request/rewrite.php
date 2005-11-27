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
 * Rewrite
 *
 * @package system
 * @version 0.1
 */
class Rewrite
{

    /**
     * �������
     *
     * @var array
     * @access protected
     */
    protected $rules = array();

    /**
     * ����� �����������
     *
     */
    const PRE = '#^';

    /**
     * ������ �����������
     *
     */
    const POST = '$#i';

    /**
     * Hold an instance of the class
     *
     * @var object
     * @access private
     * @static
     */
    private static $instance;

    /**
     * ��������
     *
     * @static
     * @access public
     * @return object
     */
    public static function getInstance()
    {
        if ( !isset( self::$instance ) ) {
            $c = __CLASS__;
            self::$instance = new $c();
        }
        return self::$instance;
    }

    /**
     * Construct
     *
     * @access private
     */
    private function __construct()
    {
    }

    /**
     * �������� �������.
     *
     * @param string $pattern ������ ��� ����������� ���������
     * @param string $replacement ������
     * @return array
     */
    public static function createRule($pattern, $replacement)
    {
        return array('pattern' => self::patternDecorate($pattern), 'replacement' => $replacement);
    }

    /**
     * Decorate pattern
     *
     * @param string $pattern
     * @return string
     */
    private static function patternDecorate($pattern)
    {
        return self::PRE . $pattern . self::POST;
    }

    /**
     * ��������� �������
     *
     * @param string $pattern
     * @param string $replacement
     */
    public function addRule($pattern, $replacement)
    {
        $this->rules[] = self::createRule($pattern, $replacement);
    }

    /**
     * ��������� ������ ������
     *
     * @param array $rules ������ �� ������, �������� createRule
     */
    public function addGroupRule(Array $rules)
    {
        $this->rules[] = $rules;
    }

    /**
     * ���������� rewrited-path ���� path ������ � ��������, ����� ���������� false
     *
     * @param string $pattern
     * @param string $replacement
     * @param string $path
     * @return string|false
     */
    protected function rewrite($pattern, $replacement, $path)
    {
        if(preg_match($pattern, $path)) {
            return preg_replace($pattern, $replacement, $path);
        } else {
            return false;
        }
    }

    /**
     * ������ rewrite. ���������� ������ ��������������� ����� �������
     * ���������� � �������� ������� ��� �������� ������� �� ������.
     * ������ ������ ����������� �� ������� ���������� � ��������.
     *
     * @param string $path
     * @return string
     */
    public function process($path)
    {
        foreach ($this->rules as $rule) {
            if(isset($rule['pattern'])) {
                if(($rpath = $this->rewrite($rule['pattern'], $rule['replacement'], $path)) !== false) {
                    return $rpath;
                }
            } else {
                foreach ($rule as $rule_element) {
                    $rpath = $path;
                    if(($rpath = $this->rewrite($rule_element['pattern'], $rule_element['replacement'], $rpath)) !== false) {
                        return $rpath;
                    }
                }
            }
        }
        return $path;
    }

    /**
     * ������� ������������� �������
     *
     */
    public function clear()
    {
        $this->rules = array();
    }

    /**
     * ������ XML-������� � ��������� ��� Rewrite.
     *
     * @param string $section
     * @return array|false
     */
    private function XMLread($section)
    {
        //���� ���-�� ����� �������� �� ���������. ����� �������� ����� �� ��������, �� � ��� �� �� ���� ���������� ;(
        //var_dump(fileLoader::resolve('core/someclassStuba'));
        $xml = simplexml_load_file(APPLICATION_DIR . 'tests/cases/request/test.xml');
        $rules = array();

        if (!empty($xml->$section)) {
            $rules = array();
            foreach ($xml->$section->rule as $rule) {
                $rules[] = self::createRule((string) $rule['pattern'], (string) $rule);
            }
            $this->addGroupRule($rules);
        } else {
            return false;
        }
    }

    /**
     * ��������� ���� ������
     *
     * @param string $section
     */
    public function getRules($section)
    {
        $this->XMLread($section);
    }
}

?>
