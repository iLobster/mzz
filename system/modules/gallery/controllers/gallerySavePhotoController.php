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
 * gallerySavePhotoController: контроллер для метода savePhoto модуля gallery
 *
 * @package modules
 * @subpackage gallery
 * @version 0.1
 */

class gallerySavePhotoController extends simpleController
{
    public function getView()
    {
        $album_id = $this->request->get('id', 'integer');

        $albumMapper = $this->toolkit->getMapper('gallery', 'album');
        // хардкод убрать
        $folderMapper = $this->toolkit->getMapper('fileManager', 'folder', 'fileManager');

        $album = $albumMapper->searchById($album_id);

        $folder = $folderMapper->searchByPath('root/gallery');

        $validator = new formValidator();
        $validator->add('uploaded', 'image', 'Укажите файл для загрузки');
        $errors = $validator->getErrors();

        if ($validator->validate()) {
            $name = $this->request->get('name', 'string', SC_POST);

            try {
                $file = $folder->upload('image', md5(microtime(true)));

                $photosMapper = $this->toolkit->getMapper('gallery', 'photo');
                $photo = $photosMapper->create();
                $photo->setAlbum($album);
                $photo->setName($name);
                $photosMapper->save($photo);

                $album->setPicsNumber($album->getPicsNumber() + 1);
                $albumMapper->save($album);

                $filerMapper = $this->toolkit->getMapper('fileManager', 'file', 'fileManager');
                $file->setName($photo->getId() . '.jpg');
                $file->setRightHeader(1);
                $filerMapper->save($file);

                return '<div id="uploadStatus">Файл "' . $file->getName() . '" загружен.</div>';
            } catch (mzzRuntimeException $e) {
                $errors->set('image', $e->getMessage());
            }
        }

        $url = new url('withId');
        $url->setAction('uploadPhoto');
        $url->addParam('id', $album->getId());
        $this->smarty->assign('form_action', $url->get());

        $this->smarty->assign('album', $album);
        $this->smarty->assign('errors', $errors);

        return $this->smarty->fetch('gallery/savePhoto.tpl');
    }
}

?>