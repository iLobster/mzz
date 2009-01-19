<?php
class externalMenuItem extends menuItem
{
    public function getUrl()
    {
        $url = $this->getArgument('url');
        return $url;
    }

    public function isActive()
    {
        return false;
    }
}
?>