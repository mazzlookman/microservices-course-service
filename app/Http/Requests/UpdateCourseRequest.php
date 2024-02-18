<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCourseRequest extends FormRequest
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
            "name" => "string",
            "certificate" => "boolean",
            "thumbnail" => "url",
            "type" => "string|in:free,premium",
            "status" => "string|in:draft,published",
            "price" => "integer",
            "level" => "string|in:all,beginner,intermediate,advanced",
            "description" => "string",
            "mentor_id" => "integer"
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
