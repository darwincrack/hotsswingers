<?php

return [

  /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | El following language lines contain El default error messages used by
    | El validator class. Some of Else rules have multiple versions such
    | as El size rules. Feel free to tweak each of Else messages here.
    |
   */

  'accepted' => 'El :attribute debe ser aceptado.',
  'active_url' => 'El :attribute no es una URL válida',
  'after' => 'El :attribute debe ser una fecha posterior :date.',
  'alpha' => 'El :attribute solo puede contener letras.',
  'alpha_dash' => 'El :attribute solo puede contener letras, números y guiones.',
  'alpha_num' => 'El :attribute solo puede contener letras y números.',
  'array' => 'El :attribute debe ser una matriz.',
  'before' => 'El :attribute debe ser una fecha antes :date.',
  'between' => [
    'numeric' => 'El :attribute debe estar entre :min y :max.',
    'file' => 'El :attribute debe estar entre :min y :max kilobytes.',
    'string' => 'El :attribute debe estar entre :min y :max caracteres.',
    'array' => 'El :attribute debe tener entre :min y :max artículos.',
  ],
  'boolean' => 'El :attribute Debe ser verdadero o falso.',
  'confirmed' => 'El :attribute la confirmación no coincide.',
  'date' => 'El :attribute no es una fecha válida.',
  'date_format' => 'El :attribute no coincide con el formato :format.',
  'different' => 'El :attribute y :other debe ser diferente.',
  'digits' => 'El :attribute debe ser :digits dígitos.',
  'digits_between' => 'El :attribute debe estar entre :min y :max digitos.',
  'email' => 'El :attribute Debe ser una dirección de correo electrónico válida.',
  'exists' => 'El seleccionado :attribute no es válido.',
  'filled' => 'El :attribute es requerido.',
  'image' => 'El :attribute debe ser una imagen.',
  'in' => 'El seleccionado :attribute no es válido.',
  'integer' => 'El :attribute debe ser un entero.',
  'ip' => 'El :attribute debe ser una dirección IP válida.',
  'json' => 'El :attribute debe ser una cadena JSON válida.',
  'max' => [
    'numeric' => 'El :attribute puede no ser mayor que :max.',
    'file' => 'El :attribute puede no ser mayor que :max kilobytes.',
    'string' => 'El :attribute puede no ser mayor que :max characters.',
    'array' => 'El :attribute puede no ser mayor que :max items.',
  ],
  'mimes' => 'El :attribute debe ser un archivo de type: :values.',
  'min' => [
    'numeric' => 'El :attribute debe ser por lo menos :min.',
    'file' => 'El :attribute debe ser por lo menos :min kilobytes.',
    'string' => 'El :attribute debe ser por lo menos :min characters.',
    'array' => 'El :attribute debe tener al menos :min items.',
  ],
  'not_in' => 'El  :attribute seleccionado no es válido.',
  'numeric' => 'El :attribute tiene que ser un número.',
  'regex' => 'El :attribute el formato no es válido.',
  'required' => 'El :attribute es requerido.',
  'required_if' => 'El :attribute se requiere cuando :other is :value.',
  'required_unless' => 'El :attribute es requerido a menos que :other is in :values.',
  'required_with' => 'El :attribute es requerido cuando :values esta presente.',
  'required_with_all' => 'El :attribute se requiere cuando :values esta presente.',
  'required_without' => 'El :attribute se requiere cuando :values is not present.',
  'required_without_all' => 'El :attribute se requiere cuando nada de :values estan presente.',
  'same' => 'El :attribute y :other deben coincidir.',
  'size' => [
    'numeric' => 'El :attribute debe ser :size.',
    'file' => 'El :attribute debe ser :size kilobytes.',
    'string' => 'El :attribute debe ser :size characters.',
    'array' => 'El :attribute debe contener :size elementos.',
  ],
  'string' => 'El :attribute debe ser una cadena.',
  'timezone' => 'El :attribute debe ser una zona válida.',
  'unique' => 'El :attribute ya se ha tomado.',
  'url' => 'El :attribute el formato no es válido.',
  /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using El
    | convention "attribute.rule" to name El lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
   */
  'phone' => 'El :attribute debe ser un número de teléfono válido.',
  'hashmatch' => 'El :attribute debe coincidir con la contraseña de su cuenta.',
  'country' => 'El :attribute no es válido.',
  'state' => 'El :attribute no es válido.',
  'state_id' => ' El estado seleccionado no es válido.',
  'city' => 'El :attribute no es válido.',
  'city_id' => ' La ciudad seleccionada no es válida.',
  'custom' => [
    'emailReset' => [
      'exists' => 'El correo electrónico no existe',
    ],
  ],
  /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | El following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
   */
  'attributes' => [
  'emailReset' => 'correo electrónico'],
];
