<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMentorRequest;
use App\Http\Requests\UpdateMentorRequest;
use App\Http\Resources\MentorResource;
use App\Models\Mentor;
use Illuminate\Http\Exceptions\HttpResponseException;

class MentorController extends Controller
{
    public static function findMentor(int $id): Mentor
    {
        $mentor = Mentor::find($id,["id"]);
        if (!$mentor){
            throw new HttpResponseException(response([
                "code" => 404,
                "status" => "Not Found",
                "errors" => [
                    "message" => "Mentor not found"
                ]
            ], 404));
        }

        return $mentor;
    }

    public function create(CreateMentorRequest $request): MentorResource
    {
        $data = $request->validated();

        if (Mentor::where("email", $data["email"])->count() === 1) {
            throw new HttpResponseException(response([
                "code" => 409,
                "status" => "Conflict",
                "errors" => [
                    "message" => "Email already exists"
                ]
            ], 409));
        }

        $mentor = Mentor::create($data);

        return new MentorResource($mentor);
    }

    public function update(UpdateMentorRequest $request, int $id): MentorResource
    {
        $data = $request->validated();

        $mentor = self::findMentor($id);
        $mentor->fill($data)
            ->save();

        return new MentorResource($mentor);
    }

    public function getAll()
    {
        $mentors = Mentor::all();
        return response([
            "code" => 200,
            "status" => "OK",
            "data" => $mentors
        ]);
    }

    public function getById(int $id): MentorResource
    {
        $mentor = self::findMentor($id);
        return new MentorResource($mentor);
    }

    public function remove(int $id)
    {
        self::findMentor($id)->delete();

        return response([
            "code" => 200,
            "status" => "OK",
            "data" => [
                "message" => "Mentor has been deleted"
            ]
        ]);
    }
}
