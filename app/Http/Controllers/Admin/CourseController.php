<?php

namespace App\Http\Controllers\Admin;
use App\Contracts\CourseContract;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

/**
 * Class CourseController
 * @package App\Http\Controllers\Admin
 */

class CourseController extends BaseController
{
    /**
     * @var CourseContract
     */
    protected $courseRepository;

    /**
     * CourseController constructor.
     * @param CourseContract $courseRepository
     */
    public function __construct(CourseContract $courseRepository)
    {
        $this->courseRepository = $courseRepository;
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

        $this->setPageTitle('Courses', 'Create Course');
        return view('admin.courses.create', compact('courses'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      =>  'required|max:191',
            'parent_id' =>  'required|not_in:0',
            'image'     =>  'mimes:jpg,jpeg,png|max:1000'
        ]);

        $params = $request->except('_token');

        $category = $this->categoryRepository->createCategory($params);

        if (!$category) {
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

        $this->setPageTitle('Course', 'Edit Course : '.$targetCourse->name);
        return view('admin.courses.edit', compact('courses', 'targetCourse'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name'      =>  'required|max:191',
            'parent_id' =>  'required|not_in:0',
            'image'     =>  'mimes:jpg,jpeg,png|max:1000'
        ]);

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
