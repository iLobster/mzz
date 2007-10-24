<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/codegenerator/templates/controller.tpl $
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.tpl 1790 2007-06-07 09:48:45Z mz $
 */

fileLoader::load('forms/validators/formValidator');

/**
 * tagsEditTagsController: ���������� ��� ������ addTags ������ tags
 *
 * @package modules
 * @subpackage tags
 * @version 0.1
 */

class tagsEditTagsController extends simpleController
{
    public function getView()
    {
        $obj_id = $this->request->get('id', 'integer', SC_PATH);

        $tagsItemMapper = $this->toolkit->getMapper('tags', 'tagsItem', 'tags');
        $tagsItem = $tagsItemMapper->searchOneByField('item_obj_id', $obj_id);

        $action = $this->request->getAction();
        $isEdit = ($action == 'edit');
        //$news = ($isEdit) ? $newsMapper->searchById($id) : $newsMapper->create();

        if(!empty($tagsItem)) {

            $validator = new formValidator();

            if ($validator->validate()) {

                $tags = $this->request->get('tags', 'string', SC_POST);
                /* ������ ���� */
                $tags = explode(',', $tags);
                $tags = array_map('trim', $tags);
                foreach ($tags as $i => $t) {
                    if(strlen($t) == 0) {
                        unset($tags[$i]);
                    }
                }

                $tagsPlainLowString = array_map('strtolower', $tags);
                $tagsMapper = $this->toolkit->getMapper('tags', 'tags', 'tags');
                $tagsItemRelMapper = $this->toolkit->getMapper('tags', 'tagsItemRel', 'tags');

                /* ����������� ��� ���� � ���� iPod, ����� ipod, IPOD, ����������� ��� iPod */

                $existedTags = $tagsMapper->searchTags($tags);

                $existedTagsPlain = $newInBaseTagsPlain = $newTagsPlain = $currentTagsPlain = $deletedTagsPlain = array();
                $newInBaseTags = $newTags = array();

                // ��������� ����� ����, ������� ��� � ����
                if(!empty($existedTags)) {

                    // ������� ������ � ������ ��������
                    foreach ($existedTags as $t) {
                        $existedTagsPlain[] = $t->getTag();
                    }

                    // ��� ������ ����� ����� ��������� �� ������ �������
                    $existedTagsPlainLowString = array_map('strtolower', $existedTagsPlain);

                    // ��������� ����� ����
                    foreach ($tagsPlainLowString as $i => $t) {
                        if(!in_array($t, $existedTagsPlainLowString)) {
                            $newInBaseTagsPlain[] = $tags[$i];
                        }
                    }
                } else {
                    // ��� ���� �����
                    $newInBaseTagsPlain = $tags;
                }

                // ������� ������ � �������� ������ ��������
                $currentTags = $tagsItem->getTags();
                foreach ($currentTags as $t) {
                    $currentTagsPlain[] = $t->getTag();
                }

                // ��������� ��������� ����
                // @2think � ��� ���������� ������������?
                // ����� ��� ������ �������� ������������
                $currentTagsPlainLowString = array_map('strtolower', $currentTagsPlain);
                foreach ($currentTagsPlainLowString as $i => $t) {
                    if(!in_array($t, $tagsPlainLowString)) {
                        $deletedTagsPlain[] = $currentTagsPlain[$i];
                    }
                }

                // ����� ��� ������� ����
                $newTagsPlainLowString = array_diff($tagsPlainLowString, $currentTagsPlainLowString);
                foreach(array_keys($newTagsPlainLowString) as $key) {
                    $newTagsPlain[$key] = $tags[$key];
                }

                // ������� ����� ��� ���� ����
                if(!empty($newInBaseTagsPlain)) {
                    $newInBaseTags = $tagsMapper->createTags($newInBaseTagsPlain);
                }

                // ���� ����� ��� ������� ���� � ��������� �� � �������
                $newTags = array();
                if(!empty($newTagsPlain)) {
                    foreach ($existedTags as $key => $t) {
                        if(in_array(strtolower($t->getTag()), $newTagsPlainLowString)) {
                            $newTags[$key] = $t;
                        }
                    }
                }

                $currentUser = $this->toolkit->getUser();


                // ����� ���� = $newInBaseTags + $newTags
                // ��������� ���� � ���������
                $allNewTags = array_merge($newInBaseTags, $newTags);
                foreach ($allNewTags as $tag) {
                    $tagItemRel = $tagsItemRelMapper->create();
                    $tagItemRel->setTag($tag);
                    $tagItemRel->setItem($tagsItem);
                    $tagsItemRelMapper->save($tagItemRel);
                }

                // ��������� ��������� ����
                // ������� �����
                $currentTagsKeys = array_keys($currentTags);
                $existedTagsKeys = array_keys($existedTags);
                $deletedTagsKeys = array_diff($currentTagsKeys, $existedTagsKeys);

                // @todo �������� � ������, ����� �����. ��� �������, ��� �������?

                if(!empty($deletedTagsKeys)) {
                    foreach($deletedTagsKeys as $key) {
                        $tagsItemRelMapper->deleteByTagAndItem($key, $tagsItem);
                    }
                }

                // @toDo �� ��������� ��� ��������, ��������� ������ ����
                //exit;
                return jipTools::redirect();
            }

            $url = new url('withId');
            $url->setAction($action);
            $url->add('id', $obj_id);

            //echo"<pre>";var_dump($url->get());echo"</pre>";

            $tags = $tagsItem->getTags();
            if(!empty($tags)) {
                foreach($tags as $tag) {
                    $tmp[] = $tag->getTag();
                }

                $tags_string = implode(', ', $tmp);
            } else {
                $tags_string = '';
            }
            $this->smarty->assign('tags', $tags_string);
            $this->smarty->assign('action', $url->get());

            return $this->smarty->fetch('tags/editTags.tpl');
        }

        return $tagsItemMapper->get404()->run();


    }
}

?>