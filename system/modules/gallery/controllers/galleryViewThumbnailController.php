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

        $photo = $this->request->get('pic', 'string', SC_PATH);
        $thumbnail = $fileMapper->searchByPath('root/gallery/thumbnails/' . $photo);

        if (!$thumbnail) {
            $source = $fileMapper->searchByPath('root/gallery/' . $photo);
            if ($source) {

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