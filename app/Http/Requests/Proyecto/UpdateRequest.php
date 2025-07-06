<?php

namespace App\Http\Requests\Proyecto;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // regla para verificar permiso 
        return auth()->user()->hasAnyRole(['Administrador', 'Coordinador']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Reglas de validación
            'nombre_proyecto' => ['required', 'string', 'max:255', 'regex:/^\S.*$/', Rule::unique('proyectos', 'nombre_proyecto')->ignore($this->route('id'), 'id_proyecto')], // Ignorar el proyecto actual
            'descripcion_proyecto' => 'required|string|max:1000',
            'lugar' => 'required|string|max:255', 
            'horas_requeridas' => 'required|integer|min:0|max:500',
            'seccion_id' => 'required|exists:secciones,id_seccion',
        ];
    }

    /**
     * Custom attribute names for error messages.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            // Nombres de atributos
            'nombre_proyecto' => 'Nombre del proyecto', 
            'descripcion_proyecto' => 'Descripción del proyecto', 
            'lugar' => 'Ubicación del proyecto', 
            'horas_requeridas' => 'Horas requeridas',
            'seccion_id' => 'Sección',
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */

    public function messages(): array
    {
        return [
            // mensajes de error
            'nombre_proyecto.required' => 'El nombre del proyecto es obligatorio.',
            'nombre_proyecto.unique' => 'Ya existe un proyecto con este nombre, prueba con otro por favor.',
            'descripcion_proyecto.required' => 'La descripción del proyecto es obligatoria.',
            'horas_requeridas.required' => 'Indique las horas requeridas.',
            'horas_requeridas.min' => 'Minimo de :attribute de 100 hrs.',
            'horas_requeridas.max' => 'Maximo de :attribute de 500 hrs.',
            'lugar.required' => 'La ubicación del proyecto es obligatoria.',
            'seccion_id.required' => 'Seleccione una sección para el proyecto.',
        ];
    }
}
