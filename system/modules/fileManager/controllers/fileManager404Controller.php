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
 * fileManager404Controller: ���������� ��� ������ 404 ������ fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1
 */

class fileManager404Controller extends simpleController
{
    private $type;
    protected function __construct($type = 'file')
    {
        $this->type = $type;
        parent::__construct();
    }

    public function getView()
    {
        $this->response->setTitle('������. ������������� ���� ���� �� ������');
        $this->smarty->assign('type', $this->type);
        return $this->smarty->fetch('fileManager/notfound.tpl');
    }
}

?>