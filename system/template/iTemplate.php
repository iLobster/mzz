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

/**
 * Templates interface
 *
 * @package system
 * @subpackage template
 * @version 0.1.0
 */
interface iTemplate
{
    
    /**
     * Constructor
     *
     * @param view $view
     */
    public function __construct(view $view);

    /**
     * Render template
     *
     * @param string $resource template file name
     * @return mixed
     */
    public function render($resource);
    
    public function setActiveTemplate($template_name, $placeholder = 'content');
    public function disableMain();
    public function enableMain();

    /**
     * AddMedia function to load css/js files
     *
     * @param string|array $files of files to load
     * @param bool $join use external to join files or not
     * @param string $template to use when loading file
     */
    public function addMedia($files, $join = true, $tpl = null);
}
?>
