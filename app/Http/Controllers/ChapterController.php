<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Response\ControllerResponses;
use App\Http\Requests\CreateChapterRequest;
use App\Http\Requests\UpdateChapterRequest;
use App\Http\Resources\ChapterResource;
use App\Models\Chapter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public static function findChapter(int $id)
    {
        $chapter = Chapter::find($id);
        if (!$chapter) {
            throw new HttpResponseException(
                response()->json(ControllerResponses::notFoundResponse("Chapter"),404)
            );
        }

        return $chapter;
    }

    public function create(CreateChapterRequest $request)
    {
        $req = $request->validated();

        CourseController::findCourse($req["course_id"]);

        $chapter = Chapter::create($req);

        return new ChapterResource($chapter,201, "Created");
    }

    public function update(UpdateChapterRequest $request, int $id)
    {
        $req = $request->validated();

        $chapter = self::findChapter($id);

        if (isset($req["course_id"])) CourseController::findCourse($req["course_id"]);

        $chapter->fill($req)->save();

        return new ChapterResource($chapter);
    }

    public function getAll(Request $request)
    {
        $chapter = Chapter::query();

        $courseId = $request->query("course_id");

        $chapter->when(isset($courseId), function (Builder $query) use ($courseId){
            $query->where("course_id", intval($courseId));
        });

        return response()->json(
            ControllerResponses::getAllModelResponse($chapter->get())
        );
    }

    public function getById(int $id)
    {
        return new ChapterResource(self::findChapter($id));
    }

    public function remove(int $id)
    {
        self::findChapter($id)->delete();

        return response()->json(
            ControllerResponses::deletedResponse("Chapter")
        );
    }
}
