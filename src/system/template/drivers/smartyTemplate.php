<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
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

fileLoader::load('libs/smarty/Smarty.class');
fileLoader::load('template/drivers/smarty/IfSmarty');
//fileLoader::load('template/drivers/smarty/plugins/function.add');
fileLoader::load('template/drivers/smarty/plugins/modifier.filesize');
fileLoader::load('service/blockHelper');
fileLoader::load('template/drivers/smarty/plugins/prefilter.i18n');

class smartyTemplate extends Smarty implements iTemplate
{

    /**
     * @var view
     */
    protected $view = null;


    /**
     * Язык шаблона
     *
     * @var string
     */
    protected $lang = null;

    /**
     * Хранение объекта для работы с ресурсом
     *
     * @var array
     */
    protected $resources = array();

    /**
     * Обработанные шаблоны. Необходимо для предотвращении рекурсивного вложения шаблонов
     *
     * @var array
     */
    protected $fetchedTemplates = array();

    /**
     * Включена вставка в main шаблон?
     *
     * @var unknown_type
     */
    protected $withMain = true;

    public function __construct(view $view)
    {

        parent::__construct();

        $this->view = $view;

        $this->template_dir = systemConfig::$pathToApplication . '/templates';
        $this->compile_dir = systemConfig::$pathToTemp . '/templates_c';
        $oldPluginsDirs = $this->plugins_dir;
        $this->plugins_dir = array();
        $this->allow_php_tag = true;
        $this->default_template_handler_func = array($this, 'resolveFilePath');

        if (is_dir($appdir = systemConfig::$pathToApplication . '/template/plugins')) {
            $this->plugins_dir[] = $appdir;
        }

        $this->plugins_dir[] = systemConfig::$pathToSystem . '/template/drivers/smarty/plugins';
        $this->plugins_dir = array_merge($this->plugins_dir, $oldPluginsDirs);

        $this->debugging = DEBUG_MODE;
        $this->assign('SITE_PATH', rtrim(SITE_PATH, '/'));
        $this->assign('SITE_LANG', systemToolkit::getInstance()->getLocale()->getName());


        $this->register->modifier('filesize', 'smarty_modifier_filesize');

        $this->register->templateObject('form', new form());


        $this->register->templateObject('fblock', $fblock = blockHelper::getInstance());
        $this->assign('fblock', $fblock);


        $this->register->preFilter('smarty_prefilter_i18n');
    }

    public function render($template)
    {
        return $this->fetch($template);
    }

    /**
     * Выполняет шаблон и возвращает результат
     * Декорирован для реализации вложенных шаблонов.
     *
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     * @param boolean $display
     * @return string
     */
    public function fetch($resource_name, $cache_id = null, $compile_id = null, $parent = null)
    {
        $resource = explode(':', $resource_name, 2);

        if (count($resource) === 1) {
            $resource = array($this->default_resource_type, $resource_name);
        }

        $className = 'f' . ucfirst($resource[0]) . 'Smarty';

        if (!class_exists($className)) {
            fileLoader::load('template/drivers/smarty/' . $className);
        }

        if (!class_exists($className)) {
            $error = sprintf("Can't find class '%s' for template engine", $mzzname);
            throw new mzzRuntimeException($error);
            return false;
        }

        if (!isset($this->resources[$className])) {
            $this->resources[$className] = new $className($this);
        }
        $result = $this->resources[$className]->fetch($resource, $cache_id, $compile_id, $parent);

        return $result;

    }

    /**
     * Выполняет пассивный шаблон и возвращает результат
     *
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     * @param object $parent
     * @return string
     */
    public function fetchPassive($resource_name, $cache_id = null, $compile_id = null, $parent = null)
    {
        $result = parent::fetch($resource_name, $cache_id, $compile_id, $parent);
        return $result;
    }

    /**
     * Выполняет активный шаблон, заменяет placeholder и возвращает результат
     *
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     * @param object $parent
     * @param string $result начальный результат обработки активного шаблона как пассивного
     * @return string
     */
    public function fetchActive($template, $cache_id = null, $compile_id = null, $parent = null, $result = null)
    {
        $params = $this->parse($template);

        /*
        if (isset($this->fetchedTemplates[$params['main']])) {
            $error = "Detected recursion. Recursion template: %s. <br> All: <pre>%s</pre>";
            throw new mzzRuntimeException(sprintf($error, $params['main'], print_r($this->fetchedTemplates, true)));
        }
        */

        if (!isset($params['placeholder'])) {
            $error = "Template error. Placeholder is not specified.";
            throw new mzzRuntimeException($error);
        }
        $this->fetchedTemplates[$params['main']] = true;

        if (!$this->view->withMain()) {
            return $result;
        }

        $this->assign($params['placeholder'], $result);
        $result = $this->fetch($params['main'], $cache_id, $compile_id, $parent);
        return $result;
    }

    /**
     * Разбор первой строки вложенных (активных) шаблонов
     *
     * @param string $str
     * @return array
     */
    public function parse($str)
    {
        if ($this->view->withMain() && $this->view->getActTemplate() !== false) {
            // для предотвращения рекурсии
            $actTemplate = $this->view->getActTemplate();
            $this->view->passActTemplate();
            return $actTemplate;
        }
        $params = array();
        if (preg_match('/\{\*\s*(.*?)\s*\*\}/', $str, $matches)) {
            $clean_str = preg_split('/\s+/', $matches[1]);
            foreach ($clean_str as $str) {
                $param = explode('=', $str, 2);
                $params[$param[0]] = trim($param[1], '\'"');
            }
        }

        return $params;
    }

    /**
     * Возвращает true если шаблон активный (вложен в другой)
     *
     * @param string $template
     * @return boolean
     */
    public function isActive($template)
    {
        $isActive = (strpos($template, "{* main=") === false);
        return ($this->view->getActTemplate() !== true && !$isActive)
        || (is_array($this->view->getActTemplate()));
    }

    public function getCurrentFile()
    {
        return end($this->template_objects)->template_resource;
    }

    public function resolveFilePath($resource_type, $resource_name, &$template_source, &$template_timestamp, $template)
    {
        $filePath = fileLoader::resolve($resource_name);
        if ($filePath === false) {
            throw new mzzIoException($resource_name);
        }

        return $filePath;
    }

    public function getVariable($name)
    {
        return $this->view->getVariable($name);
    }

    public function assign($var, $val = null)
    {
        return $this->view->assign($var, $val);
    }

    public function addMedia($files, $join = true, $tpl = null)
    {
        $this->view->addMedia($files, $join, $tpl);
    }

    public function view()
    {
        return $this->view;
    }
}

?>