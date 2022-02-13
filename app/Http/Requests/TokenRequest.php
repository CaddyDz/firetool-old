<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;

class TokenRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize(): bool
	{
		return auth()->guest();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules(): array
	{
		return [
			'phone' => ['required', 'string', new Phone],
			'password' => 'required',
			'device_name' => 'required',
			'number' => 'required|integer|in:1,2',
		];
	}
}
