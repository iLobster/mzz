<?php
class externalMenuItem extends menuItem
{
    public function getUrl()
    {
        return $this->getArgument('url', '/');
    }

    public function isActive()
    {
        return false;
    }
}
?>