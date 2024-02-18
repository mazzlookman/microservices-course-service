<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|string",
            "certificate" => "required|boolean",
            "thumbnail" => "required|url",
            "type" => "required|string|in:free,premium",
            "status" => "required|string|in:draft,published",
            "price" => "integer",
            "level" => "required|string|in:all,beginner,intermediate,advanced",
            "description" => "string",
            "mentor_id" => "required|integer"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            "code" => 400,
            "status" => "Bad Request",
            "errors" => $validator->getMessageBag()
        ], 400));
    }
}
