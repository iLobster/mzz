<?php
/**
 * $URL$
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1.1
 */

class fileManagerGetController extends simpleController
{
    public function getView()
    {
        $name = $this->request->get('name', 'string', SC_PATH);

        $fileMapper = $this->toolkit->getMapper('fileManager', 'file');
        $file = $fileMapper->searchByPath($name);

        if (!$file) {
            return $fileMapper->get404()->run();
        }

        try {
            $file->download();
        } catch (mzzIoException $e) {
            return $e->getMessage();
        }
    }
}

?>
