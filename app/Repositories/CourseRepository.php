<?php


namespace App\Repositories;


use App\Models\Course;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\CourseContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class CourseRepository
 *
 * @package \App\Repositories
 */

class CourseRepository extends BaseRepository implements CourseContract{

    use UploadAble;

    /**
     * CourseRepository constructor.
     * @param Course $model
     */

    public function __construct(Course $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listCourses(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findCourseById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Course|mixed
     */
    public function createCourse($params)
    {
        try {
            $collection = collect($params);

            $image = null;

            if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {
                $image = $this->uploadOne($params['image'], 'categories');
            }

            $featured = $collection->has('featured') ? 1 : 0;
            $menu = $collection->has('menu') ? 1 : 0;

            $merge = $collection->merge(compact('menu', 'image', 'featured'));

            $course = new Course($merge->all());

            $course->save();

            return $course;

        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }


    /**
     * @param array $params
     * @return mixed
     */

    public function updateCourse(array $params){

        $course =$this->findCourseById($params['id']);

        $collection = collect($params)->except('_token');

        $image = $course->image;

        if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {

            if ($course->image != null) {
                $this->deleteOne($course->image);
            }

            $image = $this->uploadOne($params['image'], 'courses');
        }

        $featured = $collection->has('featured') ? 1 : 0;
        $menu = $collection->has('menu') ? 1 : 0;

        $merge = $collection->merge(compact('menu', 'image', 'featured'));

        $course->update($merge->all());

        return $course;

    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteCourse($id)
    {
        $course = $this->findCourseById($id);

        if ($course->image != null) {
            $this->deleteOne($course->image);
        }

        $course->delete();

        return $course;
    }

    public function findBySlug($slug)
    {
        return Course::with('videos')
            ->where('slug', $slug)
            ->where('menu', 1)
            ->first();
    }

}
