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
        $ratingsMapper = $this->toolkit->getMapper('ratings', 'ratings');
        $ratingsFolderMapper = $this->toolkit->getMapper('ratings', 'ratingsFolder');

        $user = $this->toolkit->getUser();

        $access = $this->request->getBoolean('access');

        $action = $this->request->getAction();
        $isPost = ($action == 'post');
        $isSaved = false;

        $isStatic = $this->request->getBoolean('static');

        $prefix = $this->request->getString('tplPrefix');
        if (!empty($prefix)) {
            $prefix .= '/';
        }

        $id = $this->request->getInteger('id');

        if (!$isPost) {
            $ratingsFolder = $ratingsFolderMapper->searchOneByField('parent_id', $id);
        } else {
            $ratingsFolder = $ratingsFolderMapper->searchByKey($id);
            if (!$ratingsFolder) {
                return $ratingsFolderMapper->get404()->run();
            }
        }

        $criteria = new criteria;
        $criteria->add('folder_id', $ratingsFolder->getId())->add('user_id', $user->getId());
        $myrate = $ratingsMapper->searchOneByCriteria($criteria);

        $starsCount = ratingsFolderMapper::STARS_COUNT;
        $stars = range(1, $starsCount);

        $validator = new formValidator('rate');
        $validator->add('required', 'rate', 'Вы должны указать оценку');
        $validator->add('in', 'rate', 'Неверная оценка', $stars);

        $errors = $validator->getErrors();

        $access = $this->request->getBoolean('access');
        if ($isPost && !is_null($access) && !$access) {
            $errors->set('rate', ($user->getId() == MZZ_USER_GUEST_ID) ? 'Оценивать разрешено только зарегестрированным и авторизованным пользователям' : 'Запрещено');
        }

        if ($isPost && $myrate) {
            $errors->set('rate', 'Уже голосовали');
        }

        if (!$myrate && $validator->validate() && $errors->isEmpty()) {
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
        $this->smarty->assign('starsCount', $starsCount);
        $this->smarty->assign('myrate', $myrate);
        $this->smarty->assign('folder', $ratingsFolder);
        $this->smarty->assign('isPost', $isPost);
        $this->smarty->assign('isSaved', $isSaved);
        $this->smarty->assign('isStatic', $isStatic);
        $this->smarty->assign('errors', $errors);

        if (!$isStatic) {
            return $this->smarty->fetch('ratings/' . $prefix . 'view.tpl');
        } else {
            return $this->smarty->fetch('ratings/' . $prefix . 'view_static.tpl');
        }
    }
}

?>