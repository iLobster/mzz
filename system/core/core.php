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
 * @subpackage core
 * @version $Id$
 */

/**
 * core: mzz front controller
 *
 * @package system
 * @subpackage core
 * @version 0.1.7
 */
class core
{
    /**
     * Тулкит
     *
     * @var object
     */
    protected $toolkit;

    /**
     * запуск приложения
     *
     */
    final public function run()
    {
        try {
            $resolver = $this->composeResolvers();
            fileLoader::setResolver($resolver);

            $this->loadCommonFiles();

            $this->composeToolkit();
            fileLoader::load('i18n/charset/utf8Wrapper');

            $this->handle();
        } catch (Exception $e) {
            if (!($e instanceof mzzException) && class_exists('mzzException')) {
                $name = get_class($e);
                $e = new mzzException($e->getMessage(), $e->getCode(), $e->getLine(), $e->getFile(), $e->getTrace());
                $e->setName($name);
            }
            throw $e;
        }
    }

    protected function handle()
    {
        $response = $this->toolkit->getResponse();
        $request = $this->toolkit->getRequest();

        $filter_chain = new filterChain($response, $request);

        $this->composeFilters($filter_chain);

        $this->preprocess();

        $filter_chain->process();
        $response->send();
    }

    /**
     * Метод, выполняемый до запуска фильтров.
     * Может быть использован для различной настройки приложения непосредственно перед запуском.
     *
     */
    protected function preprocess()
    {
    }

    /**
     * "Сборка" композитного резолвера
     *
     * @return object
     */
    protected function composeResolvers()
    {
        require_once systemConfig::$pathToSystem . '/resolver/init.php';
        require_once systemConfig::$pathToSystem . '/core/fileLoader.php';

        $baseresolver = new compositeResolver();
        $baseresolver->addResolver(new fileResolver(systemConfig::$pathToApplication . '/*'));
        $baseresolver->addResolver(new fileResolver(systemConfig::$pathToSystem . '/*'));

        $resolver = new compositeResolver();
        $resolver->addResolver(new classFileResolver($baseresolver));
        $resolver->addResolver(new moduleResolver($baseresolver));
        $resolver->addResolver(new commonFileResolver($baseresolver));

        $cachingResolver = new cachingResolver($resolver);

        return $cachingResolver;
    }

    /**
     * Загрузка минимально необходимого для функционирования набора файлов
     *
     */
    protected function loadCommonFiles()
    {
        fileLoader::load('exceptions/init');
        errorDispatcher::setDispatcher(new errorDispatcher());

        fileLoader::load('service/arrayDataspace');

        fileLoader::load('request/init');

        fileLoader::load('orm/init');

        fileLoader::load('simple/init');

        fileLoader::load('filters/init');

        fileLoader::load('i18n/init');

        fileLoader::load('db/init');

        fileLoader::load('toolkit/init');

        fileLoader::load('forms/init');
    }

    /**
     * "Сборка" композитного тулкита
     *
     */
    protected function composeToolkit()
    {
        $this->toolkit = systemToolkit::getInstance();
        $this->toolkit->addToolkit(new stdToolkit());
    }

    /**
     * Регистрация необходимых фильтров
     *
     * @param object $filter_chain
     * @return object
     */
    protected function composeFilters($filter_chain)
    {
        $filter_chain->registerFilter(new timingFilter());
        $filter_chain->registerFilter(new sessionFilter());
        $filter_chain->registerFilter(new routingFilter());
        $filter_chain->registerFilter(new userFilter());
        $filter_chain->registerFilter(new userPreferencesFilter());
        $filter_chain->registerFilter(new contentFilter());
        return $filter_chain;
    }
}

?>