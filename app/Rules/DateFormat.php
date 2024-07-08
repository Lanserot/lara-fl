<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

class DateFormat implements ValidationRule
{
    public function validate($attribute, $value, $fail): void
    {
        if (!empty($value) && !preg_match('/^\d{4}-\d{2}-\d{2}$|^\d{2}-\d{2}-\d{4}$/', $value)) {
            $fail('The :attribute must be in YYYY-MM-DD or DD-MM-YYYY format.');
        }
    }
}
