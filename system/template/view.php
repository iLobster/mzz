<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

fileLoader::load('template/aTemplate');

class view
{

    /**
     * @var view
     */
    protected static $instance = false;

    protected $vars    = array();
    protected $backends = array();

    /**
     * @return view
     */
    public static function getInstance()
    {
        if (self::$instance == false) {
            self::$instance = new view();
        }

        return self::$instance;
    }

    public function __construct() {}

    /**
     * Assign template variable
     *
     * @param string|array $variable variable name or array of variables
     * @param string $value to assign
     */
    public function assign($variable, $value = null)
    {
        if (is_array($variable)) {
            foreach ($variable as $key => $val) {
                $this->vars[$key] = $val;
            }
        } else {
            $this->vars[$variable] = $value;
        }
    }

    /**
     * Render template
     *
     * @param string $template resource
     * @param string $driver name of template engine
     * @return string contents of rendered template
     */
    public function render($template, $backend = 'smarty')
    {
        $backend = $this->getBackend($backend);
        return $backend->render($template);
    }

    /**
     * Returns template backend
     *
     * @param string $name
     * @return iTemplate
     */
    public function getBackend($name)
    {
        $name = strtolower($name) . 'Template';

        if (!isset($this->backends[$name])){
            if (!class_exists($name)) {
                fileLoader::load('template/drivers/' . $name);
            }

            if (!class_exists($name)) {
                throw new mzzException('Backend "' . $name . "' not exists");
            }
            $this->backends[$name] = new $name($this);
        }

        return $this->backends[$name];
    }

    public function getVariable($variable)
    {
        return (isset($this->vars[$variable])) ? $this->vars[$variable] : null;
    }

    public function export()
    {
        return $this->vars;
    }
}
?>
