<?php
class advancedMenuItem extends menuItem
{
    protected $url = null;

    public function getUrl($lang = true)
    {
        if (is_null($this->url)) {
            $route = $this->getRouteName();
            if ($route) {
                $url = new url($route);
                foreach ($this->getUrlArguments() as $key => $value) {
                    $url->add($key, $value);
                }

                $url->disableAddress();
                $this->url = $url->get();
            } else {
                $this->url = '';
            }
        }

        return $this->url;
    }

    public function isActive()
    {
        if (!is_bool($this->isActive)) {
            $toolkit = systemToolkit::getInstance();
            $request = $toolkit->getRequest();

            if ($this->getActiveRegExp()) {
                $this->isActive = preg_match($this->getActiveRegExp(), $request->getPath());
            } else {
                $url = $request->getUrl() . ($this->urlLangSpecified ? '/' . $this->urlLang : '') . '/' . $this->getUrl(false);
                $this->isActive = ($url == $request->getRequestUrl());
            }
        }

        return $this->isActive;
    }

    public function getRouteName()
    {
        return $this->getArgument('route');
    }

    public function getActiveRegExp()
    {
        return $this->getArgument('regexp');
    }

    protected function getUrlArguments()
    {
        $arguments = $this->getArguments();
        $arguments->delete('route');
        $arguments->delete('regexp');
        return $arguments->export();
    }
}
?>