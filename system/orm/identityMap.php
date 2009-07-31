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

    	if (isset($this->objects[$id])) {
    	    return $this->objects[$id];
    	}
    }

    public function delay($id)
    {
        $this->delayed[] = $id;
    }

    private function loadDelayed()
    {
        if ($this->delayed) {
            $this->mapper->searchByKey($this->delayed);
            $this->delayed = array();
        }
    }
}

?>