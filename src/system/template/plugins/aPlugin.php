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

fileLoader::load('template/plugins/iPlugin');

/**
 * Abstract plugin
 *
 * @package system
 * @subpackage template
 * @version 0.1.0
 */
abstract class aPlugin implements iPlugin
{
    protected $view;

    /**
     * Constructor
     * 
     * @param view $view
     */
    public function __construct(view $view)
    {
        $this->view = $view;
    }
}
?>