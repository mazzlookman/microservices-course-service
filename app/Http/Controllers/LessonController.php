<?php

namespace App\Http\Controllers;

use App\Http\Controllers\response\ControllerResponses;
use App\Http\Requests\CreateLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Http\Resources\LessonResource;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function remove(int $id)
    {
        self::findLesson($id)->delete();

        return response()->json(
            ControllerResponses::deletedResponse("Lesson")
        );
    }

    public function getById(int $id)
    {
        return new LessonResource(self::findLesson($id));
    }

    public function getAll(Request $request)
    {
        $chapterId = $request->query("chapter_id");

        $lesson = Lesson::query();

        $lesson->when(isset($chapterId), function (Builder $query) use ($chapterId){
            $query->where("chapter_id", intval($chapterId));
        });

        return response()->json(
            ControllerResponses::getAllModelResponse($lesson->get())
        );
    }

    public function create(CreateLessonRequest $request)
    {
        $req = $request->validated();

        ChapterController::findChapter($req["chapter_id"]);

        $lesson = Lesson::create($req);

        return new LessonResource($lesson,201, "Created");
    }

    public function update(UpdateLessonRequest $request, int $id)
    {
        $req = $request->validated();

        $lesson = self::findLesson($id);

        if (isset($req["chapter_id"])) ChapterController::findChapter($req["chapter_id"]);

        $lesson->fill($req)->save();

        return new LessonResource($lesson);
    }

    public static function findLesson(int $id)
    {
        $lesson = Lesson::find($id);
        if (!$lesson) {
            throw new HttpResponseException(
                response()->json(ControllerResponses::notFoundResponse("Lesson"), 404)
            );
        }

        return $lesson;
    }
}
