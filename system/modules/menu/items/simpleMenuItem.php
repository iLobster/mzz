<?php
class simpleMenuItem extends menuItem
{
    protected $isActive = null;

    public function getUrl($withLang = true, $startSlash = true)
    {
        $url = $this->getArgument('url', '');
        if ($withLang && $this->urlLangSpecified) {
            $url = $this->urlLang . '/' . $url;
        }

        return ($startSlash ? SITE_PATH . '/' : '') . $url;
    }

    public function isActive()
    {
        if (!is_bool($this->isActive)) {
            $toolkit = systemToolkit::getInstance();
            $request = $toolkit->getRequest();

            $url = $this->getUrl(false, false);

            $this->isActive = ($url == $this->stripLangFromUrl($request->getPath()));
        }

        return $this->isActive;
    }
}
?>