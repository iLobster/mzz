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
/**
 * pageViewController: контроллер для метода view модуля page
 *
 * @package page
 * @version 0.2
 */

class relateViewController extends simpleController
{
    public function __construct()
    {
        fileLoader::load('relate/views/relate.view.view');
        fileLoader::load("relate");
        fileLoader::load("relate/mappers/relateMapper");
        parent::__construct();
    }

    public function getView()
    {
        $section = $this->request->getSection();

        $relateMapper = new relateMapper($section);

        $relate = $relateMapper->searchById(1);
        //var_dump($relate);
        //$arr = $relateMapper->searchOneByField('name', 'sad');
        //var_dump($arr); exit;
        if ($relate) {
            return new relateViewView($relate);
        }
    }
}

?>
