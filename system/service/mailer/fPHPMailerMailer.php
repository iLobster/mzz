<?php
fileLoader::load('service/mailer/abstractMailer');
fileLoader::load('libs/phpmailer/class.phpmailer');

class fPHPMailerMailer extends abstractMailer
{
    protected $phpmailer;

    public function __construct(Array $params = array())
    {
        $phpmailer = new phpmailer;
        $phpmailer->CharSet = 'utf-8';

        if (isset($params['html']) && $params['html']) {
            $phpmailer->IsHtml(true);
        }

        if (isset($params['smtp']) && $params['smtp']) {
            $phpmailer->isSmtp();
            if (isset($params['smtp_host'])) {
                $phpmailer->Host = (string)$params['smtp_host'];
            }
            
            if (isset($params['smtp_port'])) {
                $phpmailer->Port = $params['smtp_port'];
            }
            
            if (isset($params['smtp_user']) && isset($params['smtp_pass'])) {
                $phpmailer->SMTPAuth = true;
                $phpmailer->Username = $params['smtp_user'];
                $phpmailer->Password = $params['smtp_pass'];
            }
            
            $phpmailer->SMTPDebug = (isset($params['smtp_debug']) && $params['smtp_debug']);
        }

        $this->phpmailer = $phpmailer;
    }

    public function send()
    {
        $this->phpmailer->From     = $this->getFrom();
        $this->phpmailer->FromName = $this->getFromName();

        $this->phpmailer->Subject  = $this->getSubject();
        $this->phpmailer->Body     = $this->getBody();
        $this->phpmailer->AltBody     = $this->getAltBody();

        $this->phpmailer->AddAddress($this->getTo(), $this->getToName());

        $result = $this->phpmailer->send();

        $this->phpmailer->ClearAddresses();
        $this->phpmailer->ClearAttachments();

        return $result;
    }
}
?>