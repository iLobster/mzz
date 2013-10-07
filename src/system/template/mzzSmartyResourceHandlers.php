<?php
/**
 * MZZ Content Management System (c)
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 */

class mzzSmartyResourceFile extends Smarty_Internal_Resource_File {
    public $compiler_class = 'mzzSmartyCompiler';
}

class mzzSmartyResourceStream extends Smarty_Internal_Resource_Stream {
    public $compiler_class = 'mzzSmartyCompiler';
}

class mzzSmartyResourceString extends Smarty_Internal_Resource_String {
    public $compiler_class = 'mzzSmartyCompiler';
}