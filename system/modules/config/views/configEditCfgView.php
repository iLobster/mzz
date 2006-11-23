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
 * @version $Id$
*/

/**
 * configEditCfgView: вид для метода editCfg модуля config
 *
 * @package modules
 * @subpackage config
 * @version 0.1
 */


class configEditCfgView extends simpleView
{
    private $section;
    public function __construct($module, $section)
    {
        $this->section = $section;
        parent::__construct($module);
    }

    public function toString()
    {
        $config = $this->toolkit->getConfig($this->section, $this->DAO);
        $this->smarty->assign('configs', $config->getValues());
        $this->smarty->assign('section', $this->section);
        $this->smarty->assign('module', $this->DAO);
        return $this->smarty->fetch('config/editCfg.tpl');
    }
}

?>