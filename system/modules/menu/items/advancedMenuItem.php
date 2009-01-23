<?php
class advancedMenuItem extends menuItem
{
    protected $url = null;

    public function getUrl()
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
                $requestPath = $request->getPath();

                //отрезаем из урла lang
                if ($this->urlLangSpecified) {
                    $requestPath = preg_replace('!^' . $this->urlLang . '/!siU', '/', $requestPath);
                    //$parts = explode('/', $requestPath);
                    //$lang = array_shift($parts);
                    //$requestPath = implode('/', $parts);
                }

                $this->isActive = preg_match($this->getActiveRegExp(), $request->getPath());
            } else {
                $url = $request->getUrl() . $this->getUrl();
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
        $arguments = clone $this->getArguments();
        $arguments->delete('route');
        $arguments->delete('regexp');
        return $arguments->export();
    }

    public function getActiveRoutes()
    {
        return array();
    }
}
?>