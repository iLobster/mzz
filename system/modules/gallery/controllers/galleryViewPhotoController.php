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
 * galleryViewPhotoController: контроллер для метода viewPhoto модуля gallery
 *
 * @package modules
 * @subpackage gallery
 * @version 0.1.1
 */

class galleryViewPhotoController extends simpleController
{
    protected function getView()
    {
        $photoMapper = $this->toolkit->getMapper('gallery', 'photo');
        $albumMapper = $this->toolkit->getMapper('gallery', 'album');

        $album_id = $this->request->get('album', 'integer');
        $album = $albumMapper->searchById($album_id);

        $photo_id = $this->request->get('id', 'integer', SC_PATH);
        $photo = $photoMapper->searchById($photo_id);

        $file = $photo->getFile();
        try {
            $file->download();
        } catch (mzzIoException $e) {
            return $e->getMessage();
        }
    }
}

?>