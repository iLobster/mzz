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

fileLoader::load('fileManager/views/fileUploadForm');

/**
 * fileManagerUploadController: контроллер для метода upload модуля fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1
 */

class fileManagerUploadController extends simpleController
{
    public function getView()
    {
        $folderMapper = $this->toolkit->getMapper('fileManager', 'folder');
        $path = $this->request->get('name', 'string', SC_PATH);

        $folder = $folderMapper->searchByPath($path);

        if (!$folder) {
            // @todo: изменить
            return 'каталог не найден';
        }

        $form = fileUploadForm::getForm($folder);

        if ($form->validate()) {
            $values = $form->exportValues();

            $config = $this->toolkit->getConfig('fileManager');
            //echo '<br><pre>'; var_dump($config->get('upload_path')); echo '<br></pre>';
            $fileForm = $form->getElement('file');

            $info = $fileForm->getValue();
            $name = !empty($values['name']) ? $values['name'] : $info['name'];

            $ext = '';
            if (($dot = strrpos($name, '.')) !== false) {
                $ext = substr($name, $dot + 1);
            }
            //echo '<br><pre>'; var_dump($name); echo '<br></pre>';
            //echo '<br><pre>'; var_dump($ext); echo '<br></pre>';
            /*if  {
            $newName = $values['name'];
            }*/

            $criteria = new criteria();
            $criteria->add('folder_id', $folder->getId())->add('name', $name);

            $fileMapper = $this->toolkit->getMapper('fileManager', 'file');
            $file = $fileMapper->searchOneByCriteria($criteria);

            if (!$file) {
                while (true) {
                    try {
                        $file = $fileMapper->create();
                        $file->setRealname($realname = md5(microtime(true)));
                        $file->setName($name);
                        $file->setExt($ext);
                        $file->setSize($info['size']);
                        $file->setFolder($folder);
                        $fileMapper->save($file);

                        $fileForm->moveUploadedFile($config->get('upload_path'), $file->getRealname());

                        break;
                    } catch (PDOException $e) {
                    }
                }

                return 'ok';
            }

            $form->setElementError('name', 'Файл с таким именем в этой папке уже существует');

            //var_dump($file->moveUploadedFile($config->get('upload_path'), $newName));

            //echo '<br><pre>'; var_dump($file); echo '<br></pre>';

        }

        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $form->accept($renderer);

        $this->smarty->assign('folder', $folder);
        $this->smarty->assign('form', $renderer->toArray());

        return $this->smarty->fetch('fileManager/upload.tpl');
    }
}

?>