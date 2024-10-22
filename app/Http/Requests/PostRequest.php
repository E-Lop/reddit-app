<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostRequest extends FormRequest
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
        $routeName = $this->route()->getActionMethod();

        if ($routeName === 'redditHome') {
            return $this->redditHome();
        }


        return match ($this->method()) {
            'POST' => $this->store(),
            'PUT', 'PATCH' => $this->update(),
            'DELETE' => $this->destroy(),
            default => $this->index()
        };
    }

    public function index()
    {
        return [
            'order_by' => 'nullable|string',
            'filter_text' => 'nullable|string',
            'flair_id' => 'nullable|numeric',
            'per_page' => 'nullable|numeric',
            'current_page' => 'nullable|numeric',
        ];
    }

    public function redditHome()
    {
        return [
            'order_by' => 'nullable|string'
        ];
    }

    public function store()
    {
        return [
            'title' => 'required|string',
            'body' => 'required|string',
            'subreddit_id' => 'required|numeric',
            'image' => 'nullable|string',
            'url' => 'nullable|url',
            'flair_id' => 'nullable|numeric',
        ];
    }

    public function update()
    {
        return [
            'title' => 'nullable|string',
            'body' => 'nullable|string',
            'image' => 'nullable|string',
            'url' => 'nullable|url',
            'subreddit_id' => 'nullable|numeric',
            'flair_id' => 'nullable|numeric',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ], 422));
    }
}
