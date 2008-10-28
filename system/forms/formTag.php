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
 * formTag: основный тег формы - form
 * В качестве аргументов может принимать:
 *  - jip: при установке в true форма будет отправлена средствами AJAX.
 *         Используется только в JIP-окнах.
 *  - ajaxUpload: загрузка файлов с эмуляцией AJAX. Допустима только одна форма загрузки на странице
 *    Значение аргумента является уникальным в пределах всего проекта буквенным идентификатором формы.
 *    Примечание: кнопка submit (отправляющая форму на сервер) должна иметь идентификатор <уникальный ид. формы>UploadSubmitButton
 *    Например, если ajaxUpload="fm", то у элемента submit id="fmUploadSubmitButton"
 *
 * @package system
 * @subpackage forms
 * @version 0.2
 */
class formTag extends formElement
{
    static public function toString($options = array())
    {
        $smarty = systemToolkit::getInstance()->getSmarty();

        $html = '';
        if (isset($options['jip']) && $options['jip']) {
            $onsubmit = "return jipWindow.sendForm(this);";
            if (isset($options['onsubmit'])) {
                $options['onsubmit'] .= '; ' . $onsubmit;
            } else {
                $options['onsubmit'] = $onsubmit;
            }
            unset($options['jip']);
        } elseif (array_key_exists('ajaxUpload', $options)) {
            if (empty($options['ajaxUpload'])) {
                $options['ajaxUpload'] = 'mzz';
            } else {
                $options['ajaxUpload'] = preg_replace('/[^a-z0-9_-]/i', '_', trim($options['ajaxUpload']));
            }
            $onsubmit = "mzzReadUploadStatus('" . $options['ajaxUpload'] . "');";
            if (isset($options['onsubmit'])) {
                $options['onsubmit'] .= '; ' . $onsubmit;
            } else {
                $options['onsubmit'] = $onsubmit;
            }
            $options['enctype'] = "multipart/form-data";
            $options['target'] = $options['ajaxUpload'] . "UploadFile";
            $smarty->assign('name', $options['ajaxUpload']);
            $html = $smarty->fetch('forms/upload.tpl');
        }

        $csrf = null;
        /* данная опция отключает только добавление hidden-поля. Сама проверка отключается только через валидатор */
        if (!(array_key_exists('csrf', $options) && $options['csrf'] == false)) {
            /* In XHTML Strict forms may not contain inline elements as direct children */
            $csrf = '<div>' . self::getCSRFProtection() . '</div>';
        }

        if (array_key_exists('csrf', $options)) {
            unset($options['csrf']);
        }

        return $html . self::createTag($options, 'form') . $csrf;
    }

    /**
     * Генерирует случайный идентификатор для CSRF-проверки формы и устанавливает
     * валидатор на проверку того, что от пользователя пришел правильный идентификатор
     *
     */
    protected function getCSRFProtection()
    {
        $session = systemToolkit::getInstance()->getSession();
        if (!($token = $session->get('CSRFToken'))) {
            $token = self::getCSRFToken();
            $session->set('CSRFToken', $token);
        }
        return self::createTag(array('type' => 'hidden', 'name' => form::$CSRFField, 'value' => $token), 'input');
    }

    /**
     * Генерирует случайный идентификатор для CSRF-проверки формы
     *
     * @return string
     */
    static protected function getCSRFToken()
    {
        return md5(microtime(true) . rand());
    }

}

?>