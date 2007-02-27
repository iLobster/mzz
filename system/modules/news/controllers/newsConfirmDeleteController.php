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
 * newsConfirmDeleteController: ���������� ��� ������������� �������� delete ������ news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */
class newsConfirmDeleteController extends simpleConfirmControllerDecorator
{
    protected $message = "�� ������ ������� ��� �������?";
    public function confirmed()
    {
        fileLoader::load('news/controllers/newsDeleteController');
        $controller = new newsDeleteController();
        return $controller->getView();
    }
}

?>