<?php
abstract class fmSimpleFile
{
    protected $file = null;
    protected $mapper = null;

    public function __construct(file $file)
    {
        $this->file = $file;
        $this->mapper = $file->mapper();
    }
}
?>