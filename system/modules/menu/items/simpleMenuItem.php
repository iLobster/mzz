<?php
class simpleMenuItem extends menuItem
{
    public function getUrl($lang = true)
    {
        $lang = $lang ? $this->urlLang : null;
        $url = $this->getArgument('url', '');
        return ($lang ? '/' . $lang : '') . $url;
    }

    public function isActive()
    {
        if (!is_bool($this->isActive)) {
            $toolkit = systemToolkit::getInstance();
            $request = $toolkit->getRequest();
            $url = $this->getUrl(false);
            $url = ($this->urlLangSpecified && $url == '/' ? '' : $url);
            $this->isActive = ($request->getUrl() . ($this->urlLangSpecified ? '/' . $this->urlLang: '') . $url == $request->getRequestUrl());
        }

        return $this->isActive;
    }
}
?>
