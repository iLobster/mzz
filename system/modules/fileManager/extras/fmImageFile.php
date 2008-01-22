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
        $thumbName = $this->getThumbName();
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
                $resized = $image->resize($width, $height);
                $image->save($file);

                /*
                list($width_orig, $height_orig) = getimagesize($filename);

                $aspect_w = $width_orig / $width;
                $aspect_h = $height_orig / $height;

                $aspect = ($aspect_h > $aspect_w) ? $aspect_h : $aspect_w;

                if ($aspect <= 1) {
                    $width = $width_orig;
                    $height = $height_orig;
                } else {
                    $width = round($width_orig / $aspect);
                    $height = round($height_orig / $aspect);
                }

                $thumbnail = imagecreatetruecolor($width, $height);
                $image = call_user_func('imagecreatefrom' . $ext, $filename);

                if ($ext == 'png') {
                    imagealphablending($thumbnail, false);
                    imagesavealpha($thumbnail, true);
                } elseif ($ext == 'gif') {
                    $trans_color = imagecolorallocate($image, 255, 255, 255);
                    imagecolortransparent($image, $trans_color);
                }

                imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

                call_user_func('image' . $ext, $thumbnail, $file);
                */
            }
        }

        return SITE_PATH . $this->publicPath . '/thumbnails/' . $thumbNameFile;
    }

    protected function getThumbName()
    {
        return md5($this->file->section() . $this->file->getId() . $this->file->getName());
    }

    protected function getThumbPath()
    {

        return systemConfig::$pathToApplication . $this->publicPath . DIRECTORY_SEPARATOR . 'thumbnails';
    }

    public function delete()
    {
        $thumbName = $this->getThumbName();
        $path = $this->getThumbPath();

        $thumbnails = glob($path . DIRECTORY_SEPARATOR . $thumbName . '*');

        foreach ($thumbnails as $thumbnail) {
            if (is_file($thumbnail)) {
                unlink($thumbnail);
            }
        }
    }

    public function __clone()
    {
        $this->path = null;
    }
}
?>