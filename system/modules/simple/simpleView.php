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

fileLoader::load('template/view');

/**
 * simpleView:
 *
 * @package modules
 * @subpackage simple
 * @version 0.1.0
 */

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
     * is it needed ???
     * @param <type> $var
     * @param <type> $val
     */
    public function assign_by_ref($var, $val)
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
     * Export assigned vars
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

    /**
     * Returns backend engine
     * 
     * @return iTemplate
     */
    public function backend()
    {
        return $this->backend;
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