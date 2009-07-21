<?php
abstract class fmSimpleFile
{
    protected $file = null;

    public function __construct(file $file)
    {
        $this->file = $file;
    }

    public function delete()
    {
    }
}
?>