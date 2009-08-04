<?php

class identityMap
{
    private $objects = array();

    private $delayed = array();

    /**
     * @var mapper
     */
    private $mapper;

    public function __construct(mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function set($id, entity $object)
    {
    	$this->objects[$id] = $object;
    }

    public function get($id)
    {
        if (!is_scalar($id)) {
            return;
        }

        $this->loadDelayed();

    	if ($this->exists($id)) {
    	    return $this->objects[$id];
    	}
    }

    public function exists($id)
    {
        return isset($this->objects[$id]);
    }

    public function delay($id)
    {
        if (!$this->exists($id)) {
            $this->delayed[] = $id;
        }
    }

    public function loadDelayed()
    {
        if ($this->delayed) {
            $delayed = $this->delayed;
            $this->delayed = array();
            $this->mapper->searchByKey($delayed);
        }
    }
}

?>