<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Response\ControllerResponses;
use App\Http\Requests\CreateMentorRequest;
use App\Http\Requests\UpdateMentorRequest;
use App\Http\Resources\MentorResource;
use App\Models\Mentor;
use Illuminate\Http\Exceptions\HttpResponseException;

class MentorController extends Controller
{
    public static function findMentor(int $id, bool $idOnly = true): Mentor
    {
        new Mentor();

        if ($idOnly) {
            $mentor = Mentor::find($id, ["id"]);
        } else {
            $mentor = Mentor::find($id);
        }

        if (!$mentor){
            throw new HttpResponseException(
                response()->json(ControllerResponses::notFoundResponse("Mentor"),404),
            );
        }

        return $mentor;
    }

    public function create(CreateMentorRequest $request): MentorResource
    {
        $data = $request->validated();

        if (Mentor::where("email", $data["email"])->count() === 1) {
            throw new HttpResponseException(
                response()->json(ControllerResponses::conflictResponse("Email already exists"),409)
            );
        }

        $mentor = Mentor::create($data);

        return new MentorResource($mentor, 201, "Created");
    }

    public function update(UpdateMentorRequest $request, int $id): MentorResource
    {
        $data = $request->validated();

        $mentor = self::findMentor($id, false);
        $mentor->fill($data)
            ->save();

        return new MentorResource($mentor);
    }

    public function getAll()
    {
        $mentors = Mentor::all();
        return response()->json(ControllerResponses::getAllModelResponse($mentors));
    }

    public function getById(int $id): MentorResource
    {
        $mentor = self::findMentor($id, false);
        return new MentorResource($mentor);
    }

    public function remove(int $id)
    {
        self::findMentor($id)->delete();

        return response()->json(ControllerResponses::deletedResponse("Mentor"));
    }
}
