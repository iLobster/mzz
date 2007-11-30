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

        $user_name = $this->request->get('name', 'string');
        $userMapper = $this->toolkit->getMapper('user', 'user', 'user');

        $user = $userMapper->searchByLogin($user_name);
        if ($user->getId() == MZZ_USER_GUEST_ID) {
            return $albumMapper->get404()->run();
        }

        $album_id = $this->request->get('album', 'integer');
        $album = $albumMapper->searchById($album_id);

        $photo_id = $this->request->get('id', 'integer', SC_PATH);
        $photo = $photoMapper->searchById($photo_id);

        $photos = $album->getPhotos();

        $this->smarty->assign('photo', $photo);
        $this->smarty->assign('album', $album);
        $this->smarty->assign('user', $user);
        $this->smarty->assign('photos', $photos);
        return $this->smarty->fetch('gallery/view.tpl');
    }
}

?>