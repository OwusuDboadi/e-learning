<?php

namespace App\Http\Controllers\Admin;
use App\Contracts\CategoryContract;
use App\Contracts\CourseContract;
use App\Http\Controllers\BaseController;
use App\Models\Course;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCourseFormRequest;
use Illuminate\Support\Facades\Validator;

/**
 * Class CourseController
 * @package App\Http\Controllers\Admin
 */

class CourseController extends BaseController
{
    protected $courseRepository;


    protected $categoryRepository;


    public function __construct(CourseContract $courseRepository, CategoryContract $categoryRepository)
    {
        $this->courseRepository = $courseRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $courses = $this->courseRepository->listCourses();
        $this->setPageTitle('Courses', 'List of all courses');
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $courses = $this->courseRepository->listCourses('id', 'asc');
        $categories = $this->categoryRepository->listCategories('id','asc');

        $this->setPageTitle('Courses', 'Create Course');
        return view('admin.courses.create', compact('courses','categories'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
//    public function store(Request $request)
//    {
//        $this->validate($request, [
//            'name'      =>  'required|max:191',
//            'parent_id' =>  'required|not_in:0',
//            'image'     =>  'mimes:jpg,jpeg,png|max:1000'
//        ]);
//
//        $params = $request->except('_token');
//
//        $category = $this->courseRepository->createCourse($params);
//
//        if (!$category) {
//            return $this->responseRedirectBack('Error occurred while creating course.', 'error', true, true);
//        }
//        return $this->responseRedirect('admin.courses.index', 'Course added successfully' ,'success',false, false);
//    }

    public function store(StoreCourseFormRequest $request)
    {
        $params = $request->except('_token');

        $course= $this->courseRepository->createCourse($params);

        if (!$course) {
            return $this->responseRedirectBack('Error occurred while creating course.', 'error', true, true);
        }
        return $this->responseRedirect('admin.courses.index', 'Course added successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetCourse = $this->courseRepository->findCourseById($id);
        $courses = $this->courseRepository->listCourses();
        $categories = $this->categoryRepository->listCategories();
        $videos = $targetCourse->videos()->get();


        $selected = Course::find($id);
      //  dd($videos);

        $this->setPageTitle('Course', 'Edit Course : '.$targetCourse->name);
        return view('admin.courses.edit', compact('courses', 'targetCourse','categories','selected','videos'));
    }

    /**
//     * @param Request $request
//     * @return \Illuminate\Http\RedirectResponse
//     * @throws \Illuminate\Validation\ValidationException
//     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name'      =>  'required|max:191',
            'image'     =>  'mimes:jpg,jpeg,png|max:1000'
        ]);

//        $validator = Validator::make($request->all(),[
//           'name'   => 'required|max:191',
////           'image'  => 'mimes:jpg,jpeg,png,jfif|max:1000'
//        ]);
//
//        if($validator->errors()){
//
//            dd($validator->errors());
//            return $this->responseRedirectBack($validator->errors(), 'error', true, true);
//        }

        $params = $request->except('_token');

        $category = $this->courseRepository->updateCourse($params);

        if (!$category) {
            return $this->responseRedirectBack('Error occurred while updating course.', 'error', true, true);
        }
        return $this->responseRedirectBack('Course updated successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $course = $this->courseRepository->deleteCourse($id);

        if (!$course) {
            return $this->responseRedirectBack('Error occurred while deleting course.', 'error', true, true);
        }
        return $this->responseRedirect('admin.courses.index', 'Course deleted successfully' ,'success',false, false);
    }

}
