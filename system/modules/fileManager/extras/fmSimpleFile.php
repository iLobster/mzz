<?php
class fmSimpleFile
{
    protected $file = null;

    public function __construct(file $file)
    {
        $this->file = $file;
    }

    protected function getHash()
    {
        return md5($this->file->getId() . $this->file->getRealname());
    }

    public function delete() {}
}
?>