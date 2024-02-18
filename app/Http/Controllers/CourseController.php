<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Exceptions\HttpResponseException;

class CourseController extends Controller
{
    public static function findCourse(int $id)
    {
        $course = Course::find($id);
        if (!$course){
            throw new HttpResponseException(response([
                "code" => 404,
                "status" => "Not Found",
                "errors" => [
                    "message" => "Course not found"
                ]
            ], 404));
        }

        return $course;
    }

    public function create(CreateCourseRequest $request)
    {
        $req = $request->validated();
        MentorController::findMentor($req["mentor_id"]);

        $course = Course::create($req);

        return new CourseResource($course);
    }

    public function update(UpdateCourseRequest $request, int $id)
    {
        $req = $request->validated();

        $course = self::findCourse($id);
        MentorController::findMentor($req["mentor_id"]);

        $course->fill($req)
            ->save();

        return new CourseResource($course);
    }
}
