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
 * commentsFolderListController: ���������� ��� ������ list ������ comments
 *
 * @package modules
 * @subpackage comments
 * @version 0.1
 */

fileLoader::load('comments/views/commentsFolderListView');

class commentsFolderListController extends simpleController
{
    public function getView()
    {
        return new commentsFolderListView();
    }
}

?>