<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2010
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage template
 * @version $Id$
 */

fileLoader::load('template/aTemplate');

/**
 * View class
 *
 * @package system
 * @subpackage template
 * @version 0.1.0
 */
class view
{

    /**
     * @var view
     */
    protected static $instance = false;

    protected $vars    = array();
    protected $backends = array();
    protected $plugins = array();

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

    public function __construct()
    {
        //$this->vars['__media'] = array('js' => array(), 'css' => array());
    }

    /**
     * Assign template variable or array of variables
     *
     * @param string|array $variable variable name or array of variables
     * @param mixed $value to assign
     */
    public function assign($variable, $value = null)
    {

        if (is_array($variable)) {
            foreach ($variable as $key => $val) {
                if (!empty($key)) {
                    $this->vars[$key] = $val;
                }
            }
        } else {
            if (!empty($variable)) {
                $this->vars[$variable] = $value;
            }
        }
    }

    /**
     * Assign template variable by reference
     *
     * @param string $variable variable name
     * @param mixed $value to assign
     */
    public function assign_by_ref($variable, &$value)
    {
        if (!empty($variable)) {
            $this->vars[$variable] = &$value;
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

        if (!isset($this->backends[$name])) {
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

    /**
     * Runs plugin
     *
     * @param string $name plugin name
     * @param array $params to pass
     * @return mixed whatever plugin returns
     */
    public function plugin($name, array $params = array())
    {
        $name = strtolower($name);
        if (!isset($this->plugins[$name])) {
            $class = $name . 'Plugin';
            fileLoader::load('template/plugins/' . $class);
            if (class_exists($class)) {
                $this->plugins[$name] = new $class($this);
            } else {
                throw new mzzRuntimeException("plugin " . $name . " not found");
            }
        }

        return $this->plugins[$name]->run($params);
    }

    public function getVariable($variable)
    {
        if ($bracket = strpos($variable, '[')) {
            $indexName = substr($variable, $bracket);
            $name = substr($variable, 0, $bracket);
            if (array_key_exists($name, $this->vars)) {
                $result = $this->vars[$name];
            } else {
                return null;
            }

            return arrayDataspace::extractFromArray($indexName, $result);
        }

        return (array_key_exists($variable, $this->vars)) ? $this->vars[$variable] : null;
    }

    public function &export()
    {
        return $this->vars;
    }

    /**
     * @todo: think about this shit
     */

    /**
     * Включена вставка в main шаблон?
     *
     * @var boolean
     */
    protected $withMain = true;
    protected $actTemplate = false;
    /**
     * Отключает вставку шаблона в main шаблон
     *
     */
    public function disableMain()
    {
        $this->withMain = false;
    }

    /**
     * Включает вставку шаблона в main шаблон
     *
     */
    public function enableMain()
    {
        $this->withMain = true;
    }

    public function setActiveTemplate($template_name, $placeholder = 'content')
    {
        if (!$this->actTemplate) {
            $this->actTemplate = array('main' => $template_name, 'placeholder' => $placeholder);
            $this->enableMain();
        }
    }

    public function getActTemplate()
    {
        return $this->actTemplate;
    }

    public function withMain()
    {
        return $this->withMain;
    }

    public function passActTemplate()
    {
        return $this->actTemplate = true;
    }
}
?>
