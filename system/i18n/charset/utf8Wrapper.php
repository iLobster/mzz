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

$GLOBALS['charsetDriver'] = systemToolkit::getInstance()->getCharsetDriver();

/**
 * UTF-8 aware alternative to substr()
 */
function mzz_strlen($str)
{
    return $GLOBALS['charsetDriver']->strlen($str);
}

/**
 * UTF-8 aware alternative to substr()
 */
function mzz_substr($str, $start, $length = null)
{
    return $GLOBALS['charsetDriver']->substr($str, $start, $length);
}

/**
 * UTF-8 aware alternative to str_replace()
 */
function mzz_str_replace($search, $repl, $str)
{
    return $GLOBALS['charsetDriver']->str_replace($search, $repl, $str);
}

/**
 * UTF-8 aware alternative to ltrim()
 */
function mzz_ltrim($str, $charlist = '')
{
    return $GLOBALS['charsetDriver']->ltrim($str, $charlist);
}

/**
 * UTF-8 aware alternative to ltrim()
 */
function mzz_rtrim($str, $charlist = '')
{
    return $GLOBALS['charsetDriver']->rtrim($str, $charlist);
}

/**
 * UTF-8 aware alternative to trim()
 */
function mzz_trim($str, $charlist = '')
{
    if($charlist == '') {
        return $GLOBALS['charsetDriver']->trim($str);
    } else {
        return $GLOBALS['charsetDriver']->trim($str, $charlist);
    }
}

/**
 * UTF-8 aware alternative to strtolower()
 */
function mzz_strtolower($str)
{
    return $GLOBALS['charsetDriver']->strtolower($str);
}

/**
 * UTF-8 aware alternative to strtoupper()
 */
function mzz_strtoupper($str)
{
    return $GLOBALS['charsetDriver']->strtoupper($str);
}

/**
 * UTF-8 aware alternative to strpos
 */
function mzz_strpos($haystack, $needle, $offset = null)
{
    return $GLOBALS['charsetDriver']->strpos($haystack, $needle, $offset);
}

/**
 * UTF-8 aware alternative to strrpos
 */
function mzz_strrpos($haystack, $needle, $offset = null)
{
    return $GLOBALS['charsetDriver']->strrpos($haystack, $needle, $offset);
}

/**
 * UTF-8 aware alternative to ucfirst
 */
function mzz_ucfirst($str)
{
    return $GLOBALS['charsetDriver']->ucfirst($str);
}

/*
 * UTF-8 aware alternative to strcasecmp
 */
function mzz_strcasecmp($strX, $strY)
{
    return $GLOBALS['charsetDriver']->strcasecmp($strX, $strY);
}

/**
 * UTF-8 aware alternative to substr_count
 */
function mzz_substr_count($haystack, $needle)
{
    return $GLOBALS['charsetDriver']->substr_count($haystack, $needle);
}

/**
 * UTF-8 aware alternative to str_split
 */
function mzz_str_split($str, $split_len = 1)
{
    return $GLOBALS['charsetDriver']->str_split($str, $split_len);
}

?>