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
 * @package system
 * @subpackage request
 * @version $Id$
*/

fileLoader::load('i18n/charset/utf8Charset');

class utf8MbstringCharset extends utf8Charset
{
    public function strlen($str)
    {
        return mb_strlen($str, 'UTF-8');
    }

    public function strtolower($str)
    {
        return mb_strtolower($str, 'UTF-8');
    }

    public function strtoupper($str)
    {
        return mb_strtoupper($str, 'UTF-8');
    }

    public function substr($str, $start, $length = null)
    {
        if (is_null($length)) {
            return $this->changeEncAndCallFunc('mb_substr', array($str, (int)$start));
        } else {
            return mb_substr($str, (int)$start, (int)$length, 'UTF-8');
        }
    }

    public function strpos($haystack, $needle, $offset = null)
    {
        if (is_null($offset)) {
            return $this->changeEncAndCallFunc('mb_strpos', array($haystack, $needle));
        } else {
            return mb_strpos($haystack, $needle, (int)$offset, 'UTF-8');
        }
    }

    public function strrpos($haystack, $needle, $offset = null)
    {
        if (is_null($offset)) {
            return $this->changeEncAndCallFunc('mb_strrpos', array($haystack, $needle));
        } else {
            return parent::strrpos($haystack, $needle, (int)$offset);
        }
    }

    protected function changeEncAndCallFunc($func, $args)
    {
        $old = mb_internal_encoding();
        mb_internal_encoding('UTF-8');
        $result = $func($args[0], $args[1]);
        if ($old) {
            mb_internal_encoding($old);
        }
        return $result;
    }
}

?>