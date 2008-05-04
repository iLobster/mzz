<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('forms/validators/formValidator');

/**
 * ratingsViewController: контроллер для метода view модуля ratings
 *
 * @package modules
 * @subpackage ratings
 * @version 0.1
 */

class ratingsViewController extends simpleController
{
    protected function getView()
    {
        $user = $this->toolkit->getUser();

        $ratingsMapper = $this->toolkit->getMapper('ratings', 'ratings');
        $ratingsFolderMapper = $this->toolkit->getMapper('ratings', 'ratingsFolder');

        $parent_id = $this->request->getInteger('id');

        $ratingsFolder = $ratingsFolderMapper->searchOneByField('parent_id', $parent_id);

        $criteria = new criteria;
        $criteria->add('folder_id', $ratingsFolder->getId())->add('user_id', $user->getId());
        $myrate = $ratingsMapper->searchOneByCriteria($criteria);

        $stars = range(1, ratingsFolderMapper::STARS_COUNT);
        $starsNames = array(
            1 => 'one-star',
            2 => 'two-stars',
            3 => 'three-stars',
            4 => 'four-stars',
            5 => 'five-stars'
        );

        $this->smarty->assign('errors', new arrayDataspace());

        if (!$myrate) {
            $validator = new formValidator('rate_subm');
            $validator->add('required', 'rate', 'Неверная оценка');
            $validator->add('in', 'rate', 'Неверная оценка', $stars);

            if ($validator->validate()) {
                $rate = $this->request->getInteger('rate', SC_REQUEST);
                $myrate = $ratingsMapper->create();
                $myrate->setFolder($ratingsFolder);
                $myrate->setUser($user);
                $myrate->setRate($rate);

                $ratingsMapper->save($myrate);

                $rateCount = $ratingsFolder->getRateCount() + 1;
                $rateSum = $ratingsFolder->getRateSum() + $rate;

                $ratingsFolder->setRateCount($rateCount);
                $ratingsFolder->setRateSum($rateSum);
                $ratingsFolderMapper->save($ratingsFolder);
            }

            $this->smarty->assign('errors', $validator->getErrors());
        }

        $this->smarty->assign('stars', $stars);
        $this->smarty->assign('starsNames', $starsNames);
        $this->smarty->assign('starsCount', ratingsFolderMapper::STARS_COUNT);
        $this->smarty->assign('myrate', $myrate);
        $this->smarty->assign('folder', $ratingsFolder);
        return $this->smarty->fetch('ratings/view.tpl');
    }
}

?>