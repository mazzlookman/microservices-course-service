<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Response\ControllerResponses;
use App\Http\Requests\CreateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(CreateReviewRequest $request)
    {
        $req = $request->validated();

        // Cek course
        $courseId = $req["course_id"];
        CourseController::findCourse($courseId);

        // Cek user
        $userId = $req["user_id"];
        $user = getUserById($userId);
        if ($user["status"] !== "OK") {
            return response()->json(
                ControllerResponses::errorFromUserServiceResponse($user), $user["code"]
            );
        }

        // Cek duplicate
        $isReviewExisted = Review::where("user_id", $userId)
            ->where("course_id", $courseId)
            ->exists();

        if ($isReviewExisted) {
            return response()->json(
                ControllerResponses::conflictResponse("You have reviewed this course"),409
            );
        }

        // Create new review
        $review = Review::create($req);

        return new ReviewResource($review);
    }
}
