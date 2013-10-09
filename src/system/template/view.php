<?php
/**
 * MZZ Content Management System (c)
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 */

fileLoader::load('libs/smarty/Smarty.class');
fileLoader::load('template/mzzSmartyCompiler');
fileLoader::load('template/smarty_internal_compile_private_object_function');
fileLoader::load('template/mzzSmartyResourceHandlers');
fileLoader::load('template/plugins/prefilter.i18n');
fileLoader::load('service/blockHelper');

class view extends Smarty
{

    protected $isActive = array();
    protected $fetchedTemplates = array();

    public function __construct()
    {
        parent::__construct();

        $this->registerDefaultTemplateHandler(array($this, 'resolveFilePath'));
        $this->registerResource('file', new mzzSmartyResourceFile());
        $this->registerResource('string', new mzzSmartyResourceString());
        $this->registerResource('stream', new mzzSmartyResourceStream());

        $this->template_dir = systemConfig::$pathToApplication . '/templates';
        $this->compile_dir = systemConfig::$pathToTemp . '/templates_c';

        $oldPluginsDirs = $this->getPluginsDir();
        $newPluginsDir = array();
        if (is_dir($appDir = systemConfig::$pathToApplication . '/template/plugins')) {
            $newPluginsDir[] = $appDir;
        }

        $newPluginsDir[] = systemConfig::$pathToSystem . '/template/plugins';
        $this->addPluginsDir(array_merge($newPluginsDir, $oldPluginsDirs));

        //for suppressing E_NOTICE error on unassigned variable
        $this->error_reporting = E_ALL & !E_NOTICE;

        $this->debugging = DEBUG_MODE;
        $this->assign('SITE_PATH', rtrim(SITE_PATH, '/'));


        //$this->registerPlugin('modifier', 'filesize', 'smarty_modifier_filesize');

        $this->registerObject('form', new form());


        $this->registerObject('fblock', $fblock = blockHelper::getInstance());

        $this->assign('fblock', $fblock);

        $this->registerFilter('pre','smarty_prefilter_i18n');
    }


    public function assign_by_ref($variable, &$value)
    {
        return $this->assignByRef($variable, $value);
    }

    public function resolveFilePath($type, $name, &$content = null, &$modified = null, Smarty $smarty = null) {
        if ($type == 'file') {
            $filePath = fileLoader::resolve($name);
            if ($filePath === false) {
                throw new mzzIoException($name);
            }

            return $filePath;
        }
    }

    public function render($template)
    {
        $result = $this->fetch($template);

        if ($this->isActive($template)) {
            $result = $this->fetchActive($template, $result);
        }

        return $result;
    }

    public function fetchActive($template, $result) {
        if (!$this->withMain()) {
            return $result;
        }

        $params = $this->params($this->isActive[$template]);

        if (isset($this->fetchedTemplates[$params['main']])) {
            $error = "Detected recursion. Recursion template: %s. <br> All: <pre>%s</pre>";
            throw new mzzRuntimeException(sprintf($error, $params['main'], print_r($this->fetchedTemplates, true)));
        }

        if (!isset($params['placeholder'])) {
            $params['placeholder'] = 'content';
        }

        $this->fetchedTemplates[$params['main']] = true;

        $this->assign($params['placeholder'], $result);
        return $this->fetch($params['main']);
    }

    public function params($templateSource) {
        if ($this->withMain() && $this->getActTemplate() !== false) {
            // для предотвращения рекурсии
            $actTemplate = $this->getActTemplate();
            $this->passActTemplate();
            return $actTemplate;
        }

        $params = array();
        if (preg_match('/\{\*\s*(.*?)\s*\*\}/', $templateSource, $matches)) {
            $clean_str = preg_split('/\s+/', $matches[1]);
            foreach ($clean_str as $str) {
                $param = explode('=', $str, 2);
                $params[$param[0]] = trim($param[1], '\'"');
            }
        }

        return $params;
    }

    public function isActive($template) {
        if (!isset($this->isActive[$template])) {
            $filePath = $this->resolveFilePath('file', $template);

            try {
                $h = fopen($filePath, 'r');
            } catch (Exception $e) {
                throw new mzzIoException($filePath);
            }

            $buffer = fgets($h, 4096);
            fclose($h);

            $this->isActive[$template] = (strpos($buffer, "{* main=") === false) ? false : $buffer;
        }

        return ($this->getActTemplate() !== true && $this->isActive[$template]) || (is_array($this->getActTemplate()));
    }


    /**
     * Включена вставка в main шаблон?
     *
     * @var boolean
     */
    protected static $withMain = true;
    protected static $actTemplate = false;

    /**
     * Отключает вставку шаблона в main шаблон
     *
     */
    public function disableMain()
    {
        self::$withMain = false;
    }

    /**
     * Включает вставку шаблона в main шаблон
     *
     */
    public function enableMain()
    {
        self::$withMain = true;
    }

    public function setActiveTemplate($template_name, $placeholder = 'content')
    {
        if (!self::$actTemplate) {
            self::$actTemplate = array('main' => $template_name, 'placeholder' => $placeholder);
            $this->enableMain();
        }
    }

    public function getActTemplate()
    {
        return self::$actTemplate;
    }

    public function withMain()
    {
        return self::$withMain;
    }

    public function passActTemplate()
    {
        return self::$actTemplate = true;
    }
}