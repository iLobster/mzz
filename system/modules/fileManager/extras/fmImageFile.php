<?php
class fmImageFile extends fmSimpleFile
{
    public function getThumbnail($width = 80, $height = 60)
    {
        $config = systemToolkit::getInstance()->getConfig('fileManager');
        $publicPath = $config->get('public_path');

        $thumb_name = md5($this->file->getId() . $this->file->getName()) . '.' . $this->file->getExt();
        $file = systemConfig::$pathToApplication . $publicPath . DIRECTORY_SEPARATOR . 'thumbnails' . DIRECTORY_SEPARATOR . $thumb_name;

        if (!is_file($file)) {
            if (in_array($ext = $this->file->getExt(), array('jpg', 'jpeg', 'png', 'gif'))) {
                if ($ext == 'jpg') {
                    $ext = 'jpeg';
                }
                $filename = $this->file->getRealFullPath();
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
            }
        }

        return SITE_PATH . $publicPath . '/thumbnails/' . $thumb_name;

        /*
        $folderMapper = systemToolkit::getInstance()->getMapper('fileManager', 'folder', $this->file->section());

        $thumbFolderName = (int)$width . 'x' . (int)$height;

        $folder = $folderMapper->searchByPath('root/extras/thumbnails/' . $thumbFolderName);

        if (!$folder) {
            $folder = $folderMapper->create();

            $folder->setName($thumbFolderName);
            $folder->setTitle($thumbFolderName);

            $targetFolder = $folderMapper->searchByPath('root/extras/thumbnails');
            $folderMapper->save($folder, $targetFolder);
        }

        $thumbnail = $this->mapper->searchByPath('root/extras/thumbnails/' . $folder->getName() . '/' . $this->file->getId() . '.' . $this->file->getExt());

        if (!$thumbnail) {
            if (in_array($ext = $this->file->getExt(), array('jpg', 'jpeg', 'png', 'gif'))) {
                if ($ext == 'jpg') {
                    $ext = 'jpeg';
                }
                $filename = $this->file->getRealFullPath();

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

                $file = systemConfig::$pathToTemp . DIRECTORY_SEPARATOR . $this->file->getId();
                $file = systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'files/' .$this->file->getId();

                call_user_func('image' . $ext, $thumbnail, $file);

                $thumbnail = $folder->upload($file, $this->file->getId() . '.' . $this->file->getExt());
                $thumbnail->setRightHeader(1);
                $this->mapper->save($thumbnail);
            }
        }

        return $thumbnail;
        */
    }
}
?>