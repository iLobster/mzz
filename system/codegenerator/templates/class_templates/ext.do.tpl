<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/codegenerator/templates/do.tpl $
 *
 * MZZ Content Management System (c) {{"Y"|date}}
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: do.tpl 2182 2007-11-30 04:41:35Z zerkms $
 */

/**
 * {{$do_data.doname}}: класс для работы c данными
 *
 * @package modules
 * @subpackage {{$do_data.module}}
 * @version 0.1
 */

class {{$do_data.doname}} extends simple
{
    protected $name = '{{$do_data.module}}';

    // some changes
}

?>