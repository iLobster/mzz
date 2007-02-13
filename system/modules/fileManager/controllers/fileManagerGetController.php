<?php
/**
 * $URL$
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1
 */

class fileManagerGetController extends simpleController
{
    public function getView()
    {
        fileLoader::load('libs/PEAR/Download');

        $name = $this->request->get('name', 'string', SC_PATH);

        $fileMapper = $this->toolkit->getMapper('fileManager', 'file');
        $file = $fileMapper->searchByPath($name);

        if (!$file) {
            return 'файл не найден';
        }

        $params = array(
        'file' => $file->getRealFullPath(),
        );

        $dl = new HTTP_Download;
        $dl->setParams($params);
        $dl->setCache(false);
        $dl->setContentDisposition(HTTP_DOWNLOAD_ATTACHMENT, $file->getName());
        $dl->send();
    }
}

?>
