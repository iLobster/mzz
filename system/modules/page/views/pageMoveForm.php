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
 * pageMoveForm: форма для метода move модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */

class pageMoveForm
{
    /**
     * метод получения формы
     *
     * @param object $file объект "файл"
     * @return object сгенерированная форма
     */
    static function getForm($page, $folders)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url('withAnyParam');
        $url->setAction('move');
        $url->addParam('name', $page->getFolder()->getPath() . '/' . $page->getName());
        $form = new HTML_QuickForm('pageMove', 'POST', $url->get());

        $defaultValues = array();
        $defaultValues['dest']  = $page->getFolder()->getId();
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