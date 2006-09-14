<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

/**
 * news: news
 *
 * @package news
 * @version 0.1.1
 */

class news extends simple
{
    /**
     * ��������� ������� JIP
     *
     * @return jip
     */
    public function getJip()
    {
        return parent::getJipView('news', $this->getId(), 'news');
    }

    /**
     * ��������� ����� ���������� ������������� �������
     *
     * @return string
     */
    /*public function getEditor()
    {
        if ($this->fields->exists('editor')) {
            // ������� �������� ��� ������ ������ ���������. � ��������� ������ ������ �������.
            if (is_numeric($this->fields->get('editor'))) {
                $userMapper = new userMapper('user');
                $user = $userMapper->searchById($this->fields->get('editor'));
                $this->fields->set('editor', $user);
            }
            return $this->fields->get('editor');
        } else {
            return null;
        }
    }*/

    /**
     * ��������� ����� �����, � ������� ��������� �������
     *
     * @return string
     */
    public function getFolderName()
    {
        fileLoader::load("news/mappers/newsFolderMapper");
        fileLoader::load('news/newsFolder');
        $newsFolderMapper = new newsFolderMapper('news');
        $folderName = $newsFolderMapper->searchOneByField('id', $this->fields->get('folder_id'));

        return $folderName->getName();

    }


}

?>