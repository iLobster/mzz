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
    protected function getView()
    {
        $photoMapper = $this->toolkit->getMapper('gallery', 'photo');
        if ($this->request->getString('ajaxAction', SC_POST) === 'tag') {
            $photo = $photoMapper->searchById($this->request->getInteger('id'));

            if (!$photo) {
                $photoMapper->get404()->run();
            }

            $obj_id = $photo->getObjId();
            $tagsItemMapper = $this->toolkit->getMapper('tags', 'tagsItem', 'tags');
            $tagsItem = $tagsItemMapper->searchOneByField('item_obj_id', $obj_id);

            if(!empty($tagsItem)) {
                $tag = str_replace(',', ' ', $this->request->getString('tag', SC_POST)); // only one
                $coords = $this->request->getString('coords', SC_POST);
                $tagsItem->setTag($tag);
                $tagsItem->setCoords($coords);
                $tagsItemMapper->save($tagsItem);
                return 1;
            }

            return $tagsItemMapper->get404()->run();
        }

        $albumMapper = $this->toolkit->getMapper('gallery', 'album');

        $action = $this->request->getAction();
        $isEdit = ($action == 'editPhoto');

        $validator = new formValidator();

        $validator->add('required', 'name', 'Укажите имя фотографии');

        if ($isEdit) {
            $photo_id = $this->request->getInteger('id');
            $photo = $photoMapper->searchById($photo_id);
            $album = $photo->getAlbum();
        } else {
            $photo = $photoMapper->create();
            $album_id = $this->request->getInteger('id');
            $album = $albumMapper->searchById($album_id);

            $config = systemToolkit::getInstance()->getConfig('gallery', $photoMapper->section());
            $folderMapper = $this->toolkit->getMapper('fileManager', 'folder', $config->get('filemanager_section'));
            $folder = $folderMapper->searchByPath('root/gallery');

            $validator->add('uploaded', 'image', 'Укажите файл для загрузки');
        }


        $errors = $validator->getErrors();

        if ($validator->validate()) {
            $name = $this->request->getString('name', SC_POST);
            $about = $this->request->getString('about', SC_POST);

            if ($isEdit) {
                $photo->setName($name);
                $photo->setAbout($about);
                $photoMapper->save($photo);

                return jipTools::redirect();
            } else {
                try {
                    $file = $folder->upload('image');
                    $photo->setAlbum($album);
                    $photoMapper->save($photo);

                    $album->setPicsNumber($album->getPicsNumber() + 1);
                    $albumMapper->save($album);

                    $fileMapper = $photo->getFileMapper();
                    $fileMapper->save($file);
                    $file->setName($photo->getId() . '.' . $file->getExt());
                    $file->setRightHeader(1);
                    $fileMapper->save($file);

                    $photo->setName($name);
                    $photo->setAbout($about);
                    $photoMapper->save($photo);

                    $this->smarty->assign('photo_name', $photo->getName());
                    $this->smarty->assign('success', true);
                } catch (mzzRuntimeException $e) {
                    $errors->set('image', $e->getMessage());
                }
            }
        }

        $url = new url('withId');
        $url->setAction($action);
        $url->add('id', $isEdit ? $photo->getId() : $album->getId());

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('album', $album);
        $this->smarty->assign('errors', $errors);
        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('photo', $photo);

        return $this->smarty->fetch('gallery/savePhoto.tpl');
    }
}

?>