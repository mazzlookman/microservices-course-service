<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Response\ControllerResponses;
use App\Http\Requests\CreateCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public static function findCourse(int $id)
    {
        $course = Course::find($id);
        if (!$course){
            throw new HttpResponseException(
                response()->json(ControllerResponses::notFoundResponse("Course"),404)
            );
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
        if (isset($req["mentor_id"])) MentorController::findMentor($req["mentor_id"]);

        $course->fill($req)
            ->save();

        return new CourseResource($course);
    }

    public function getAll(Request $request)
    {
        $courses = Course::query();

        $byName = $request->query("name");
        $byStatus = $request->query("status");

        $courses->when(isset($byName), function (Builder $query) use ($byName) {
            return $query->whereRaw("name LIKE '%".strtolower($byName)."%'");
        });

        $courses->when(isset($byStatus), function (Builder $query) use ($byStatus) {
            return $query->where("status",$byStatus);
        });

        return response()->json(ControllerResponses::getAllModelResponse($courses->get()));

    }

    public function remove(int $id)
    {
        self::findCourse($id)->delete();

        return response()->json(ControllerResponses::deletedResponse("Course"));
    }
}
