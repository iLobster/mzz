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

    //const DELIMITER = "#";

    protected $rewrited = false;
    
    const PRE = '#^';
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
     * Синглтон
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
        return array('pattern' => self::patternDecorate($pattern), 'replacement' => $replacement);
    }
    
    private static function patternDecorate($pattern)
    {
        return self::PRE . $pattern . self::POST;
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
                foreach ($rule as $rule_element) {
                    $rpath = $path;
                    if(($rpath = $this->rewrite($rule_element['pattern'], $rule_element['replacement'], $rpath)) !== false) {
                        return $rpath;
                    } 
                }
                /*if($this->rewrited) {
                    $this->rewrited = false;
                    return $rpath;
                }*/
            }
        }
    }

    public function clear()
    {
        $this->rewrited = false;
        $this->rules = array();
    }
    
    private function XMLread($section)
    {
        //путь как-то нужно получать из резолвера. нужно написать какой то резолвер, но я как то не могу сообразить ;(
        //var_dump(fileLoader::resolve('core/someclassStuba'));
        $xml = simplexml_load_file(APPLICATION_DIR . 'tests/cases/request/test.xml');
        $rules = array();
        foreach ($xml->common->rule as $rule) {
            $rules[] = self::createRule((string) $rule['pattern'], (string) $rule);
        }
        $this->addGroupRule($rules);

        if (!empty($xml->$section)) {
            $rules = array();
            foreach ($xml->$section->rule as $rule) {
                $rules[] = self::createRule((string) $rule['pattern'], (string) $rule);
            }
            $this->addGroupRule($rules);
        }
    }
    
    public function getRules($section)
    {
        $this->XMLread($section);
    }
}

?>
