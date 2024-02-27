<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Response\ControllerResponses;
use App\Http\Requests\CreateReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function remove(UpdateReviewRequest $request, int $id)
    {
        $req = $request->safe()->only("user_id");
        $review = self::findReview($id, false);

        if ($review["user_id"] !== intval($req["user_id"])){
            return response()->json([
                "code" => 405,
                "status" => "Method Not Allowed",
                "errors" => [
                    "message" => "You're not the user who created this review"
                ]
            ], 405);
        }

        $review->delete();
        return response()->json(
            ControllerResponses::deletedResponse("Review"),
        );
    }

    public function update(UpdateReviewRequest $request, int $id)
    {
//        $request->except(["user_id", "course_id"]);
        $req = $request->validated();

        $review = self::findReview($id, false);
        if ($review["user_id"] !== intval($req["user_id"])){
            return response()->json([
                "code" => 405,
                "status" => "Method Not Allowed",
                "errors" => [
                    "message" => "You're not the user who created this review"
                ]
            ], 405);
        }

        $review->fill($req)->save();

        return new ReviewResource($review);
    }

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
                ControllerResponses::errorFromOtherServiceResponse($user), $user["code"]
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
        return new ReviewResource($review, 201, "Created");
    }

    private static function findReview(int $id, bool $idOnly = true)
    {
        new Review();

        if ($idOnly) {
            $review = Review::find($id, ["id"]);
        } else {
            $review = Review::find($id);
        }

        if (!$review){
            throw new HttpResponseException(
                response()->json(ControllerResponses::notFoundResponse("Review"),404)
            );
        }

        return $review;
    }
}
