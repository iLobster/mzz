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
 * galleryViewAlbumController: контроллер для метода viewAlbum модуля gallery
 *
 * @package modules
 * @subpackage gallery
 * @version 0.1
 */

class galleryViewAlbumController extends simpleController
{
    public function getView()
    {
        $user_name = $this->request->get('name', 'string');
        $album_id = $this->request->get('album', 'integer');

        $userMapper = $this->toolkit->getMapper('user', 'user', 'user');
        $albumMapper = $this->toolkit->getMapper('gallery', 'album');

        $user = $userMapper->searchByLogin($user_name);
        if ($user->getId() == MZZ_USER_GUEST_ID) {
            return $albumMapper->get404()->run();
        }

        $album = $albumMapper->searchById($album_id);
        if (is_null($album) || $album->getGallery()->getOwner()->getId() != $user->getId()) {
            return $albumMapper->get404()->run();
        }

        $photosMapper = $this->toolkit->getMapper('gallery', 'photo');
        $photos = $photosMapper->searchAllByField('album_id', $album->getId());

        $this->smarty->assign('album', $album);
        $this->smarty->assign('photos', $photos);
        $this->smarty->assign('user', $user);
        // @todo: убрать хардкод
        $this->smarty->assign('url_prefix', '/fileManager/gallery/');

        return $this->smarty->fetch('gallery/viewAlbum.tpl');
    }
}

?>