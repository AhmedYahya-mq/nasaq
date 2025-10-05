<?php

namespace App\Rules\Card;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CardTypeRule implements ValidationRule
{
    protected ?string $detected = null;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $num = preg_replace('/\D/', '', (string)$value);

        if ($num === '' || !ctype_digit($num)) {
            $fail('رقم البطاقة غير صالح.');
            return;
        }

        // التحقق من طول الرقم
        $len = strlen($num);
        if ($len < 12 || $len > 19) {
            $fail('طول رقم البطاقة غير صالح.');
            return;
        }

        // فحص Luhn
        if (!$this->luhnCheck($num)) {
            $fail('رقم البطاقة غير صالح (فشل فحص Luhn).');
            return;
        }

        // كشف النوع
        $this->detected = $this->detectBrand($num);

        if (!in_array($this->detected, ['visa','mastercard','amex','mada','discover','jcb','maestro','unionpay','diners','unknown'], true)) {
            $fail('نوع أو رقم البطاقة غير مدعوم.');
            return;
        }
    }

    public function getDetected(): ?string
    {
        return $this->detected;
    }

    // ---------------- Helpers ----------------
    protected function luhnCheck(string $number): bool
    {
        $sum = 0;
        $alt = false;
        for ($i = strlen($number) - 1; $i >= 0; $i--) {
            $n = (int)$number[$i];
            if ($alt) {
                $n *= 2;
                if ($n > 9) $n -= 9;
            }
            $sum += $n;
            $alt = !$alt;
        }
        return ($sum % 10) === 0;
    }

    protected function detectBrand(string $num): string
    {
        if (preg_match('/^4\d{12,18}$/', $num)) return 'visa';
        if (preg_match('/^5[1-5]\d{14}$/', $num) || $this->inRangePrefix($num, 2221, 2720)) return 'mastercard';
        if (preg_match('/^3[47]\d{13}$/', $num)) return 'amex';
          $madaBins = [
            '440647','440795','446404','457865','968208','457997','636120','968201',
            '636121','417633','468540','468541','468542','468543','968203','446393',
            '588845','588846','529415','529416','529417','529418','529419','529420',
            '529741','529742','529743','529744','529745','529746','537767','548844',
            '554180','557606','968202','968205','968206','968207'
        ];
        if (in_array(substr($num,0,6), $madaBins,true)) return 'mada';
        return 'unknown';
    }

    protected function inRangePrefix(string $num,int $start,int $end,int $len=4): bool
    {
        if (strlen($num) < $len) return false;
        $prefix = (int) substr($num,0,$len);
        return $prefix >= $start && $prefix <= $end;
    }
}
