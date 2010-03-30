<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

fileLoader::load('template/view');

class simpleView
{
    /**
     * Backend name
     *
     * @var string
     */
    protected $backendName = null;

    /**
     * Backend object
     *
     * @var iTemplate
     */
    protected $backend = null;

    /**
     * View object
     *
     * @var view
     */
    protected $view = null;

    protected static $instances = array();

    /**
     * Factory
     *
     * @param string $backend template engine name
     * @return simpleView
     */
    public static function factory($backend)
    {
        $backend = strtolower($backend);
        if (!isset(self::$instances[$backend])) {
            self::$instances[$backend] = new simpleView($backend);
        }

        return self::$instances[$backend];
    }

    /**
     * Constructor
     *
     * @param string $backend template engine name
     */
    public function __construct($backend)
    {
        $this->view = view::getInstance();
        $this->backendName = $backend;
        $this->backend = $this->view->getBackend($backend);
    }

    /**
     * Assign template variable
     *
     * @param string|array $variable variable name or array of variables
     * @param string $value to assign
     */
    public function assign($var, $val = null)
    {
        $this->view->assign($var, $val);
    }

    /**
     * Render template
     *
     * @param string $template resource
     * @return string contents of rendered template
     */
    public function render($template)
    {
        return $this->backend->render($template);
    }

    /**
     * Alias for simpleView::render()
     *
     * @param string $template resource
     * @return string contents of rendered template
     */
    public function fetch($template)
    {
        return $this->backend->render($template);
    }

    /**
     * Export assigned vars, for compatible with smarty
     *
     * @return mixed
     */
    public function export()
    {
        return $this->view->export();
    }
    /**
     * Alias for simpleView::export(), for compatible with smarty
     *
     * @param string|null $variable name to return
     * @return mixed
     */
    public function get_template_vars($variable = null)
    {
        if ($variable) {
            return $this->view->getVariable($variable);
        }

        return $this->view->export();
    }

    public function setActiveTemplate($template_name, $placeholder = 'content')
    {
        $this->backend->setActiveTemplate($template_name, $placeholder);
    }

    public function disableMain()
    {
        $this->backend->disableMain();
    }

    /**
     * Включает вставку шаблона в main шаблон
     *
     */
    public function enableMain()
    {
        $this->backend->enableMain();
    }

}
?>
