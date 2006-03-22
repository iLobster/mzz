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
 * iResolver: ��������� ���������
 *
 * @package system
 * @version 0.1
 */
interface iResolver
{

    /**
     * ������ �������� ������ ����� �� ���������
     *
     * @param string $request ��������� ������
     * @return string|null ���� �� �����, ���� ������ � null � ��������� ������
     */
    public function resolve($request);
}

?>