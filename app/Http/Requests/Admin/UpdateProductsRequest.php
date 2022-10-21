<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductsRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|alpha_spaces',
            'category' => 'required|numeric',
            'description' => 'required|regex:/^[a-zA-Z0-9\s.\'\,\;\.\?]+$/',
            'price' => 'required|regex:/^(\d{1,8})\.(\d{2})$/',
            'weight' => 'required|regex:/^\d*\.?\d*$/',
            'image' => 'required_without:upload|url',
            'upload' => 'required_without:image|image',
            'thumbnail' => 'url'
        ];
    }
}
