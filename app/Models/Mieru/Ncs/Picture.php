<?php

namespace App\Models\Mieru\Ncs;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    protected $table = 'pictures';

    //図面画像用のリンク作成
    public static function getPictureLink($zuban){
        $picture = static::getAPicture($zuban);
        if(!empty($picture['folder_path'])){
            $folder_path = $picture['folder_path'];

            $folder = preg_replace('/\\\/u', '/', $folder_path);
            $file = $picture['file_name'];
            $link = 'http://172.17.0.4/';

            $link= $link . $folder ."/". $file;
        }else{ $link = null; }
        return $link;
    }

    public static function getAPicture($zuban){
        $pictures = Picture::where('figure_id', '=', $zuban)->where(function($query){
            $query->where('category', '=', '現場図')
                ->orWhere('category', '=', '原図');
        })->orderBy('updated_at','desc')->limit(10)->get();

        if(!empty($pictures[0]->original)){
            return $pictures[0]->original;
        }else{
            return null;
        }
    }
}
