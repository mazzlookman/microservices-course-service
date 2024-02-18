<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateChapterRequest;
use App\Http\Requests\UpdateChapterRequest;
use App\Http\Resources\ChapterResource;
use App\Models\Chapter;
use App\Models\Course;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public static function findChapter(int $id)
    {
        $chapter = Chapter::find($id);
        if (!$chapter) {
            throw new HttpResponseException(response([
                "code" => 404,
                "status" => "Not Found",
                "errors" => [
                    "message" => "Chapter not found"
                ]
            ], 404));
        }

        return $chapter;
    }
    public function create(CreateChapterRequest $request)
    {
        $req = $request->validated();

        CourseController::findCourse($req["course_id"]);

        $chapter = Chapter::create($req);

        return new ChapterResource($chapter);
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
            $query->where("course_id", $courseId);
        });

        return response()->json([
            "code" => 200,
            "status" => "OK",
            "data" => $chapter->get()
        ]);
    }
}
