<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;

class ImageController extends Controller
{

    public function store($request, $crop = false, $path = "product")
    {

        $imageName = $this->getRandomName();

        $imgSizes = array("large" => "1920", "medium" => "960", "small" => "480", 'thumb' => '150');

        $destination = public_path('images/' . $path);
        $img = Image::make($request)->encode('webp');

        $width = $img->width();
        $height = $img->height();
        
        // check ratio 
        if ($width > $height) {
            $r = $width/ $height;        
        } else{
            $r = $height / $width;
        }
        if($r >= 2){
            return 405;
        }

        if ($crop) {
            if ($width > $height) {
                $ratio = $height;
                $point = intval(($width - $height) / 2);
                $img->crop($ratio, $ratio, $point, 0);
            } else {
                $ratio = $width;
                $point = intval(($height - $width) / 2);
                $img->crop($ratio, $ratio, 0, $point);
            }
        }

        foreach ($imgSizes as $size => $value) {
            $img->resize($value, $value, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($destination . '/' . $size . '/' . $imageName . '.' . 'webp', 75);
        }

        return $imageName.'.webp';
    }

    public function multipleImages($request, $crop = false, $path = "product" )
    {
        $files = [];

        if ($request->hasFile('files')) {
            for ($i = 0; $i < count($request->file('files')); $i++) {
                $imageName = $this->store($request->file('files')[$i]->path(), $crop, $path);

                array_push($files, $imageName);
            }
            return $files;
        }
    }

    function getRandomName()
    {
        $filename = substr(md5(microtime()), 0, rand(4, 6));
        $randi = rand(3, 4);
        for ($i = 0; $i < $randi; $i++) {
            $filename = $filename . '-' . substr(md5(microtime()), 0, rand(4, 6));
        }
        return $filename;
    }
}
