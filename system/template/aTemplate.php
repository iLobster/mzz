<?php
/**
 * $URL: $
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
 * @version $Id: $
*/

fileLoader::load('template/iTemplate');

/**
 * Abstract template class
 *
 * @package system
 * @subpackage template
 * @version 0.1.0
 */
abstract class aTemplate implements iTemplate
{
    /**
     * @var view
     */
    protected $view = null;
    
    /**
     * Включена вставка в main шаблон?
     *
     * @var boolean
     */
    protected $withMain = true;

    public function __construct(view $view) {
        $this->view = $view;
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

    public function setActiveTemplate($template_name, $placeholder = 'content'){}

    /**
     * AddMedia function to load css/js files
     *
     * @param string|array $files of files to load
     * @param bool $join use external to join files or not
     * @param string $template to use when loading file
     */
    public function addMedia($files, $join = true, $tpl = null)
    {
        $this->view->addMedia($files, $join, $tpl);
    }
}
?>
