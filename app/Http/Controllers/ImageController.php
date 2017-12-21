<?php

namespace App\Http\Controllers;


class ImageController extends Controller
{
    /**
     * @param $title
     * @param $data
     * @param string $path
     * @return string
     */
    public function save($title, $data, $path)
    {
        if ($this->isBase64Image($data)) {
            $file = $title . ".jpg";
            file_put_contents($path . $file, base64_decode($data));
            return $file;
        } else {
            return "Invalid Data";
        }

    }

    public function delete($title, $path)
    {
        $file = $title . '.jpg';
        if (file_exists($path . $file)) {
            unlink($path . $file);
            return "Deleted";
        } else {
            return "File not found";
        }
    }

    private function isBase64Image($data)
    {
        $object = base64_decode($data);
        if (!$img = @imagecreatefromstring($object)) {
            return false;
        } else {
            return true;
        }
    }


}
