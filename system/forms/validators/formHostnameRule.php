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
 * formHostnameRule: правило, проверяющее имя хоста
 *
 * @package system
 * @subpackage forms
 * @version 0.1.1
 */
class formHostnameRule extends formAbstractRule
{
    private $validTlds = array(
    'ac', 'ad', 'ae', 'aero', 'af', 'ag', 'ai', 'al', 'am', 'an', 'ao',
    'aq', 'ar', 'arpa', 'as', 'at', 'au', 'aw', 'ax', 'az', 'ba', 'bb',
    'bd', 'be', 'bf', 'bg', 'bh', 'bi', 'biz', 'bj', 'bm', 'bn', 'bo',
    'br', 'bs', 'bt', 'bv', 'bw', 'by', 'bz', 'ca', 'cat', 'cc', 'cd',
    'cf', 'cg', 'ch', 'ci', 'ck', 'cl', 'cm', 'cn', 'co', 'com', 'coop',
    'cr', 'cu', 'cv', 'cx', 'cy', 'cz', 'de', 'dj', 'dk', 'dm', 'do',
    'dz', 'ec', 'edu', 'ee', 'eg', 'er', 'es', 'et', 'eu', 'fi', 'fj',
    'fk', 'fm', 'fo', 'fr', 'ga', 'gb', 'gd', 'ge', 'gf', 'gg', 'gh',
    'gi', 'gl', 'gm', 'gn', 'gov', 'gp', 'gq', 'gr', 'gs', 'gt', 'gu',
    'gw', 'gy', 'hk', 'hm', 'hn', 'hr', 'ht', 'hu', 'id', 'ie', 'il',
    'im', 'in', 'info', 'int', 'io', 'iq', 'ir', 'is', 'it', 'je', 'jm',
    'jo', 'jobs', 'jp', 'ke', 'kg', 'kh', 'ki', 'km', 'kn', 'kr', 'kw',
    'ky', 'kz', 'la', 'lb', 'lc', 'li', 'lk', 'lr', 'ls', 'lt', 'lu',
    'lv', 'ly', 'ma', 'mc', 'md', 'mg', 'mh', 'mil', 'mk', 'ml', 'mm',
    'mn', 'mo', 'mobi', 'mp', 'mq', 'mr', 'ms', 'mt', 'mu', 'museum', 'mv',
    'mw', 'mx', 'my', 'mz', 'na', 'name', 'nc', 'ne', 'net', 'nf', 'ng',
    'ni', 'nl', 'no', 'np', 'nr', 'nu', 'nz', 'om', 'org', 'pa', 'pe',
    'pf', 'pg', 'ph', 'pk', 'pl', 'pm', 'pn', 'pr', 'pro', 'ps', 'pt',
    'pw', 'py', 'qa', 're', 'ro', 'ru', 'rw', 'sa', 'sb', 'sc', 'sd',
    'se', 'sg', 'sh', 'si', 'sj', 'sk', 'sl', 'sm', 'sn', 'so', 'sr',
    'st', 'su', 'sv', 'sy', 'sz', 'tc', 'td', 'tf', 'tg', 'th', 'tj',
    'tk', 'tl', 'tm', 'tn', 'to', 'tp', 'tr', 'travel', 'tt', 'tv', 'tw',
    'tz', 'ua', 'ug', 'uk', 'um', 'us', 'uy', 'uz', 'va', 'vc', 've',
    'vg', 'vi', 'vn', 'vu', 'wf', 'ws', 'ye', 'yt', 'yu', 'za', 'zm',
    'zw'
    );

    protected function _validate($value)
    {
        if (preg_match('#^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$#', $value)) {
            return true;
        }

        $domainParts = explode('.', $value);

        if (sizeof($domainParts) < 2) {
            return false;
        }

        if (strlen($value) > 254 || strlen($value) < 4) {
            return false;
        }

        $tld = array_pop($domainParts);

        if (!in_array(strtolower($tld), $this->validTlds)) {
            return false;
        }

        $validChars = 'a-z0-9\-';
        foreach ($domainParts as $part) {
            if (strpos($part, '-') === 0 || (strlen($part) > 3 && strpos($part, '--', 2) === 2) || substr($part, -1) === '-') {
                return false;
            }

            if (!preg_match('#^[' . $validChars . ']{1,63}$#i', $part)) {
                return false;
            }
        }

        return true;
    }
}

?>