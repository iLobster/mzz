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
 * mzzCacheFilterIterator: ������� Iterator ��� "�������" ������ � ��������� 'cache_'
 *
 * @package system
 * @version 0.1
 */
class mzzCacheFilterIterator extends FilterIterator
{

    /**
     * ���������� true ���� ������� ������� ���� � ����� ������� cache_
     *
     * @return boolean
     */
    public function accept()
    {
        return $this->isFile() && (substr($this->getFilename(), 0, 6) == 'cache_');
    }

}

?>