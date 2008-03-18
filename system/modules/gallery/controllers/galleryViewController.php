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
 * galleryViewController: контроллер для метода view модуля gallery
 *
 * @package modules
 * @subpackage gallery
 * @version 0.1
 */

class galleryViewController extends simpleController
{
    protected function getView()
    {
        $albumMapper = $this->toolkit->getMapper('gallery', 'album');
        $photoMapper = $this->toolkit->getMapper('gallery', 'photo');

        $user_name = $this->request->getString('name');
        $userMapper = $this->toolkit->getMapper('user', 'user', 'user');

        $user = $userMapper->searchByLogin($user_name);
        if ($user->getId() == MZZ_USER_GUEST_ID) {
            return $albumMapper->get404()->run();
        }

        $album_id = $this->request->getInteger('album');
        $album = $albumMapper->searchById($album_id);

        $photo_id = $this->request->getInteger('id');
        $photo = $photoMapper->searchById($photo_id);

        $url = new url('withId');
        $url->setAction('editPhoto');
        $url->add('id', $photo_id);

        $photos = $album->getPhotos();

        $this->smarty->assign('photo', $photo);
        $this->smarty->assign('album', $album);
        $this->smarty->assign('user', $user);
        $this->smarty->assign('photos', $photos);
        $this->smarty->assign('tagLink', $url->get());
        return $this->smarty->fetch('gallery/view.tpl');
    }
}

?>