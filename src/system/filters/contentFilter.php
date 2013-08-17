<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('core/loadDispatcher');
fileLoader::load('filters/aContentFilter');


/**
 * contentFilter: фильтр получения и отображения контента
 *
 * @package system
 * @subpackage filters
 * @version 0.2.10
 */
class contentFilter extends abstractContentFilter implements iFilter
{
    /**
     * запуск фильтра на исполнение
     *
     * @param filterChain $filter_chain объект, содержащий цепочку фильтров
     * @param httpResponse $response объект, содержащий информацию, выводимую клиенту в браузер
     * @param iRequest $request
     */
    public function run(filterChain $filter_chain, $response, iRequest $request)
    {
        $toolkit = systemToolkit::getInstance();
        $view = $toolkit->getView();
        
        // Assign predefined variables
        $view->assign('SITE_PATH', rtrim(SITE_PATH, '/'));
        $view->assign('SITE_LANG', $toolkit->getLocale()->getName());
        $view->assign('SITE_REVISION', $this->getCacheControlHash()); // can be used to prevent caching
        
        // You can return cached content here, if necessary, instead rendering it again
        $output = $this->renderPage($response, $request);

        $response->append($output);
        $filter_chain->next();
    }

    /**
     * do changes in output after render page
     *
     * @param string $output
     */
    protected function afterRenderPage(&$output)
    {

    }
    
    /**
     * Returns short hash of current source code revision which can be sued to prevent caching
     * @return string|null
     */
    protected function getCacheControlHash()
    {
        // Let's find project revision
        $hash = null;
        switch (systemConfig::$versionControlSystemUsed) {
            case 'git':
                $version_file = systemConfig::$pathToApplication . '/.git/index';
                break;
        
            case 'hg':
                $version_file = systemConfig::$pathToApplication . '/.hg/undo.branch';
                break;
        
            case 'svn':
                $version_file = systemConfig::$pathToApplication . '/.svn/entries';
                break;
        }
        
        if (!empty($version_file) && file_exists($version_file)) {
            $hash = substr(md5(filemtime($version_file)), 0, 8);
        }
        
        return $hash;
    }

}

?>