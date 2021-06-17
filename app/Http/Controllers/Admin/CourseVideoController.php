<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\CourseContract;
use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Traits\Uploadable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;

class CourseVideoController extends Controller
{
    //
    use UploadAble;

    protected $courseRepository;

    public function __construct(CourseContract $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function upload(Request $request)
    {

        $course = $this->courseRepository->findCourseById($request->course_id);
        if ($request->has('video')) {
//            $video = $this->uploadOne($request->video, 'videos','public',$request->video->get);


            $file = $request->video;
            $filename = $file->getClientOriginalName();
            $video = $file->storeAs(
                'videos',
                $filename . "." . $file->getClientOriginalExtension(),
                'public');

            try {
                $courseVideo = new Video([
                    'name' => $filename,
                    'full' => $video,
                ]);

                $courseVideo->save();
                $course->videos()->attach($courseVideo);
            }catch (\Throwable $exception){
                return response()->json(['error'=>$exception->getMessage()]);
            }
            return response()->json(['status' => 'Success']);
        }

        return redirect(route('admin.categories.edit'));
    }

    public function delete($id)
    {
        $video = Video::findOrFail($id);

        if ($video->full != '') {
            $this->deleteOne($video->full);
        }
        $video->delete();

        return redirect()->back();
    }

}
