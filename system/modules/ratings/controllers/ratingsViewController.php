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

        $action = $this->request->getAction();
        $isPost = ($action == 'post');
        $isSaved = false;

        $ratingsMapper = $this->toolkit->getMapper('ratings', 'ratings');
        $ratingsFolderMapper = $this->toolkit->getMapper('ratings', 'ratingsFolder');

        if (!$isPost) {
            $parent_id = $this->request->getInteger('id');
            $ratingsFolder = $ratingsFolderMapper->searchOneByField('parent_id', $parent_id);
        } else {
            $id = $this->request->getInteger('id');

            $ratingsFolder = $ratingsFolderMapper->searchByKey($id);
            if (!$ratingsFolder) {
                return $ratingsFolderMapper->get404()->run();
            }
        }

        $criteria = new criteria;
        $criteria->add('folder_id', $ratingsFolder->getId())->add('user_id', $user->getId());
        $myrate = $ratingsMapper->searchOneByCriteria($criteria);

        $stars = range(1, ratingsFolderMapper::STARS_COUNT);

        $validator = new formValidator('rate');
        $validator->add('required', 'rate', 'Неверная оценка');
        $validator->add('in', 'rate', 'Неверная оценка', $stars);

        $errors = $validator->getErrors();
        if ($isPost && $myrate) {
            $errors->set('rate', 'Уже голосовали');
        }

        if (!$myrate && $validator->validate()) {
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
            $isSaved = true;
        }

        $this->smarty->assign('stars', $stars);
        $this->smarty->assign('starsCount', ratingsFolderMapper::STARS_COUNT);
        $this->smarty->assign('myrate', $myrate);
        $this->smarty->assign('folder', $ratingsFolder);
        $this->smarty->assign('isPost', $isPost);
        $this->smarty->assign('isSaved', $isSaved);
        $this->smarty->assign('errors', $errors);
        return $this->smarty->fetch('ratings/view.tpl');
    }
}

?>