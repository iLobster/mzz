<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/modules/catalogue/forms/catalogueMoveForm.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: catalogueMoveForm.php 1364 2007-03-02 20:53:58Z mz $
 */

/**
 * catalogueMoveForm: форма для метода move модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueMoveForm
{
    /**
     * метод получения формы
     *
     * @param object $file объект "файл"
     * @return object сгенерированная форма
     */
    static function getForm($news, $folders)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url('withId');
        $url->setAction('move');
        $url->addParam('id', $news->getId());
        $form = new HTML_QuickForm('newsMove', 'POST', $url->get());

        $defaultValues = array();
        $defaultValues['dest']  = $news->getFolder()->getId();
        $form->setDefaults($defaultValues);

        $dests = array();
        foreach ($folders as $val) {
            $dests[$val->getId()] = $val->getPath();
        }

        $select = $form->addElement('select', 'dest', 'Каталог назначения', $dests);
        $select->setSize(5);

        $form->addElement('reset', 'reset', 'Отмена', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', 'Сохранить');
        return $form;
    }
}

?>