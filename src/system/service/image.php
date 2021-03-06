<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * image: класс для работы с изображениями
 *
 * @package system
 * @subpackage service
 * @version 0.1
 */
class image
{
    protected $image;

    protected $path = null;

    protected $type;

    protected $ext;

    protected $width;

    protected $height;

    public function __construct($image_src, $type = null)
    {
        if (is_resource($image_src)) {
            $width = imagesx($image_src);
            $height = imagesy($image_src);

            if ($width === false || $height === false) {
                throw new mzzRuntimeException('Не удалось получить данные о размере изображения');
            }

            $this->image = $image_src;
            $this->type = $type;
            $this->ext = $this->getExtByType($type);
            $this->width = $width;
            $this->height = $height;
        } else {
            if (!is_file($image_src) && is_writable($image_src)) {
                throw new mzzIoException($image_src);
            }

            $this->path = $image_src;
            list($this->width, $this->height, $this->type) = getimagesize($image_src);
            $this->ext = $this->getExtByType($this->type);

            if (!($this->image = call_user_func('imagecreatefrom' . $this->ext, $image_src))) {
                throw new mzzRuntimeException('imagecreatefrom' . $this->ext . ' failed');
            }
        }
    }

    public function width()
    {
        return $this->width;
    }

    public function height()
    {
        return $this->height;
    }

    public function resize($width, $height)
    {
        if (!in_array($this->type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG))) {
            throw new mzzRuntimeException('Неверный тип файла для изменения размера');
        }

        $width_orig = $this->width;
        $height_orig = $this->height;

        $aspect_w = $width_orig / $width;
        $aspect_h = $height_orig / $height;

        $aspect = max($aspect_h, $aspect_w);

        if ($aspect <= 1) {
            $width = $width_orig;
            $height = $height_orig;
        } else {
            $width = round($width_orig / $aspect);
            $height = round($height_orig / $aspect);
        }

        if (!($image_resized = imagecreatetruecolor($width, $height))) {
            throw new mzzRuntimeException('imagecreatetruecolor failed');
        }

        if ($this->ext == 'png') {
            if (!imagealphablending($image_resized, false)) {
                throw new mzzRuntimeException('imagealphablending failed');
            }
            if (!imagesavealpha($image_resized, true)) {
                throw new mzzRuntimeException('imagesavealpha failed');
            }
        } elseif ($this->ext == 'gif') {
            if ($trans_color = imagecolorallocate($this->image, 255, 255, 255)) {
                imagecolortransparent($this->image, $trans_color);
            }
        }

        if (!imagecopyresampled($image_resized, $this->image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig)) {
            throw new mzzRuntimeException('imagecopyresampled failed');
        }

        $this->width = $width;
        $this->height = $height;
        $this->image = $image_resized;

        return new image($this->image, $this->type, $this->width, $this->height);
    }

    public function resizeWithCrop($width, $height)
    {
        if (!in_array($this->type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG))) {
            throw new mzzRuntimeException('Неверный тип файла для изменения размера');
        }

        $width_orig = $this->width;
        $height_orig = $this->height;

        $aspect_w = $width_orig / $width;
        $aspect_h = $height_orig / $height;

        $aspect = min($aspect_h, $aspect_w);

        if ($aspect <= 1) {
            $thmb_width = $width_orig;
            $thmb_height = $height_orig;
        } else {
            $thmb_width = round($width_orig / $aspect);
            $thmb_height = round($height_orig / $aspect);
        }

        if (!($image_resized = imagecreatetruecolor($width, $height))) {
            throw new mzzRuntimeException('imagecreatetruecolor failed');
        }

        if ($this->ext == 'png') {
            if (!imagealphablending($image_resized, false)) {
                throw new mzzRuntimeException('imagealphablending failed');
            }
            if (!imagesavealpha($image_resized, true)) {
                throw new mzzRuntimeException('imagesavealpha failed');
            }
        } elseif ($this->ext == 'gif') {
            if (!($trans_color = imagecolorallocate($this->image, 255, 255, 255))) {
                throw new mzzRuntimeException('imagecolorallocate failed');
            }
            imagecolortransparent($this->image, $trans_color);
        }

        $startX = 0;
        if ($thmb_width > $width) {
            //$startX = (($width_orig - $thmb_width / $aspect_w) / 2) - ($thmb_width / $aspect_w);
            $startX = ($width - $thmb_width) / 2;
        }

        $startY = 0;
        if ($thmb_height > $height) {
            //$startY = (($height_orig - $thmb_height / $aspect_h) / 2) - ($thmb_height / $aspect_h);
            $startY = ($height - $thmb_height) / 2;
        }

        if (!imagecopyresampled($image_resized, $this->image, $startX, $startY, 0, 0, $thmb_width, $thmb_height, $width_orig, $height_orig)) {
            throw new mzzRuntimeException('imagecopyresampled failed');
        }

        $this->width = $width;
        $this->height = $height;
        $this->image = $image_resized;

        return new image($this->image, $this->type, $this->width, $this->height);
    }

    public function save($filename = null)
    {
        if (!$filename) {
            if (is_null($this->path)) {
                throw new mzzRuntimeException('Укажите путь для сохранения');
            }
            $filename = $this->path;
        }

        $args = array($this->image, $filename);
        if ($this->ext == 'jpeg') {
            $args[] = 100;
        }
        if (call_user_func_array('image' . $this->ext, $args)) {
            return $filename;
        } else {
            throw new mzzRuntimeException('image' . $this->ext . ' failed');
        }
    }

    protected function getExtByType($type)
    {
        //@todo: подумать над поддержкой всех типов
        $types = array(
            IMAGETYPE_GIF => 'gif',
            IMAGETYPE_JPEG => 'jpeg',
            IMAGETYPE_PNG => 'png',
            IMAGETYPE_SWF => 'swf',
            IMAGETYPE_PSD => 'psd',
            IMAGETYPE_BMP => 'bmp',
            IMAGETYPE_TIFF_II => 'tiff',
            IMAGETYPE_TIFF_MM => 'tiff'
        );

        if (!isset($types[$type])) {
            throw new mzzRuntimeException('Неверный тип файла');
        }

        return $types[$type];
    }

    public function getExt()
    {
        return $this->ext == 'jpeg' ? 'jpg' : $this->ext;
    }
}

?>