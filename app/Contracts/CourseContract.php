<?php

namespace App\Contracts;

use App\Models\Course;

/**
 * Interface CategoryContract
 * @package App\Contracts
 */

interface CourseContract{
    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listCourses(string $order = 'id',string $sort = 'desc', array $columns = ['*']);

    /**
     * @param int $id
     * @return mixed
     */
    public function findCourseById(int $id);

    /**
     * @param array $params
     * @return mixed
     */
    public function createCourse ($params);

    /**
     * @param array $params
     * @return mixed
     */
    public function updateCourse(array $params);

    /**
     * @param $id
     * @return bool
     */
    public function deleteCourse($id);

    /**
     * @param $slug
     * @return mixed
     */
    public function findBySlug($slug);

    /**
     * @param array $params
     * @return Course|mixed
     */


}
