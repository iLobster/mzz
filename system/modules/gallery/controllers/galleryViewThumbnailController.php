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
 * galleryViewThumbnailController: контроллер для метода viewThumbnail модуля gallery
 *
 * @package modules
 * @subpackage gallery
 * @version 0.1
 */

class galleryViewThumbnailController extends simpleController
{
    protected function getView()
    {
        $albumMapper = $this->toolkit->getMapper('gallery', 'album');
        $photoMapper = $this->toolkit->getMapper('gallery', 'photo');

        $album_id = $this->request->get('album', 'integer');
        $album = $albumMapper->searchById($album_id);

        $photo_id = $this->request->get('id', 'integer', SC_PATH);
        $photo = $photoMapper->searchById($photo_id);
        $thumbnail = $photo->getThumbnail();

        /*
        if (!$thumbnail) {
            $source = $photo->getFile();
            if ($source && in_array($ext = $source->getExt(), array('jpg', 'jpeg', 'png', 'gif'))) {
                if ($ext == 'jpg') {
                    $ext = 'jpeg';
                }
                $filename = $source->getRealFullPath();
                $config = $this->toolkit->getConfig('gallery');

                $width = $config->get('thmb_width');
                $height = $config->get('thmb_height');;

                list($width_orig, $height_orig) = getimagesize($filename);

                $aspect_w = $width_orig / $width;
                $aspect_h = $height_orig / $height;

                $aspect = ($aspect_h > $aspect_w) ? $aspect_h : $aspect_w;

                if ($aspect <= 1) {
                    $width = $width_orig;
                    $height = $height_orig;
                } else {
                    $width = round($width_orig / $aspect);
                    $height = round($height_orig / $aspect);
                }

                $thumbnail = imagecreatetruecolor($width, $height);
                $image = call_user_func('imagecreatefrom' . $ext, $filename);
                imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

                $file = systemConfig::$pathToTemp . DIRECTORY_SEPARATOR . $photo->getId();

                call_user_func('image' . $ext, $thumbnail, $file);

                $config = systemToolkit::getInstance()->getConfig('gallery', $photoMapper->section());
                $section = $config->get('filemanager_section');

                $folderMapper = $this->toolkit->getMapper('fileManager', 'folder', $section);
                $fileMapper = $this->toolkit->getMapper('fileManager', 'file', $section);

                $folder = $folderMapper->searchByPath('root/gallery/thumbnails');
                $thumbnail = $folder->upload($file, $photo_id . '.' . $source->getExt());
                $thumbnail->setRightHeader(1);
                $fileMapper->save($thumbnail);
            }
        }

        */

        try {
            $thumbnail->download();
        } catch (mzzIoException $e) {
            return $e->getMessage();
        }
    }
}

?>