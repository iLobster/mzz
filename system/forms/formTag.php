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
 * formTag: �������� ��� ����� - form
 * � �������� ���������� ����� ���������:
 *  - jip: ��� ��������� � true ����� ����� ���������� ���������� AJAX.
 *         ������������ ������ � JIP-�����.
 *  - ajaxUpload: �������� ������ � ��������� AJAX. ��������� ������ ���� ����� �������� �� ��������
 *    �������� ��������� �������� ���������� � �������� ����� ������� ��������� ��������������� �����.
 *    ����������: ������ submit (������������ ����� �� ������) ������ ����� ������������� <���������� ��. �����>UploadSubmitButton
 *    ��������, ���� ajaxUpload="fm", �� � �������� submit id="fmUploadSubmitButton"
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formTag extends formElement
{
    static public function toString($options = array())
    {
        $html = '';
        if (isset($options['jip'])) {
            $onsubmit = "return jipWindow.sendForm(this);";
            if (isset($options['onsubmit'])) {
                $options['onsubmit'] .= '; ' . $onsubmit;
            } else {
                $options['onsubmit'] = $onsubmit;
            }
        } elseif (array_key_exists('ajaxUpload', $options)) {
            if (empty($options['ajaxUpload'])) {
                $options['ajaxUpload'] = 'mzz';
            }
            $options['ajaxUpload'] = preg_replace('/[^a-z0-9_-]/i', '_', trim($options['ajaxUpload']));
            $onsubmit = "mzzReadUploadStatus('" . $options['ajaxUpload'] . "');";
            if (isset($options['onsubmit'])) {
                $options['onsubmit'] .= '; ' . $onsubmit;
            } else {
                $options['onsubmit'] = $onsubmit;
            }
            $options['enctype'] = "multipart/form-data";
            $options['target'] = $options['ajaxUpload'] . "UploadFile";
            $html = '<iframe name="' . $options['ajaxUpload'] . 'UploadFile" id="' . $options['ajaxUpload'] . 'UploadFile" style="border: 0; width: 0; height: 0;" src="about:blank"></iframe>';
            $html .= '<div id="' . $options['ajaxUpload'] . 'UploadStatus" class="uploadSuccess"></div><div id="' . $options['ajaxUpload'] . 'UploadStatusError" class="uploadError"></div>';
            $html .= '<script type="text/javascript"> fileLoader.loadJS(SITE_PATH + "/templates/js/upload.js");';
            $html .= 'fileLoader.onJsLoad(function () { mzzResetUploadForm(\'' . $options['ajaxUpload'] . '\'); });</script>';
        }

        return $html . self::createTag($options, 'form');
    }
}

?>