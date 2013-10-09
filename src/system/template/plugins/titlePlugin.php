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

fileLoader::load('template/plugins/aPlugin');

/**
 * Unfied title plugin
 *
 * @package system
 * @subpackage template
 * @version 0.1.0
 */
class titlePlugin extends aPlugin
{
    protected $titles = array();

    /**
     * Constructor
     *
     * @param view $view
     */
    public function  __construct(view $view)
    {
        parent::__construct($view);
        $this->view->assign_by_ref('__titles', $this->titles);
    }

    /**
     * PLugins magic
     *
     * @param array $params input params
     * @return null|void null if file is duplicate
     */
    public function run(array $params)
    {
        if (isset($params['append'])) {
            $this->titles[] = array($params['append'], isset($params['separator']) ? $params['separator'] : false);
        } else {
            $title = '';
            $separator = '';
            foreach ($this->titles as $t) {
                if (!is_null($t[0]) && $t[0] != '') {
                    $separator = ($t[1] === false) ? (isset($params['separator']) ? $params['separator'] : '') : $t[1];
                    $title .= $t[0] . $separator;
                }
            }
            $title = substr($title, 0, -(strlen($separator))) . '';

            if (isset($params['end']) && !empty($title)) {
                $title .= $params['end'];
            }

            if (isset($params['start']) && !empty($title)) {
                $title = $params['start'] . $title;
            }

            if (isset($params['prepend'])) {
                $title = $params['prepend'] .  ((isset($params['separator']) && !empty($title)) ? $params['separator'] . $title : '');
            }
            
            if ($title === '' && isset($params['default'])) {
                $title = $params['default'];
            }

            return htmlspecialchars($title);
        }
    }
}
?>