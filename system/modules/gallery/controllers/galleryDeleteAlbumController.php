<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * galleryDeleteAlbumController: контроллер для метода deleteAlbum модуля gallery
 *
 * @package modules
 * @subpackage gallery
 * @version 0.1
 */

class galleryDeleteAlbumController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer');
        $albumMapper = $this->toolkit->getMapper('gallery', 'album');

        $album = $albumMapper->searchById($id);

        $owner = $album->getGallery()->getOwner()->getLogin();

        if ($album) {
            $albumMapper->delete($album);
        }

        $url = new url('withAnyParam');
        $url->add('name', $owner);
        $url->setAction('viewGallery');

        return jipTools::redirect($url->get());
    }
}

?>