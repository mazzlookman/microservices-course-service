<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Http\Resources\LessonResource;
use App\Models\Chapter;
use App\Models\Lesson;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public static function findLesson(int $id)
    {
        $lesson = Lesson::find($id);
        if (!$lesson) {
            throw new HttpResponseException(response([
                "code" => 404,
                "status" => "Not Found",
                "errors" => [
                    "message" => "Lesson not found"
                ]
            ], 404));
        }

        return $lesson;
    }

    public function create(CreateLessonRequest $request)
    {
        $req = $request->validated();

        ChapterController::findChapter($req["chapter_id"]);

        $lesson = Lesson::create($req);

        return new LessonResource($lesson);
    }

    public function update(UpdateLessonRequest $request, int $id)
    {
        $req = $request->validated();

        $lesson = self::findLesson($id);

        if (isset($req["chapter_id"])) ChapterController::findChapter($req["chapter_id"]);

        $lesson->fill($req)->save();

        return new LessonResource($lesson);
    }
}
