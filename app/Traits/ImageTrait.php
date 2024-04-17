<?php

namespace App\Traits;

use App\Models\Learn\ProductImage;
use Intervention\Image\Facades\Image;

class ImageTrait
{
    /**
     * Get the Ip Address of the user.
     *
     * @return string
     */
    public function uploadIMage($image,$dimensions,$name,$folder = 'other')
    {
        $fit = explode(',',$dimensions);
        $path = 'storage/uploads/public/images/'.$folder.'/'.rand(1000,9999).'/'.str_replace(' ','_',$name);
        if(!file_exists($path))
            mkdir($path, 0777,true);

        $front = Image::make($image)->fit($fit[0],$fit[1])->save($path.'/'.$name.'.webp');

        return str_replace('storage/','',$front->basePath());
    }

}
