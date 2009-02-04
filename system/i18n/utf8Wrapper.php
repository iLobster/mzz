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

$toolkit = systemToolkit::getInstance();

/**
 * UTF-8 aware alternative to substr()
 */
function mzz_strlen($str)
{
    return $GLOBALS['toolkit']->getCharsetDriver()->strlen($str);
}

/**
 * UTF-8 aware alternative to substr()
 */
function mzz_substr($str, $start, $length = null)
{
    return $GLOBALS['toolkit']->getCharsetDriver()->substr($str, $start, $length);
}

/**
 * UTF-8 aware alternative to str_replace()
 */
function mzz_str_replace($str, $repl, $str)
{
    return $GLOBALS['toolkit']->getCharsetDriver()->str_replace($str, $repl, $str);
}

/**
 * UTF-8 aware alternative to ltrim()
 */
function mzz_ltrim($str, $charlist = '')
{
    return $GLOBALS['toolkit']->getCharsetDriver()->ltrim($str, $charlist);
}

/**
 * UTF-8 aware alternative to ltrim()
 */
function mzz_rtrim($str, $charlist = '')
{
    return $GLOBALS['toolkit']->getCharsetDriver()->rtrim($str, $charlist);
}

/**
 * UTF-8 aware alternative to trim()
 */
function mzz_trim($str, $charlist = '')
{
    if($charlist == '') {
        return $GLOBALS['toolkit']->getCharsetDriver()->trim($str);
    } else {
        return $GLOBALS['toolkit']->getCharsetDriver()->trim($str, $charlist);
    }
}

/**
 * UTF-8 aware alternative to strtolower()
 */
function mzz_strtolower($str)
{
    return $GLOBALS['toolkit']->getCharsetDriver()->strtolower($str);
}

/**
 * UTF-8 aware alternative to strtoupper()
 */
function mzz_strtoupper($str)
{
    return $GLOBALS['toolkit']->getCharsetDriver()->strtoupper($str);
}

/**
 * UTF-8 aware alternative to strpos
 */
function mzz_strpos($haystack, $needle, $offset = null)
{
    return $GLOBALS['toolkit']->getCharsetDriver()->strpos($haystack, $needle, $offset);
}

/**
 * UTF-8 aware alternative to strrpos
 */
function mzz_strrpos($haystack, $needle, $offset = null)
{
    return $GLOBALS['toolkit']->getCharsetDriver()->strrpos($haystack, $needle, $offset);
}

/**
 * UTF-8 aware alternative to ucfirst
 */
function mzz_ucfirst($str)
{
    return $GLOBALS['toolkit']->getCharsetDriver()->ucfirst($str);
}

/*
 * UTF-8 aware alternative to strcasecmp
 */
function mzz_strcasecmp($strX, $strY)
{
    return $GLOBALS['toolkit']->getCharsetDriver()->strcasecmp($strX, $strY);
}

/**
 * UTF-8 aware alternative to substr_count
 */
function mzz_substr_count($haystack, $needle)
{
    return $GLOBALS['toolkit']->getCharsetDriver()->substr_count($haystack, $needle);
}

/**
 * UTF-8 aware alternative to str_split
 */
function mzz_str_split($str, $split_len = 1)
{
    return $GLOBALS['toolkit']->getCharsetDriver()->str_split($str, $split_len);
}

?>