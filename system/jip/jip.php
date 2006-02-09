<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

class jip
{
    private $section;
    private $module;
    private $id;
    private $type;
    private $actions;

    public function __construct($section, $module, $id, $type, $actions)
    {
        $this->section = $section;
        $this->module = $module;
        $this->id = $id;
        $this->type = $type;
        $this->actions = $actions;
    }

    private function buildUrl($action)
    {
        return $this->section . '/' . $this->id . '/' . $action;
    }

    private function generate()
    {
        $result = array();
        foreach ($this->actions as $item) {
            $result[] = array('url' => $this->buildUrl($item['controller']), 'title' => $item['title']);
        }
        return $result;
    }

    public function draw()
    {
        $toolkit = systemToolkit::getInstance();
        $smarty = $toolkit->getSmarty();

        $smarty->assign('jip', $this->generate());

        return $smarty->fetch('jip.tpl');
    }
}
?>