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
 * @package systen
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

    public function __construct($image_src)
    {
        if (!is_file($image_src) && is_writable($image_src)) {
            throw new mzzIoException($image_src);
        }

        $this->path = $image_src;

        list($this->width, $this->height, $this->type) = getimagesize($image_src);

        switch ($this->type) {
            case IMAGETYPE_GIF:
                $ext = 'gif';
                break;

            case IMAGETYPE_JPEG:
                $ext = 'jpeg';
                break;

            case IMAGETYPE_PNG:
                $ext = 'png';
                break;

            default:
                throw new mzzRuntimeException('Неверный тип файла');
                break;
        }

        $this->ext = $ext;

        if (!($this->image = call_user_func('imagecreatefrom' . $ext, $image_src))) {
            throw new mzzRuntimeException('imagecreatefrom' . $ext . ' failed');
        }
    }

    public function resize($width, $height)
    {
        if (!in_array($this->ext, array('gif', 'jpeg', 'png'))) {
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
            if (!($trans_color = imagecolorallocate($this->image, 255, 255, 255))) {
                throw new mzzRuntimeException('imagecolorallocate failed');
            }
            imagecolortransparent($this->image, $trans_color);
        }

        if (!imagecopyresampled($image_resized, $this->image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig)) {
            throw new mzzRuntimeException('imagecopyresampled failed');
        }

        $this->width = $width;
        $this->height = $height;
        $this->image = $image_resized;
    }

    public function save($filename = null)
    {
        if (!$filename) {
            if (is_null($this->path)) {
                throw new mzzRuntimeException('Укажите путь для сохранения');
            }
            $filename = $this->path;
        }

        if (call_user_func('image' . $this->ext, $this->image, $filename)) {
            return $filename;
        }
    }
}
?>