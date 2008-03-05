<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * mailer: класс для отправки сообщений по электронной почте
 *
 * @package system
 * @subpackage service
 * @version 0.1
 */
class mailer
{
    protected $nativeMail = null;

    /**
     * Отправляет письмо как plain-text (обычный текст)
     *
     * @param array|string $recipients строка - получатель, массив - получатели
     * @param string $sender отправитель
     * @param string $subject тема
     * @param string $body содержание
     * @param string $charset кодировк
     * @return boolean результат операции отправки
     */
    public function sendPlain($recipients, $sender, $subject, $body, $charset = 'utf-8')
    {
        $mailer = $this->createMailer();
        $mailer->IsHTML(false);

        $recipients = $this->prepareAddresses($recipients);

        foreach ($recipients as $recipient) {
            $mailer->AddAddress($recipient['address'], $recipient['name']);
        }

        if (!$sender = $this->prepareAddress($sender)) {
            return false;
        }

        $mailer->Subject = $subject;
        $mailer->Body = $body;
        $mailer->From = $sender['address'];
        $mailer->FromName = $sender['name'];
        $mailer->CharSet = $charset;

        return $mailer->Send();
    }

    /**
     * Отделение имени и mail-адреса в массиве
     *
     * @param array $addresses
     * @return array
     */
    protected function prepareAddresses($addresses)
    {
        $addresses = (array)$addresses;
        $result = array();
        foreach ($addresses as $address) {
            if ($address = $this->prepareAddress($address)) {
                $result[] = $address;
            }
        }
        return $result;
    }

    /**
     * Отделение имени и mail-адреса из строки
     * name <mail@example.com> -> array('address' =>'mail@example.com', 'name' => 'name')
     *
     * @param string $addresses
     * @return array
     */
    protected function prepareAddress($address)
    {
        if (is_array($address)) {
            if (isset($address['address']) && isset($address['name'])) {
                return $address;
            }
            return null;
        }

        if (preg_match('/(.*?)\s+<([^>]+)>/', $address, $matches)) {
            return array('address' => $matches[2], 'name' => $matches[1]);
        }

        return array('address' => $address, 'name' => '');
    }

    /**
     * Создание mailer класса
     *
     * @return object
     */
    protected function createMailer()
    {
        fileLoader::load('libs/phpmailer/class.phpmailer');
        $mailer = new PHPMailer();
        $mailer->setLE("\r\n");

        if ($this->nativeMail !== true && (!defined('USE_PHPMAIL') || USE_PHPMAIL == false)) {
            $mailer->IsSMTP();
            $mailer->Host = SMTP_HOST;
            $mailer->Port = SMTP_PORT;
            if(SMTP_AUTH == true) {
                $mailer->SMTPAuth = true;
                $mailer->Username = SMTP_USER;
                $mailer->Password = SMTP_PASSWORD;
            }
        }

        return $mailer;
    }

    /**
     * Устанавливает принудительную отправку через обычную PHP-функцию mail,
     * не смотря на настройку USE_PHPMAIL
     *
     */
    public function setByNativeMail()
    {
        $this->nativeMail = true;
    }
}

?>