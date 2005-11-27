<?php

class Registry {
    protected $registry_stack;
    static $registry = false;

    private function __construct() {
        $this->registry_stack = array(array());
    }

    public function setEntry($key, $item) {
            $this->registry_stack[0][$key] = $item;
    }

    public function getEntry($key) {
        if(isset($this->registry_stack[0][$key])) {
            if(!is_object($this->registry_stack[0][$key])) {
                $this->registry_stack[0][$key] = new $this->registry_stack[0][$key];
            }
            return $this->registry_stack[0][$key];
        } else {
            return false;
        }
    }

    public function isEntry($key) {
        return ($this->getEntry($key) !== false);
    }

    public function instance() {
        if (self::$registry === false) {
            self::$registry = new Registry();
        }
        return self::$registry;
    }

    public function save() {
        array_unshift($this->registry_stack, array());
        if (!count($this->registry_stack)) {
            // Exception: registry lost
            return false;
        }
    }

    public function restore() {
        array_shift($this->registry_stack);
    }
}
?>