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


        // hasMany
        $relate = $relateMapper->searchAllByField('name', 'sada');
        
        //var_dump($relate);exit;
        
        foreach ($relate as $val) {
                echo $val->getId();
                echo '-';
                echo $val->getRelated()->getId();
                echo '-sub->';
                foreach ($val->getRelated2() as $sub) {
                        echo $sub->getRelateId();
                        echo '-';
                        echo $sub->getFoobar();
                        //var_dump($sub);
                }
                echo '<br>-----<br>';
        }
        exit;
        // owns
        $relate = $relateMapper->searchAllByField('name', 'sada');
        foreach ($relate as $val) {
                echo $val->getId();
                echo '-';
                echo $val->getRelated2()->getFoobar();
                echo '-';
                echo $val->getRelated()->getId();
                echo '-';
                echo $val->getRelated()->getData();
                echo '<br>-----<br>';
        }
        exit;
        
        
        
        // ownsMany
        $relate = $relateMapper->searchAllByField('name', 'sada');
        foreach ($relate as $val) {
                echo $val->getId();
                echo '-';
                echo $val->getRelated2()->getFoobar();
                echo '-sub->';
                foreach ($val->getRelated() as $sub) {
                        echo $sub->getId();
                        echo '-';
                        echo $sub->getData();
                }
                echo '<br>-----<br>';
        }
        
        exit;

        if ($relate) {
            return new relateViewView($relate);
        }
    }
}

?>
