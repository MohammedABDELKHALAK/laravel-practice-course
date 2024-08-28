<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //if you add **bail** it for stop from first rule does't support
        'title' => 'required|min:4|max:100',
        'content' => 'required|min:4|max:100',
        //for image you can add size of the image by using max and min 
        //you can also specify dimensions hieght and wieght by using this way for example (dimensions:min_height = 500)
        'picture' => 'image|mimes:jpeg,jpg,svg,png,gif'
        ];
    }
}
