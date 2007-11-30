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
 * galleryDeleteController: контроллер для метода delete модуля gallery
 *
 * @package modules
 * @subpackage gallery
 * @version 0.1.1
 */

class galleryDeleteController extends simpleController
{
    protected function getView()
    {
        $photoMapper = $this->toolkit->getMapper('gallery', 'photo');
        $id = $this->request->get('id', 'integer', SC_PATH);
        $photo = $photoMapper->searchById($id);
        $url = null;
        if ($photo) {
            $fileMapper = $photo->getFileMapper();
            $albumMapper = $this->toolkit->getMapper('gallery', 'album');
            $file = $photo->getFile();
            $album = $photo->getAlbum();

            $album->setPicsNumber($album->getPicsNumber() - 1);
            $albumMapper->save($album);

            $url = new url('galleryAlbum');
            $url->add('name', $album->getGallery()->getOwner()->getLogin());
            $url->add('album', $album->getId());
            $url->setAction('viewAlbum');
            $url = $url->get();

            $photoMapper->delete($photo);
        }

        return jipTools::redirect($url);
    }
}

?>