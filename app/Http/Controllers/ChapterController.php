<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateChapterRequest;
use App\Http\Resources\ChapterResource;
use App\Models\Chapter;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function create(CreateChapterRequest $request)
    {
        $req = $request->validated();

        CourseController::findCourse($req["course_id"]);

        $chapter = Chapter::create($req);

        return new ChapterResource($chapter);
    }
}
