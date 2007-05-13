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
 * @version 0.1
 */

class gallerySaveAlbumController extends simpleController
{
    public function getView()
    {

        $albumMapper = $this->toolkit->getMapper('gallery', 'album');
        $id = $this->request->get('id', 'integer', SC_PATH);
        $galleryMapper = $this->toolkit->getMapper('gallery', 'gallery');

        $action = $this->request->getAction();
        $isEdit = ($action == 'editAlbum');

        $album = $albumMapper->searchById($id);

        if ($isEdit && !$album) {
            return $albumMapper->get404()->run();
        }

        /*
        $gallery = $galleryMapper->searchByOwner($user);

        if (!$gallery) {
        return $galleryMapper->get404()->run();
        }

        if ($isEdit) {
        $album = $albumMapper->searchByGalleryId($gallery->getId());
        if (!$album) {
        return $albumMapper->get404()->run();
        }
        } else {
        $album = $albumMapper->create();
        }*/

        $validator = new formValidator();
        $validator->add('required', 'name', 'Необходимо назвать альбом');

        if ($validator->validate()) {
            $name = $this->request->get('name', 'string', SC_POST);

            $album->setName($name);
            $albumMapper->save($album);

            return jipTools::redirect();
        }

        $url = new url('withId');
        $url->setAction($action);
        $url->addParam('id', $album->getId());

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('album', $album);
        $this->smarty->assign('isEdit', $isEdit);
        return $this->smarty->fetch('gallery/saveAlbum.tpl');
    }
}

?>