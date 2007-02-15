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
 * @version 0.1.1
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
            $fileForm = $form->getElement('file');

            $info = $fileForm->getValue();
            $name = !empty($values['name']) ? $values['name'] : $info['name'];

            $criteria = new criteria();
            $criteria->add('folder_id', $folder->getId())->add('name', $name);

            $fileMapper = $this->toolkit->getMapper('fileManager', 'file');
            $file = $fileMapper->searchOneByCriteria($criteria);

            $exts = $folder->getExts();
            $exts = explode(';', $exts);
            array_map('trim', $exts);
            usort($exts, create_function('$a,$b', 'return strlen($a) < strlen($b);'));

            foreach ($exts as $ext) {
                if (strlen($ext) + strrpos($name, $ext) == strlen($name)) {
                    $name_wo_ext = substr($name, 0, -strlen($ext) - 1);
                    break;
                }
            }

            if (!isset($name_wo_ext)) {
                // получаем имя без расширения
                $name_wo_ext = $name; $ext = '';
                if ($dot = strrpos($name, '.')) {
                    $name_wo_ext = substr($name, 0, $dot);
                    $ext = substr($name, $dot + 1);
                }
            }

            if ($file) {
                // ищем все файлы которые подпадают под маску: filename*.ext
                $criterion = new criterion('name', $name, criteria::NOT_EQUAL);
                $criterion->addAnd(new criterion('name', $name_wo_ext . '%' . ($ext ? '.' . $ext : ''), criteria::LIKE));

                $criteria = new criteria();
                $criteria->add('folder_id', $folder->getId())->add($criterion);
                $criteria->setOrderByFieldAsc('name');
                $files = $fileMapper->searchAllByCriteria($criteria);

                // ищем первый "пробел" в нумерации файлов с одинаковыми именами
                $i = 2;
                foreach ($files as $file) {
                    if (strpos($file->getName(), $name_wo_ext . $i) !== 0) {
                        break;
                    }
                    $i++;
                }

                // добавляем к имени найденный индекс
                $name = substr_replace($name, $name_wo_ext . $i, 0, strlen($name_wo_ext));
                $file = false;
            }

            if ($filesize = $folder->getFilesize()) {
                $size_in_mb = round($info['size'] / 1024 / 1024, 3);
                if ($size_in_mb > $filesize) {
                    $form->setElementError('file', 'Ограничение на загрузку файла: ' . $filesize . ' Мб. У загружаемого файла размер: ' . $info['size'] . ' Мб');
                    $file = true;
                }
            }

            if ($exts = $folder->getExts()) {
                $exts = explode(';', $exts);

                if (!in_array($ext, $exts)) {
                    $form->setElementError('file', 'Ограничение на расширение файла: ' . $folder->getExts() . '. У загружаемого файла расширение: "' . $ext . '"');
                    $file = true;
                }
            }

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
                        return 'Файл "' . $name . '" загружен.';
                        break;
                    } catch (PDOException $e) {
                    }
                }

                return new simpleJipRefreshView();
            }
        }

        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $form->accept($renderer);

        $this->smarty->assign('folder', $folder);
        $this->smarty->assign('form', $renderer->toArray());

        return $this->smarty->fetch('fileManager/upload.tpl');
    }
}

?>