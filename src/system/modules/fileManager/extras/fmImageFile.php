<?php
class fmImageFile extends fmSimpleFile
{
    protected $thumbnails_full_path;
    protected $thumbnails_relative_path;

    public function __construct(file $file)
    {
        parent::__construct($file);

        $config = systemToolkit::getInstance()->getConfig('fileManager');
        $this->thumbnails_full_path = $config->get('thumbnails_full_path');
        $this->thumbnails_relative_path = $config->get('thumbnails_relative_path');
    }

    public function explode($name)
    {
        return $name[0] . '/' . $name[1] . '/' . $name[2] . '/' . $name[3] . '/' . substr($name, 4);
    }

    public function getThumbnail($width = 80, $height = 60)
    {
        $ext = $this->file->getExt();
        if (in_array($ext, array('jpg', 'jpeg', 'png', 'gif'))) {
            $thumb_basename = $this->explode($this->getHash());
            $thumb_filename = $thumb_basename . '_' . $width . 'x' . $height . '.' . $this->file->getExt();
            $thumb_filepath = $this->thumbnails_full_path . DIRECTORY_SEPARATOR . $thumb_filename;

            if (!is_file($thumb_filepath)) {
                $filepath = $this->file->getRealFullPath();

                fileLoader::load('service/image');
                $image = new image($filepath);
                $image->resize($width, $height);

                $thumb_filepath_dir = dirname($thumb_filepath);
                if (!is_dir($thumb_filepath_dir)) {
                    mkdir($thumb_filepath_dir, 0777, true);
                }

                $image->save($thumb_filepath);
            }
        }

        return $this->thumbnails_relative_path . '/' . $thumb_filename;
    }

    public function delete()
    {
        $thumb_basename = $this->getHash();
        $thumbnails = glob($this->thumbnails_full_path . DIRECTORY_SEPARATOR . $thumb_basename . '*');

        foreach ($thumbnails as $thumbnail) {
            if (is_file($thumbnail)) {
                unlink($thumbnail);
            }
        }
    }
}
?>