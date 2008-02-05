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
 * fileManagerUploadController: контроллер для метода upload модуля fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1.4
 */

class fileManagerUploadController extends simpleController
{
    protected function getView()
    {
        $folderMapper = $this->toolkit->getMapper('fileManager', 'folder');
        $path = $this->request->get('name', 'string', SC_PATH);

        $folder = $folderMapper->searchByPath($path);

        if (!$folder) {
            return $folderMapper->get404()->run();
        }

        $validator = new formValidator();
        $validator->add('uploaded', 'file', 'Укажите файл для загрузки');
        $validator->add('regex', 'name', 'Недопустимые символы в имени', '/^[a-zа-я0-9_\.\-! ]+$/ui');

        $errors = $validator->getErrors();

        if ($validator->validate()) {
            $name = $this->request->get('name', 'string', SC_POST);
            $header = $this->request->get('header', 'string', SC_POST);
            $about = $this->request->get('about', 'string', SC_POST);
            $direct_link = $this->request->get('direct_link', 'string', SC_POST);

            $config = $this->toolkit->getConfig('fileManager');

            try {
                $file = $folder->upload('file', $name);
                $file->setRightHeader($header);
                $file->setAbout($about);
                $file->setDirectLink($direct_link);

                $fileMapper = $this->toolkit->getMapper('fileManager', 'file');
                $fileMapper->save($file);

                $this->smarty->assign('file_name', $file->getName());
                $this->smarty->assign('success', true);
            } catch (mzzRuntimeException $e) {
                $errors->set('file', $e->getMessage());
            }
        }

        $url = new url('withAnyParam');
        $url->setAction('upload');
        $url->add('name', $folder->getPath());
        $this->smarty->assign('form_action', $url->get());

        $this->smarty->assign('errors', $errors);

        $this->smarty->assign('folder', $folder);

        return $this->smarty->fetch('fileManager/upload.tpl');
    }
}

?>
