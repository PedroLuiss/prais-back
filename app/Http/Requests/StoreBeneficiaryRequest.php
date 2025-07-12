<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreBeneficiaryRequest extends FormRequest
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
        // Mapeamos los campos del formulario a las reglas de validación
        return [
            // Datos Primarios
            'device_id' => 'required|integer|exists:devices,id',

            // Datos Beneficiario
            'run' => 'required|integer',
            'verification_digit' => 'required|string|max:1',
            'first_names' => 'required|string|max:255',
            'primary_last_name' => 'required|string|max:255',
            'secondary_last_name' => 'nullable|string|max:255',
            'gender' => 'required|string|max:50',
            'birth_date' => 'required|date',
            'email' => 'nullable|email|max:255|unique:beneficiaries,email',
            'phone_numbers' => 'nullable|string|max:255',
            'region' => 'required|string|max:255',
            'commune' => 'required|string|max:255',
            'street_name' => 'required|string|max:255',
            'street_number' => 'nullable|string|max:50',
            'department_number' => 'nullable|string|max:50',
            'civil_status' => 'required|string|max:100',
            'education_level' => 'nullable|string|max:100',
            'health_insurance' => 'required|string|max:100',
            'valech_listed' => 'required|boolean', // El frontend debería enviar true/false
            'exonerated_listed' => 'required|boolean',
            'accreditation_date' => 'nullable|date',
            'device_entry_date' => 'required|date',
            'has_prais_fonasa_mark' => 'required|boolean',

            // Relación con la víctima
            'relationship_with_victim' => 'required|string|max:100',

            // Datos Victima
            'index_run' => 'nullable|integer',
            'index_verification_digit' => 'nullable|string|max:1',
            'rettig_law_victim_full_name' => 'nullable|string|max:255',

            // Observaciones
            'relevant_observation' => 'nullable|string',

            // Relación Many-to-Many
            // Asumimos que el frontend enviará un array con los IDs de las situaciones represivas
            'repressive_situation_ids' => 'sometimes|array',
            'repressive_situation_ids.*' => 'integer|exists:repressive_situations,id',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Errores de validación',
            'errors'      => $validator->errors()
        ], 422));
    }
}
