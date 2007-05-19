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
    public function getView()
    {
        $fileMapper = $this->toolkit->getMapper('fileManager', 'file', 'fileManager');
        $albumMapper = $this->toolkit->getMapper('gallery', 'album');

        $album_id = $this->request->get('album', 'integer');
        $album = $albumMapper->searchById($album_id);

        $photo = $this->request->get('pic', 'string', SC_PATH);
        $photo .= '.jpg';
        $thumbnail = $fileMapper->searchByPath('root/gallery/thumbnails/' . $photo);

        if (!$thumbnail) {
            $source = $fileMapper->searchByPath('root/gallery/' . $photo);
            if ($source) {
                $filename = $source->getRealFullPath();
                $width = 200;
                $height = 200;

                list($width_orig, $height_orig) = getimagesize($filename);

                if ($width && ($width_orig < $height_orig)) {
                    $width = ($height / $height_orig) * $width_orig;
                } else {
                    $height = ($width / $width_orig) * $height_orig;
                }

                $thumbnail = imagecreatetruecolor($width, $height);
                $image = imagecreatefromjpeg($filename);
                imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

                $file = systemConfig::$pathToTemp . DIRECTORY_SEPARATOR . $photo;
                imagejpeg($thumbnail, $file);

                $folderMapper = $this->toolkit->getMapper('fileManager', 'folder', 'fileManager');

                $folder = $folderMapper->searchByPath('root/gallery/thumbnails');
                $file = $folder->upload($file, $photo);
                $file->setRightHeader(1);
                $fileMapper->save($file);

                $thumbnail = $file;
            }
        }

         try {
            $thumbnail->download();
        } catch (mzzIoException $e) {
            return $e->getMessage();
        }
    }
}

?>