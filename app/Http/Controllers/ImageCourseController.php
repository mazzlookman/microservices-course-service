<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateImageCourseRequest;
use App\Http\Resources\ImageCourseResource;
use App\Models\ImageCourse;
use Illuminate\Http\Request;

class ImageCourseController extends Controller
{
    public function create(CreateImageCourseRequest $request)
    {
        $req = $request->validated();

        CourseController::findCourse($req["course_id"]);

        $imageCourse = ImageCourse::create($req);

        return new ImageCourseResource($imageCourse);
    }
}
