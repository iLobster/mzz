<?php
class fmImageFile extends fmSimpleFile
{
    public function getThumbnail()
    {
        $folderMapper = systemToolkit::getInstance()->getMapper('fileManager', 'folder', $this->file->section());

        $thumbnail = $this->mapper->searchByPath('root/extras/thumbnails/' . $this->file->getId() . '.jpg');

        if (!$thumbnail) {
            if (in_array($ext = $this->file->getExt(), array('jpg', 'jpeg', 'png', 'gif'))) {
                if ($ext == 'jpg') {
                    $ext = 'jpeg';
                }
                $filename = $this->file->getRealFullPath();

                $width = 80;
                $height = 60;

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
                imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

                $file = systemConfig::$pathToTemp . DIRECTORY_SEPARATOR . $this->file->getId();

                call_user_func('image' . $ext, $thumbnail, $file);

                $folder = $folderMapper->searchByPath('root/extras/thumbnails');
                $thumbnail = $folder->upload($file, $this->file->getId() . '.jpg');
                $thumbnail->setRightHeader(1);
                $this->mapper->save($thumbnail);
            }
        }

        return $thumbnail;
    }
}
?>