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
 * galleryViewGalleryController: контроллер для метода viewGallery модуля gallery
 *
 * @package modules
 * @subpackage gallery
 * @version 0.1
 */

class galleryViewGalleryController extends simpleController
{
    public function getView()
    {
        $userMapper = $this->toolkit->getMapper('user', 'user', 'user');
        $galleryMapper = $this->toolkit->getMapper('gallery', 'gallery');

        $user_name = $this->request->get('name', 'string', SC_PATH);
        $user = $userMapper->searchByLogin($user_name);
        if ($user->getId() == MZZ_USER_GUEST_ID) {
            return $galleryMapper->get404()->run();
        }

        // сделать проверку на возможность создания галереи

        $gallery = $galleryMapper->searchOneByField('owner', $user->getId());
        if (is_null($gallery)) {
            $gallery = $galleryMapper->create();
            $gallery->setOwner($user);
            $galleryMapper->save($gallery);
        }

        $albumMapper = $this->toolkit->getMapper('gallery', 'album');
        $albums = $albumMapper->searchAllByField('gallery_id', $gallery->getId());

        $this->smarty->assign('user', $user_name);
        $this->smarty->assign('gallery', $gallery);
        $this->smarty->assign('albums', $albums);

        return $this->smarty->fetch('gallery/viewGallery.tpl');
    }
}

?>