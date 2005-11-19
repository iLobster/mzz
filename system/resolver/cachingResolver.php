<?php
final class cachingResolver extends decoratingResolver
{
    private $cache = array();
    private $cache_file;
    private $cached = true;
    public function __construct($resolver)
    {
        if(file_exists(TEMP_DIR . 'resolver.cache')) {
            $this->cache = unserialize(file_get_contents(TEMP_DIR . 'resolver.cache'));
        }
        $this->cache_file = new Fs(TEMP_DIR . 'resolver.cache','w');
        parent::__construct($resolver);
    }


    public function resolve($request)
    {
        if (!isset($this->cache[$request])) {
            $this->cache[$request] = $this->resolver->resolve($request);
        }
        return $this->cache[$request];
    }

    public function __destruct()
    {
        $this->cache_file->write(serialize($this->cache));
    }

}
?>