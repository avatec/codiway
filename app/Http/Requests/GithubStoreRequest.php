<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\GithubRepoUrl;

class GithubStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string' , 'max:255' , 'required'],
            'url' => ['string' , 'required', new GithubRepoUrl],
            'rank' => ['int' , 'required', 'min:1','max:4']
        ];
    }
}
