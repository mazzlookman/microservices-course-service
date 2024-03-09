<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Response\ControllerResponses;
use App\Http\Requests\CreateCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\MyCourse;
use App\Models\Review;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public static function findCourse(int $id, bool $idOnly = true)
    {
        new Course();

        if ($idOnly) {
            $course = Course::find($id, ["id"]);
        } else {
            $course = Course::find($id);
        }

        if (!$course){
            throw new HttpResponseException(
                response()->json(ControllerResponses::notFoundResponse("Course"),404)
            );
        }

        return $course;
    }

    public function getById(int $id)
    {
        $course = Course::with("Chapters.Lessons")
            ->with("Mentor")
            ->with("ImageCourses")
            ->find($id);

        $reviews = Review::where("course_id", $id)->get()->toArray();
        if (count($reviews) > 0) {
            $userIds = array_column($reviews, "user_id");
            $users = getUserByIds($userIds);

            if ($users["status"] !== "OK") {
                $reviews = [];
            } else {
                foreach ($reviews as $key => $review) {
                    // combine user_id yang ada di review dan user-service
                    // array_search($value_yang_ingin_dicari_dari_array, $ini_array_nya)
                    // hasilnya: index dari masing2 data users yang telah melakukan review terhadap course id ini
                    $userIndex = array_search($review["user_id"], array_column($users["data"],"id"));

                    // inject data user yang melakukan review ke masing2 data review-nya
                    $reviews[$key]["users"] = $users["data"][$userIndex];
                }
            }
        }

        $totalStudents = MyCourse::where("course_id", $id)->count();

        $lessonsInChapterIsCourse = Chapter::where("course_id", $id)->withCount("Lessons")->get()->toArray();
        $totalLessons = array_sum(array_column($lessonsInChapterIsCourse, "lessons_count"));

        $course["reviews"] = $reviews;
        $course["total_students"] = $totalStudents;
        $course["total_lessons"] = $totalLessons;

        return response([
            "code" => 200,
            "status" => "OK",
            "data" => $course,
        ]);
    }

    public function create(CreateCourseRequest $request)
    {
        $req = $request->validated();
        MentorController::findMentor($req["mentor_id"]);

        $course = Course::create($req);

        return new CourseResource($course,201, "Created");
    }

    public function update(UpdateCourseRequest $request, int $id)
    {
        $req = $request->validated();

        $course = self::findCourse($id, false);
        if (isset($req["mentor_id"])) MentorController::findMentor($req["mentor_id"]);

        $course->fill($req)
            ->save();

        return new CourseResource($course);
    }

    public function getAll(Request $request)
    {
        try {
            $courses = Course::query();

            $byName = $request->query("name");
            $byStatus = $request->query("status");

            $courses->when(isset($byName), function (Builder $query) use ($byName) {
                return $query->whereRaw("name LIKE '%".strtolower($byName)."%'");
            });

            $courses->when(isset($byStatus), function (Builder $query) use ($byStatus) {
                return $query->where("status", $byStatus);
            });

            return response()->json(ControllerResponses::getAllModelResponse($courses->paginate(10)));
        } catch (\Exception $e) {
            return response(ControllerResponses::internalServerError($e->getMessage()), 500);
        }
    }

    public function remove(int $id)
    {
        self::findCourse($id)->delete();

        return response()->json(ControllerResponses::deletedResponse("Course"));
    }
}
