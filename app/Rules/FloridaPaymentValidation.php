<?php

namespace App\Rules;

use App\Models\PaymentType;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class FloridaPaymentValidation implements DataAwareRule,ValidationRule
{

     /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected $data = [];

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $data = $this->data;
        
        if(intval($data['payment_type_id']) == PaymentType::SALARY && intval($data['pay_rate']) < 480){
            $fail("All employees in the state of Florida must be paid min $480 per check");
        }

        if(intval($data['payment_type_id']) == PaymentType::HOURS && intval($data['pay_rate']) < 12){
            $fail("All employees in the state of Florida must be paid min $12 per hour");
        }

    }

        /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;
 
        return $this;
    }
}
