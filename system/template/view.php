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

    public function __construct() {
        $this->vars['__media'] = array('js' => array(), 'css' => array());
    }

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
                if (substr($key, 0, 2) == '__') {
                    throw new mzzInvalidParameterException('invalid variable name', $key);
                }
                $this->vars[$key] = $val;
            }
        } else {
            if (substr($variable, 0, 2) == '__') {
                throw new mzzInvalidParameterException('invalid variable name', $variable);
            }
            $this->vars[$variable] = $value;
        }
    }

    public function addMedia($files, $join = true, $tpl = null)
    {
        if (empty($files)) {
                throw new mzzInvalidParameterException('Пустой атрибут file');
        }

        if (!is_array($files)) {
            $files = array($files);
        }

        foreach ($files as $file) {
            // определяем тип ресурса
            if (strpos($file, ':')) {
                // Ресурс указан
                $tmp = explode(':', $file, 2);
                $res = trim($tmp[0]);
                $filename = trim($tmp[1]);
            } else {
                // Ресурс не указан, пытаемся определить ресурс по расширению
                $res = substr(strrchr($file, '.'), 1);
                $filename = $file;
            }

            // Если шаблон не указан, то используем шаблон соответствующий расширению
            $tpl = (!empty($tpl)) ? $tpl : $res . '.tpl';

            if (!isset($this->vars['__media'][$res])) {
                throw new mzzInvalidParameterException('Неверный тип ресурса: ' . $res);
            }

            if (!preg_match('/^[a-z0-9_\.?&=\/\-]+$/i', $filename)) {
                throw new mzzInvalidParameterException('Неверное имя файла: ' . $filename);
            }

            // ищем - подключали ли мы уже данный файл
            if (isset($this->vars['__media'][$res][$filename]) && $this->vars['__media'][$res][$filename]['tpl'] == $tpl) {
                return null;
            }

            $join = (bool)$join;

            $this->vars['__media'][$res][$filename] = array('tpl' => $tpl, 'join' => $join);
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
