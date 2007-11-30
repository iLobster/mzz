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

fileLoader::load('forms/validators/formValidator');

/**
 * gallerySaveAlbumController: контроллер для метода saveAlbum модуля gallery
 *
 * @package modules
 * @subpackage gallery
 * @version 0.1.1
 */

class gallerySaveAlbumController extends simpleController
{
    protected function getView()
    {
        $userMapper = $this->toolkit->getMapper('user', 'user', 'user');
        $albumMapper = $this->toolkit->getMapper('gallery', 'album');
        $galleryMapper = $this->toolkit->getMapper('gallery', 'gallery');

        $action = $this->request->getAction();
        $isEdit = ($action == 'editAlbum');

        if ($isEdit) {
            $id = $this->request->get('id', 'integer', SC_PATH);
            $album = $albumMapper->searchById($id);
            if (!$album) {
                return $albumMapper->get404()->run();
            }
        } else {
            $user_name = $this->request->get('name', 'string', SC_PATH);
            $user = $userMapper->searchByLogin($user_name);
            if ($user->getId() == MZZ_USER_GUEST_ID) {
                return $albumMapper->get404()->run();
            }
            $album = $albumMapper->create();
        }

        $validator = new formValidator();
        $validator->add('required', 'name', 'Необходимо назвать альбом');

        if ($validator->validate()) {
            $name = $this->request->get('name', 'string', SC_POST);
            $main_photo = $this->request->get('main_photo', 'integer', SC_POST);

            $album->setName($name);
            if ($isEdit) {
                $album->setMainPhoto($main_photo);
            } else {
                $album->setGallery($galleryMapper->searchByOwner($user->getId())->getId());
                $album->setPicsNumber(0);
            }

            $albumMapper->save($album);

            return jipTools::redirect();
        }

        if ($isEdit) {
            $url = new url('withId');
            $url->add('id', $album->getId());
        } else {
            $url = new url('withAnyParam');
            $url->add('name', $user->getLogin());
        }

        $url->setAction($action);

        if ($isEdit) {
            $photosMapper = $this->toolkit->getMapper('gallery', 'photo');
            $albumPhotos = $photosMapper->searchAllByField('album_id', $album->getId());
            $photos = array();

            foreach ($albumPhotos as $photo) {
                $photos[$photo->getId()] = $photo->getName();
            }


            $this->smarty->assign('photos', $photos);
        }
        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('album', $album);
        $this->smarty->assign('isEdit', $isEdit);
        return $this->smarty->fetch('gallery/saveAlbum.tpl');
    }
}

?>