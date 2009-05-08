<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * ratingsRateController: контроллер для метода rate модуля ratings
 *
 * @package modules
 * @subpackage ratings
 * @version 0.1
 */

class ratingsRateController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');
        $ratingsFolderMapper = $this->toolkit->getMapper('ratings', 'ratingsFolder');

        $ratingsFolder = $ratingsFolderMapper->searchById($id);

        if (!$ratingsFolder) {
            return $this->forward404($ratingsFolderMapper);
        }

        $rate = $this->request->getInteger('rate');

        switch ($ratingsFolder->getType()) {
            case 'quote':
                $newRating = $ratingsFolder->getRating() + $rate;
                $ratingsFolder->setRating($newRating);
                $ratingsFolderMapper->save($ratingsFolder);
                break;
        }

        return $this->smarty->fetch('ratings/rate.tpl');
    }
}

?>