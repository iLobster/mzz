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
    protected $rules = array();

    protected $rewrited = false;

    /**
     * Hold an instance of the class
     *
     * @var object
     * @access private
     * @static
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
            self::$instance = new $c();
        }
        return self::$instance;
    }

    private function __construct()
    {
    }

    public static function createRule($pattern, $replacement)
    {
        return array('pattern' => $pattern, 'replacement' => $replacement);
    }

    public function addRule($pattern, $replacement)
    {
        $this->rules[] = self::createRule($pattern, $replacement);
    }

    public function addGroupRule(Array $rules)
    {
        $this->rules[] = $rules;
    }

    public function rewrite($pattern, $replacement, $path)
    {

        if(preg_match($pattern, $path)) {
            return preg_replace($pattern, $replacement, $path);
        } else {
            return false;
        }
    }

    public function process($path)
    {
        foreach ($this->rules as $rule) {
            if(isset($rule['pattern'])) {
                if(($rpath = $this->rewrite($rule['pattern'], $rule['replacement'], $path)) !== false) {
                    return $rpath;
                }
            } else {
                $rpath = $path;
                foreach ($rule as $rule_element) {
                    if(($rpath = $this->rewrite($rule_element['pattern'], $rule_element['replacement'], $rpath)) !== false) {
                        $this->rewrited = true;
                    }
                }
                if($this->rewrited) {
                    $this->rewrited = false;
                    return $rpath;
                }
            }
        }
    }

    public function clear()
    {
        $this->rewrited = false;
        $this->rules = array();
    }
}

?>