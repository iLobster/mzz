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
fileLoader::load('template/IfSmarty');
fileLoader::load('template/plugins/function.add');

/**
 * fSmarty: модификация Smarty для работы с активными и пассивными шаблонами
 *
 * @package system
 * @subpackage template
 * @version 0.5.3
 */
class fSmarty extends Smarty
{
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
     * Массив из имени активного шаблона и имени placeholder-а в нем
     *
     * @var array
     */
    protected $actTemplate = false;

    /**
     * Используемый скин
     *
     * @var string
     */
    protected $skin;

    /**
     * Включена вставка в main шаблон?
     *
     * @var unknown_type
     */
    protected $withMain = true;

    /**
     * Конструктор
     *
     */
    public function __construct()
    {
        parent::Smarty();
        // инициализация массива media, используемого в функции {add}
        smarty_function_add(array('init' => true), $this);
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
    public function fetch($resource_name, $cache_id = null, $compile_id = null, $display = false)
    {
        $resource = explode(':', $resource_name, 2);

        if (count($resource) === 1) {
            $resource = array($this->default_resource_type, $resource_name);
        }

        $className = 'f' . ucfirst($resource[0]) . 'Smarty';

        if (!class_exists($className)) {
            fileLoader::load('template/' . $className);
        }

        if (!class_exists($className)) {
            $error = sprintf("Can't find class '%s' for template engine", $mzzname);
            throw new mzzRuntimeException($error);
            return false;
        }

        if (!isset($this->resources[$className])) {
            $this->resources[$className] = new $className($this);
        }
        $result = $this->resources[$className]->fetch($resource, $cache_id, $compile_id, $display);

        return $result;

    }

    /**
     * Выполняет пассивный шаблон и возвращает результат
     *
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     * @param boolean $display
     * @return string
     */
    public function fetchPassive($resource_name, $cache_id = null, $compile_id = null, $display = false)
    {
        $result = parent::fetch($resource_name, $cache_id, $compile_id, $display);
        return $result;
    }

    /**
     * Выполняет активный шаблон, заменяет placeholder и возвращает результат
     *
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     * @param boolean $display
     * @param string $result начальный результат обработки активного шаблона как пассивного
     * @return string
     */
    public function fetchActive($template, $cache_id = null, $compile_id = null, $display = false, $result = null)
    {
        $params = $this->parse($template);

        if (isset($this->fetchedTemplates[$params['main']])) {
            $error = "Detected recursion. Recursion template: %s. <br> All: <pre>%s</pre>";
            throw new mzzRuntimeException(sprintf($error, $params['main'], print_r($this->fetchedTemplates, true)));
        }

        if (!isset($params['placeholder'])) {
            $error = "Template error. Placeholder is not specified.";
            throw new mzzRuntimeException($error);
        }
        $this->fetchedTemplates[$params['main']] = true;

        if (!$this->withMain) {
            return $result;
        }

        $this->assign($params['placeholder'], $result);
        $result = $this->fetch($params['main'], $cache_id, $compile_id, $display);
        return $result;
    }

    /**
     * Выполняет шаблон и отображает результат.
     *
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     */
    public function display($resource_name, $cache_id = null, $compile_id = null)
    {
        $this->fetch($resource_name, $cache_id, $compile_id, true);
    }

    /**
     * Разбор первой строки вложенных (активных) шаблонов
     *
     * @param string $str
     * @return array
     */
    public function parse($str)
    {
        if ($this->withMain && $this->actTemplate !== false) {
            $actTemplate = $this->actTemplate;
            // для предотвращения рекурсии
            $this->actTemplate = true;
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
        return ($this->actTemplate !== true && !$isActive)
        || (is_array($this->actTemplate));
    }

    /**
     * Устанавливает активный шаблон и имя placeholder-а
     *
     * @param string $template_name имя активного шаблона
     * @param string $placeholder имя placeholder-а. По умолчанию <i>content</i>
     */
    public function setActiveTemplate($template_name, $placeholder = 'content')
    {
        if (!$this->actTemplate) {
            $this->actTemplate = array('main' => $template_name, 'placeholder' => $placeholder);
            $this->enableMain();
        }
    }

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

    function _parse_resource_name(&$params)
    {
        if (empty($this->skin)) {
            $this->skin = systemToolkit::getInstance()->getUserPreferences()->getSkin();
        }

        $params_skinned = $params;
        $params_skinned['resource_name'] = $this->skin . '/' . $params_skinned['resource_name'];

        if (parent::_parse_resource_name($params_skinned)) {
            $params = $params_skinned;
            return true;
        }

        if (parent::_parse_resource_name($params)) {
            return true;
        }

        $name = fileLoader::resolve($params['resource_name']);
        $params['resource_name'] = $name;
        $params['resource_type'] = 'file';
        return true;
    }

    function _get_auto_filename($auto_base, $auto_source = null, $auto_id = null)
    {
        if (empty($this->lang) && systemConfig::$i18n) {
            $this->lang = systemToolkit::getInstance()->getLocale()->getName();
        }
        return parent::_get_auto_filename($auto_base, $auto_source, $auto_id) . ($this->lang ? '-' . $this->lang : '') . '-' . $this->skin;
    }
}

?>