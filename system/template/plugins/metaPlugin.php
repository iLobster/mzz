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
 * Unified meta plugin
 *
 * @package system
 * @subpackage template
 * @version 0.1.0
 */
class metaPlugin extends aPlugin
{
    protected $metas = array('keywords' => array(), 'description' => array());

    /**
     * Constructor
     *
     * @param view $view
     */
    public function  __construct(view $view)
    {
        parent::__construct($view);
        $this->view->assign_by_ref('__metas', $this->metas);
    }

    /**
     * PLugins magic
     *
     * @param array $params input params
     * @return null|void null if file is duplicate
     */
    public function run(array $params)
    {
        if (isset($params['keywords']) || isset($params['description'])) {
            $type = isset($params['keywords']) ? 'keywords' : 'description';
            if (!empty($params['reset'])) {
                $this->metas[$type] = array();
            }
            $this->metas[$type][] = $params[$type];
        } elseif (isset($params['show']) && in_array($params['show'], array_keys($this->metas))) {
            $separator = $params['show'] == 'keywords' ? ', ' : ' ';
            $result = implode($separator, $this->metas[$params['show']]);
            if (empty($result)) {
                 $result = (isset($params['default'])) ? $params['default'] : '';
            }

            if (isset($params['prepend'])) {
                $result = $params['prepend'] . ((!empty($result)) ? $separator . $result : '');
            }

            if (isset($params['append'])) {
                $result = ((!empty($result)) ? $result . $separator : '') . $params['append'];
            }

            return htmlspecialchars($result);
        }
    }
}
?>