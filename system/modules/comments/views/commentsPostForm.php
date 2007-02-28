<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * commentsPostForm: ����� ��� ������ post ������ comments
 *
 * @package modules
 * @subpackage comments
 * @version 0.1
 */
class commentsPostForm
{
    static function getForm($parent_id, $action = 'post', $comment = null)
    {
        fileLoader::load('libs/PEAR/HTML/QuickForm');
        fileLoader::load('libs/PEAR/HTML/QuickForm/Renderer/ArraySmarty');

        $url = new url('withId');
        $url->setAction($action);
        $url->addParam('id', $parent_id);

        $form = new HTML_QuickForm('post', 'POST', $url->get());

        if ($action == 'edit') {
            $defaultValues = array();
            $defaultValues['text']  = $comment->getText();
            $form->setDefaults($defaultValues);
        }

        $form->addElement('textarea', 'text', '��� �����������', 'rows=7 cols=50');

        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();

        $form->addElement('hidden', 'url', $request->get('REQUEST_URI', 'string', SC_SERVER));

        $form->addElement('reset', 'reset', '������', 'onclick="javascript: jipWindow.close();"');
        $form->addElement('submit', 'submit', '���������');

        return $form;
    }
}

?>