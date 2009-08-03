<?php
class fmImageFile extends fmSimpleFile
{
    protected $publicPath;

    public function __construct(file $file)
    {
        parent::__construct($file);

        $config = systemToolkit::getInstance()->getConfig('fileManager');
        $this->publicPath = $config->get('public_path');
    }

    public function getThumbnail($width = 80, $height = 60)
    {
        $thumbName = $this->getHash();
        $thumbNameFile = $thumbName . '_' . $width . 'x' . $height . '.' . $this->file->getExt();
        $path = $this->getThumbPath();
        $file = $path . DIRECTORY_SEPARATOR . $thumbNameFile;

        if (!is_file($file)) {
            if (in_array($ext = $this->file->getExt(), array('jpg', 'jpeg', 'png', 'gif'))) {
                if ($ext == 'jpg') {
                    $ext = 'jpeg';
                }
                $filename = $this->file->getRealFullPath();

                fileLoader::load('service/image');
                $image = new image($filename);
                $image->resize($width, $height);
                $image->save($file);
            }
        }

        return $this->publicPath . '/thumbnails/' . $thumbNameFile;
    }

    private function getThumbPath()
    {
        return systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . $this->publicPath . DIRECTORY_SEPARATOR . 'thumbnails';
    }

    public function delete()
    {
        $thumbName = $this->getHash();
        $path = $this->getThumbPath();

        $thumbnails = glob($path . DIRECTORY_SEPARATOR . $thumbName . '*');

        foreach ($thumbnails as $thumbnail) {
            if (is_file($thumbnail)) {
                unlink($thumbnail);
            }
        }
    }
}
?>