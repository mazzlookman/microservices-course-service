<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Response\ControllerResponses;
use App\Http\Requests\CreateMyCourseRequest;
use App\Http\Resources\MyCourseResource;
use App\Models\MyCourse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MyCourseController extends Controller
{
    public function createPremiumAccess(Request $request)
    {
        $payload = $request->all();
        $myCourse = MyCourse::create($payload);

        return new MyCourseResource($myCourse, 201, "Created");
    }

    public function getByUserId(Request $request)
    {
        $userId = $request->query("user_id");

        $myCourse = MyCourse::query()->with("Course");
        $myCourse->when(isset($userId), function (Builder $query) use ($userId){
            $query->where("user_id", $userId);
        });

        return response()->json(
            ControllerResponses::getAllModelResponse($myCourse->get())
        );
    }

    public function create(CreateMyCourseRequest $request)
    {
        $req = $request->validated();

        // is existed a course?
        $courseId = $req["course_id"];
        $course = CourseController::findCourse($courseId, false);

        // is existed a user?
        $userId = $req["user_id"];
        $user = getUserById($userId);

        if ($user["status"] !== "OK"){
            return response()->json(
                ControllerResponses::errorFromOtherServiceResponse($user), $user["code"]
            );
        }

        // Has the user previously purchased the same course?
        $isExistMyCourse = MyCourse::where("course_id", $courseId)
            ->where("user_id", $userId)
            ->exists();

        if ($isExistMyCourse) {
            return response()->json(
                ControllerResponses::conflictResponse("User already take this course")
            ,409);
        }

        // if premium course
        if ($course->type === "premium") {

            $order = postOrder([
                "user" => $user["data"],
                "course" => $course->toArray()
            ]);

            if ($order["code"] !== 201) {
                return response()->json(
                    ControllerResponses::errorFromOtherServiceResponse($order), $order["code"],
                );
            }

            return response([
                "code" => 200,
                "status" => "OK",
                "data" => $order["data"]
            ]);
        }

        // if course is free
        $myCourse = MyCourse::create($req);

        return new MyCourseResource($myCourse,201, "Created");
    }
}
