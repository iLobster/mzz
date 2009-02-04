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

class utf8IconvCharset extends utf8Charset
{
    public function strlen($str)
    {
        return iconv_strlen($str, 'UTF-8');
    }

    public function strpos($str, $search, $offset = null)
    {
        if (is_null($offset)) {
            $old_enc = $this->setUTF8IconvEncoding();
            $result = iconv_strpos($str, $search);
            $this->setIconvEncoding($old_enc);
            return $result;
        } else {
            return iconv_strpos($str, $search, (int)$offset, 'UTF-8');
        }
    }

    public function strrpos($str, $search, $offset = null)
    {
        if (is_null($offset)) {
            $old_enc = $this->setUTF8IconvEncoding();
            $result = iconv_strrpos($str, $search);
            $this->setIconvEncoding($old_enc);
            return $result;
        } else {
            return parent::strrpos($str, $search, (int)$offset);
        }
    }

    public function substr($str, $offset, $length = null)
    {
        if (is_null($length)) {
            $old_enc = $this->setUTF8IconvEncoding();
            $result = iconv_substr($str, (int)$offset);
            $this->setIconvEncoding($old_enc);
            return $result;
        } else {
            return iconv_substr($str, (int)$offset, (int)$length, 'UTF-8');
        }
    }

    protected function setIconvEncoding($arr)
    {
        foreach ($arr as $type => $enc) {
            iconv_set_encoding($type, $enc);
        }
    }

    protected function setUTF8IconvEncoding()
    {
        $old = iconv_get_encoding();
        $this->setIconvEncoding(array('input_encoding' => 'UTF-8',
        'output_encoding' => 'UTF-8',
        'internal_encoding' => 'UTF-8'));
        return $old;
    }
}

?>