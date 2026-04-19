<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreKalenderProkerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'kegiatan_id' => 'required|integer|exists:kegiatans,id',
            'divisi_id' => 'nullable|integer|exists:divisis,id',
            'tgl_mulai' => 'required|date|date_format:Y-m-d',
            'tgl_selesai' => 'nullable|date|date_format:Y-m-d|after_or_equal:tgl_mulai',
            'warna' => 'nullable|regex:/^#[0-9A-F]{6}$/i',
            'is_publik' => 'boolean',
            'status' => 'nullable|string|in:scheduled,ongoing,completed,cancelled',
            'reminder_at' => 'nullable|date_format:Y-m-d H:i:s',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'kegiatan_id.required' => 'Kegiatan harus dipilih',
            'kegiatan_id.exists' => 'Kegiatan yang dipilih tidak valid',
            'tgl_mulai.required' => 'Tanggal mulai harus diisi',
            'tgl_mulai.date' => 'Format tanggal mulai tidak valid',
            'tgl_selesai.after_or_equal' => 'Tanggal selesai harus setelah tanggal mulai',
            'warna.regex' => 'Format warna harus berupa kode hex (#RRGGBB)',
            'status.in' => 'Status tidak valid',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Ensure boolean values are properly converted
        if ($this->has('is_publik') && is_string($this->is_publik)) {
            $this->merge([
                'is_publik' => filter_var($this->is_publik, FILTER_VALIDATE_BOOLEAN)
            ]);
        }

        // Set default status if not provided
        if (!$this->has('status')) {
            $this->merge(['status' => 'scheduled']);
        }
    }
}
