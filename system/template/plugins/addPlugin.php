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
 * Plugin for loading css / js files
 *
 * @package system
 * @subpackage template
 * @version 0.1.0
 */
class addPlugin extends aPlugin
{
    protected $media = array('js' => array(), 'css' => array());

    /**
     * Constructor
     * 
     * @param view $view
     */
    public function  __construct(view $view)
    {
        parent::__construct($view);
        $this->view->assign_by_ref('__media', $this->media);
    }

    /**
     * PLugins magic
     *
     * @param array $params input params
     * @return null|void null if file is duplicate
     */
    public function run(array $params)
    {

        if (!isset($params['file']) || empty($params['file'])) {
            //var_dump($params);
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
                return null;
            }

            $join = (bool)$join;


            $this->media[$res][$filename] = array('tpl' => $tpl, 'join' => $join);
        }
    }
}
?>