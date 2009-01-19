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

            $this->isActive = ($request->getUrl() . ($this->urlLangSpecified ? '/' . $this->urlLang : '') . $this->getUrl(false) == $request->getRequestUrl());
        }

        return $this->isActive;
    }
}
?>
