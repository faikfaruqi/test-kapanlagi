<?php
namespace helpers;

class UploadImage
{
    public function upload($name)
    {
        try {
            $path = "uploads/";
            $path = $path . basename($_FILES[$name]['name']);
            $arrayPath = explode(".", $path);
            $newPath = "";
            foreach ($arrayPath as $key => $value) {
                if ($key < count($arrayPath) - 1) {
                    $newPath .= $value;
                }
            }
            UploadImage::cropAndResize(600, 600, $_FILES[$name]['tmp_name'], $newPath . "-600x600.jpg", 80);
            UploadImage::cropAndResize(240, 240, $_FILES[$name]['tmp_name'], $newPath . "-240x240.jpg", 80);
            $result = array(
                "status" => true,
                "image" => Array($newPath . "-600x600.jpg", $newPath . "-240x240.jpg"),
                "message" => "Success"
            );
            return $result;
        } catch (\Exception $e) {
            $result = array(
                "status" => false,
                "message" => $e
            );
            return $result;
        }
    }

    public function cropAndResize($max_width, $max_height, $filename, $new_filname, $quality)
    {
        $filename = $_FILES['image']['tmp_name'];
        list($width, $height) = getimagesize($filename);
        $dst_img = imagecreatetruecolor($max_width, $max_height);
        $src_img = imagecreatefromjpeg($filename);
        $width_new = $height * $max_width / $max_height;
        $height_new = $width * $max_height / $max_width;
        if ($width_new > $width) {
            $h_point = (($height - $height_new) / 2);
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
        } else {
            $w_point = (($width - $width_new) / 2);
            imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
        }

        imagejpeg($dst_img, $new_filname, $quality);

        if ($dst_img) {
            imagedestroy($dst_img);
        }

        if ($src_img) {
            imagedestroy($src_img);
        }
    }
}
