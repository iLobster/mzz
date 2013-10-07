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

/**
 * smarty_function_add: функция для смарти, загрузчик элементов сайта (например JS, CSS)
 *
 * Примеры использования:<br />
 * <code>
 * {add file="styles.css"}
 * {add file="css:style_generator.php?print=1" tpl="css_print.tpl"}
 * </code>
 *
 * @param array $params входные аргументы функции
 * @param object $smarty объект смарти
 * @return null|void null если файл дубликат
 * @package system
 * @subpackage template
 */
function smarty_function_add(array $params, Smarty_Internal_Template $template)
{

    static $addPlugin = null;
    if (is_null($addPlugin)) {
        $addPlugin = new mzzAddPlugin($template->smarty);
    };

    return $addPlugin->run($params);
}

class mzzAddPlugin
{
    protected $media = array('js' => array(), 'css' => array());

    protected $resolver = null;
    protected $dependences = null;
    protected $changed = false;
    protected $cacheBackend = null;
    protected $cacheName = 'add_dependencies';
    protected $smarty = null;

    public function __construct($smarty)
    {
        $this->cacheBackend = cache::factory('long');
        $this->cacheBackend->get($this->cacheName, $this->dependences);
        $this->smarty = $smarty;
        $this->smarty->assignByRef('__media', $this->media);
    }

    public function run(array $params)
    {

        if (!isset($params['file']) || empty($params['file'])) {
            throw new mzzInvalidParameterException('Empty file param');
        }

        $files = $params['file'];
        $join = (isset($params['join']) && $params['join'] == false) ? false : true;
        $tpl = (isset($params['tpl']) && !empty($params['tpl'])) ? $params['tpl'] : null;

        if (!is_array($files)) {
            $files = array($files);
        }

        if (isset($params['require'])) {
            $files = array_merge(explode(',', $params['require']), $files);
        }

        foreach ($files as $file) {
            // определяем тип ресурса
            $tmp = $res = $tpl = null;
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

            if (!isset($this->media[$res])) {
                throw new mzzInvalidParameterException('Неверный тип ресурса: ' . $res);
            }

            if (!preg_match('/^[a-z0-9_\.?&=\/\-]+$/i', $filename)) {
                throw new mzzInvalidParameterException('Неверное имя файла: ' . $filename);
            }

            // ищем - подключали ли мы уже данный файл
            if (isset($this->media[$res][$filename]) && $this->media[$res][$filename]['tpl'] == $tpl) {
                continue;
            }

            $join = (bool) $join;

            if ($res == 'js') {
                $this->addDependences($filename, $join);
            }

            $this->media[$res][$filename] = array('tpl' => $tpl, 'join' => $join);
        }
    }

    private function addDependences($filename, $join)
    {
        if (!isset($this->dependences[$filename])) {
            $this->changed = true;
            fileLoader::setResolver($this->getResolver());

            $filePath = fileLoader::resolve($filename);
            if ($filePath === false) {
                $filePath = fileLoader::resolve('simple/' . $filename);
            }

            if ($filePath !== false) {
                $str = file_get_contents($filePath, null, null, 0, 256);
                preg_match_all('/[^#]REQUIRE\:([a-z0-9_\.?&=\/\-\;]+)/i', $str, $matches);
                $this->dependences[$filename] = implode(';', $matches[1]);
            } else {
                $this->dependences[$filename] = '';
            }

            fileLoader::restoreResolver();
        }

        $params = array('join' => $join);

        $files = explode(';', $this->dependences[$filename]);
        foreach ($files as $file) {
            if ($file) {
                $params['file'] = $file;
                $this->run($params);
            }
        }
    }

    protected function getResolver()
    {
        if (!$this->resolver) {
            fileLoader::load('resolver/templateMediaResolver');
            fileLoader::load('resolver/moduleMediaResolver');
            fileLoader::load('resolver/extensionBasedModuleMediaResolver');
            $baseresolver = new compositeResolver();
            $baseresolver->addResolver(new fileResolver(systemConfig::$pathToApplication . '/*'));
            $baseresolver->addResolver(new fileResolver(systemConfig::$pathToSystem . '/*'));

            $resolver = new compositeResolver();
            $resolver->addResolver(new templateMediaResolver($baseresolver));
            $resolver->addResolver(new moduleMediaResolver($baseresolver));
            $resolver->addResolver(new extensionBasedModuleMediaResolver($baseresolver));
            $resolver->addResolver(new classFileResolver($baseresolver));

            $this->resolver = new cachingResolver($resolver, 'resolver.media.cache');
        }

        return $this->resolver;
    }

    public function __destruct()
    {
        if ($this->changed) {
            $this->cacheBackend->set($this->cacheName, $this->dependences);
        }
    }
}