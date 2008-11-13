<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('forms/validators/formValidator');

/**
 * forumSaveProfileController: контроллер для метода editProfile модуля forum
 *
 * @package modules
 * @subpackage forum
 * @version 0.1
 */

class forumSaveProfileController extends simpleController
{
    protected function getView()
    {
        $action = $this->request->getAction();
        $isEdit = ($action == 'editProfile');

        $id = $this->request->getInteger('id');

        $profileMapper = $this->toolkit->getMapper('forum', 'profile');
        $profile = $profileMapper->searchById($id);

        if (!$profile) {
            return $profileMapper->get404()->run();
        }

        $validator = new formValidator();
        $validator->add('url', 'url', 'Укажите правильный адрес сайта');
        $validator->add('numeric', 'icq', 'Укажите правильный номер ICQ');

        $avatarUploaded = false;
        if ($this->request->getString('avatar[name]', SC_FILES)) {
            $validator->add('uploaded', 'avatar', 'Укажите файл для загрузки');
            $avatarUploaded = true;
        }

        $folderMapper = $this->toolkit->getMapper('fileManager', 'folder', 'fileManager');
        $folder = $folderMapper->searchByPath('root/avatars');

        if ($validator->validate()) {
            $fileMapper = $this->toolkit->getMapper('fileManager', 'file', 'fileManager');


            $signature = $this->request->getString('signature', SC_POST);

            $profile->setSignature($signature);
            $profile->setUrl($this->request->getString('url', SC_POST));
            $profile->setIcq($this->request->getString('icq', SC_POST));
            $profile->setLocation($this->request->getString('location', SC_POST));
            $profile->setSignature($signature);

            if ($this->request->getBoolean('delete_avatar', SC_POST)) {
                if ($avatar = $profile->getAvatar()) {
                    $fileMapper->delete($avatar);
                    $profile->setAvatar(0);
                    $avatar_deleted = true;
                }
            }

            if ($avatarUploaded && !isset($avatar_deleted)) {
                if ($avatar = $profile->getAvatar()) {
                    $fileMapper->delete($avatar);
                }
                $storageMapper = $this->toolkit->getMapper('fileManager', 'storage', 'fileManager');
                $storage = $storageMapper->searchByKey(2); // @todo how to get the storage?
                $folder->setStorage($storage);
                $file = $folder->upload('avatar');
                $fileMapper->save($file);
                $file->setName('avatar_' . $profile->getId() . '.' . $file->getExt());
                $file->setRightHeader(1);
                $file->setDirectLink(1);
                $fileMapper->save($file);
                $profile->setAvatar($file->getId());
            }
            $profileMapper->save($profile);

            $url = new url('withId');
            $url->setAction('profile');
            $url->add('id', $id);
            return $this->redirect($url->get());
        }

        $this->smarty->assign('profile', $profile);
        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('folder', $folder);
        $this->smarty->assign('errors', $validator->getErrors());
        return $this->smarty->fetch('forum/saveProfile.tpl');
    }
}

?>