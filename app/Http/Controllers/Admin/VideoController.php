<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends BaseController
{
    //

    public function index(){
        $videos = Video::all();
        $this->setPageTitle('Videos', 'List of all videos');
        return view('admin.videos.index', compact('videos'));
    }
}
