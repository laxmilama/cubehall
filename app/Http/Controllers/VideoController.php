<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Storage;

class VideoController extends Controller
{
    public function store(Request $request)
    {
        $mime = $request->video->getMimeType();
        if ($mime == "video/mp4" || $mime == "application/x-mpegURL" || $mime == "video/quicktime") 
        {
            $videoname = $this->getRandomName().'.'.$request->video->extension();

            $request->video->move(public_path('videos'), $videoname);
            // Send back image name
            return response()->json(['video'=>$videoname]);
        
        }else{
            return response()->json(['hello' => 'Could not upload, try another video'], 422); 
        }
        

    }

    function getRandomName(){
        $filename = substr(md5(microtime()), 0, rand(6,10));
        $randi = rand(3,5);
        for($i=0; $i<$randi; $i++){
            $filename = $filename . '-'.substr(md5(microtime()), 0, rand(5,10));
        }
        return $filename;
    }
}
