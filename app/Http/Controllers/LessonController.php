<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLessonRequest;
use App\Http\Resources\LessonResource;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function create(CreateLessonRequest $request)
    {
        $req = $request->validated();

        ChapterController::findChapter($req["chapter_id"]);

        $lesson = Lesson::create($req);

        return new LessonResource($lesson);
    }
}
