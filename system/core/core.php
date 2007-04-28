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
 * core: ���� mzz
 *
 * @package system
 * @subpackage core
 * @version 0.1.5
 */
class core
{
    /**
     * ������
     *
     * @var object
     */
    protected $toolkit;

    /**
     * ������ ����������
     *
     */
    final public function run()
    {
        try {
            $resolver = $this->composeResolvers();
            fileLoader::setResolver($resolver);

            $this->loadCommonFiles();

            $this->composeToolkit();

            $response = $this->toolkit->getResponse();
            $request = $this->toolkit->getRequest();

            $filter_chain = new filterChain($response, $request);

            $this->composeFilters($filter_chain);

            $this->preprocess();

            $filter_chain->process();
            $response->send();
        } catch (Exception $e) {
            if (!($e instanceof mzzException) && class_exists('mzzException'))  {
                $name = get_class($e);
                $e = new mzzException($e->getMessage(), $e->getCode(), $e->getLine(), $e->getFile(), $e->getTrace());
                $e->setName($name);
                throw $e;
            } else {
                throw $e;
            }
        }
    }

    /**
     * �����, ����������� �� ������� ��������.
     * ����� ���� ����������� ��� ��������� ��������� ���������� ��������������� ����� ��������.
     *
     */
     protected function preprocess()
     {
         
     }

    /**
     * "������" ������������ ���������
     *
     * @return object
     */
    protected function composeResolvers()
    {
        require_once systemConfig::$pathToSystem . '/resolver/init.php';
        require_once systemConfig::$pathToSystem . '/core/fileLoader.php';

        $baseresolver = new compositeResolver();
        $baseresolver->addResolver(new appFileResolver());
        $baseresolver->addResolver(new sysFileResolver());

        $resolver = new compositeResolver();
        $resolver->addResolver(new classFileResolver($baseresolver));
        $resolver->addResolver(new moduleResolver($baseresolver));
        $resolver->addResolver(new configFileResolver($baseresolver));
        $resolver->addResolver(new libResolver($baseresolver));
        $cachingResolver = new cachingResolver($resolver);

        return $cachingResolver;
    }

    /**
     * �������� ���������� ������������ ��� ���������������� ������ ������
     *
     */
    protected function loadCommonFiles()
    {
        fileLoader::load('exceptions/init');
        errorDispatcher::setDispatcher(new errorDispatcher());

        fileLoader::load('request/url');
        fileLoader::load('dataspace/arrayDataspace');

        fileLoader::load('simple');
        fileLoader::load('simple/simpleMapper');
        fileLoader::load('simple/simpleCatalogueMapper');
        fileLoader::load('simple/simpleController');
        fileLoader::load('simple/simpleFactory');
        fileLoader::load('simple/jipTools');
        fileLoader::load('simple/simpleCatalogue');
        fileLoader::load('simple/simpleCatalogueMapper');
        fileLoader::load('simple/messageController');

        fileLoader::load('filters/init');

        fileLoader::load('config');
        fileLoader::load('controller/frontController');

        fileLoader::load('db/DB');

        fileLoader::load('iterators/mzzIniFilterIterator');

        fileLoader::load('toolkit');
        fileLoader::load('toolkit/stdToolkit');
        fileLoader::load('toolkit/systemToolkit');

        fileLoader::load('controller/action');
    }

    /**
     * "������" ������������ �������
     *
     */
    protected function composeToolkit()
    {
        $this->toolkit = systemToolkit::getInstance();
        $this->toolkit->addToolkit(new stdToolkit());
    }

    /**
     * ����������� ����������� ��������
     *
     * @param object $filter_chain
     * @return object
     */
    protected function composeFilters($filter_chain)
    {
        $filter_chain->registerFilter(new timingFilter());
        $filter_chain->registerFilter(new sessionFilter());
        $filter_chain->registerFilter(new userFilter());
        $filter_chain->registerFilter(new contentFilter());
        return $filter_chain;
    }
}

?>