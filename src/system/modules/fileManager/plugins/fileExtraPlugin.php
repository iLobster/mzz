<?php

fileLoader::load('modules/fileManager/extras/fmSimpleFile');

class fileExtraPlugin extends observer
{
    protected $extras = array('jpg' => 'image',
                              'jpeg' => 'image',
                              'png' => 'image',
                              'gif' => 'image');

    protected function updateMap(& $map)
    {
        $map['file_extra'] = array(
            'accessor' => 'getExtra',
            'options' => array(
                'fake',
                'ro'));

        $map['file_type'] = array(
            'accessor' => 'getType',
            'options' => array(
                'fake',
                'ro'));

        $map['file_mime'] = array(
            'accessor' => 'getMimeType',
            'options' => array(
                'fake',
                'ro'));
    }

    public function postCreate(entity $object)
    {
        $tmp = array();
        $mimes = $this->mapper->getMimeTypes();
        $tmp['file_extra'] = new lazy(array($this,'getExtra',array($object)));

        $tmp['file_type'] = isset($this->extras[$object->getExt()]) ? $this->extras[$object->getExt()] : 'simple';
        $tmp['file_mime'] = isset($mimes[$object->getExt()]) ? $mimes[$object->getExt()] : 'application/octet-stream';

        $object->merge($tmp);
    }

    public function preDelete(entity $object) {
        $object->getExtra()->delete();
    }
    
    public function getExtra(entity $object)
    {
        $extra = null;

        try {
            $extra_class = 'fm' . ucfirst($object->getType()) . 'File';
            fileLoader::load('modules/fileManager/extras/' . $extra_class);
            $extra = new $extra_class($object);
        } catch(exception $e) {
            $extra = new fmSimpleFile($object);
        }

        return $extra;
    }
}
?>
