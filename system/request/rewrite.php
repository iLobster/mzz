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
 * Rewrite
 *
 * @package system
 * @subpackage request
 * @version 0.2
 */
class Rewrite
{

    /**
     * �������
     *
     * @var array
     */
    protected $rules = array();

    /**
     * ��������� ��������� XML
     *
     * @var object
     */
    protected $xml;

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
     * Construct
     *
     * @param string $rewriteConfigFile ����
     */
    public function __construct($rewriteConfigFile)
    {
        if(!file_exists($rewriteConfigFile)) {
            throw new mzzIoException($rewriteConfigFile);
        }

        $this->xml = simplexml_load_file($rewriteConfigFile);
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
    protected function rewriter($pattern, $replacement, $path)
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
                if(($rpath = $this->rewriter($rule['pattern'], $rule['replacement'], $path)) !== false) {
                    return $rpath;
                }
            } else {
                foreach ($rule as $rule_element) {
                    $rpath = $path;
                    if(($rpath = $this->rewriter($rule_element['pattern'], $rule_element['replacement'], $rpath)) !== false) {
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
        $rules = array();

        if (!empty($this->xml->$section)) {
            $rules = array();
            foreach ($this->xml->$section->rule as $rule) {
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
