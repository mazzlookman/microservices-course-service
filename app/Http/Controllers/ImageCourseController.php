<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Response\ControllerResponses;
use App\Http\Requests\CreateImageCourseRequest;
use App\Http\Resources\ImageCourseResource;
use App\Models\ImageCourse;
use Illuminate\Http\Request;

class ImageCourseController extends Controller
{
    public function remove(int $id)
    {
        CourseController::findCourse($id)->delete();

        return response()->json(
            ControllerResponses::deletedResponse("Image Course")
        );

    }

    public function create(CreateImageCourseRequest $request)
    {
        $req = $request->validated();

        CourseController::findCourse($req["course_id"]);

        $imageCourse = ImageCourse::create($req);

        return new ImageCourseResource($imageCourse);
    }
}
