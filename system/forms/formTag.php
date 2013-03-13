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
    public function __construct()
    {
        $this->setAttribute('name', null);
        $this->addOptions(array('jip', 'ajaxUpload', 'csrf', 'multipart'));
    }

    public function render($attributes = array(), $value = null)
    {
        $html = '';
        if (isset($attributes['jip']) && $attributes['jip']) {
            $attributes = $this->addJipSend($attributes);
        } elseif (array_key_exists('ajaxUpload', $attributes)) {
            $html = $this->addAjaxUpload($attributes);
        }

        $csrf = null;
        /* данная опция отключает только добавление hidden-поля. Сама проверка отключается только через валидатор */
        if (!isset($attributes['csrf']) || $attributes['csrf'] != false) {
            /* In the XHTML Strict mode forms may not contain inline elements as direct children */
            $csrf = $this->getCSRFProtection();
            if (form::isXhtml()) {
                $csrf = '<div>' . $csrf . '</div>';
            }
        }

        if (isset($attributes['multipart'])) {
            $attributes['enctype'] = 'multipart/form-data';
        }

        return $html . $this->renderTag('form', $attributes) . $csrf;
    }

    /**
     * Генерирует случайный идентификатор для CSRF-проверки формы и устанавливает
     * валидатор на проверку того, что от пользователя пришел правильный идентификатор
     *
     */
    protected function getCSRFProtection()
    {
        $token = form::getCSRFToken();
        return $this->renderTag('input', array('id' => '', 'type' => 'hidden', 'name' => form::getCSRFFieldName(), 'value' => $token));
    }

    protected function addAjaxUpload(&$attributes)
    {
        $view = systemToolkit::getInstance()->getView('smarty');

        if (empty($attributes['ajaxUpload'])) {
            $attributes['ajaxUpload'] = 'mzz';
        } else {
            $attributes['ajaxUpload'] = preg_replace('/[^a-z0-9_-]/i', '_', trim($attributes['ajaxUpload']));
        }
        $onsubmit = "mzzReadUploadStatus('" . $attributes['ajaxUpload'] . "');";
        if (isset($attributes['onsubmit'])) {
            $attributes['onsubmit'] .= '; ' . $onsubmit;
        } else {
            $attributes['onsubmit'] = $onsubmit;
        }
        $attributes['multipart'] = true;
        $attributes['target'] = $attributes['ajaxUpload'] . "UploadFile";
        $view->assign('name', $attributes['ajaxUpload']);
        return $view->render('forms/upload.tpl');
    }

    protected function addJipSend($attributes)
    {
        $onsubmit = "return jipWindow.sendForm(this);";
        if (isset($attributes['onsubmit'])) {
            $attributes['onsubmit'] .= '; ' . $onsubmit;
        } else {
            $attributes['onsubmit'] = $onsubmit;
        }
        return $attributes;
    }

}

?>