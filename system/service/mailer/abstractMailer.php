<?php
abstract class abstractMailer
{
    protected $to;
    protected $toName;
    protected $from;
    protected $fromName;
    protected $subject;
    protected $body;

    public function set($to, $toName, $from, $fromName, $subject, $body)
    {
        $this->setTo($to);
        $this->setToName($toName);
        $this->setFrom($from);
        $this->setFromName($fromName);
        $this->setSubject($subject);
        $this->setBody($body);
    }

    public function setTo($to)
    {
        $this->to = $to;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function setToName($toName)
    {
        $this->toName = $toName;
    }

    public function getToName()
    {
        return $this->toName;
    }

    public function setFrom($from)
    {
        $this->from = $from;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function setFromName($fromName)
    {
        $this->fromName = $fromName;
    }

    public function getFromName()
    {
        return $this->fromName;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }

    abstract public function send();
}
?>