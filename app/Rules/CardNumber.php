<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CardNumber implements ValidationRule
{
    protected ?string $brand = null;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $num = preg_replace('/\D/', '', (string)$value);

        if ($num === '' || !ctype_digit($num)) {
            $fail('رقم البطاقة غير صالح.');
            return;
        }

        $len = strlen($num);
        if ($len < 12 || $len > 19) {
            $fail('طول رقم البطاقة غير صالح.');
            return;
        }

        if (! $this->luhnCheck($num)) {
            $fail('رقم البطاقة غير صالح (فشل فحص Luhn).');
            return;
        }

        $this->brand = $this->detectBrand($num);

        if (! $this->validLengthForBrand($num, $this->brand)) {
            $fail('رقم البطاقة غير صالح حسب نوع البطاقة.');
            return;
        }

        // منع أنواع غير مدعومة
        if (!in_array($this->brand, ['visa', 'mastercard', 'mada'], true)) {
            $fail('نوع البطاقة غير مدعوم.');
            return;
        }
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    // ---------------- helpers ----------------
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
        // MasterCard
        if (preg_match('/^5[1-5][0-9]{14}$/', $num) || $this->inRangePrefix($num, 2221, 2720)) return 'mastercard';
        // Visa
        if (preg_match('/^4[0-9]{12,18}$/', $num)) return 'visa';
        // Mada common BINs
        $madaBins = [
            "22337902","22337986","22402030","40177800","403024","40545400",
            "406136","406996","40719700","40728100","40739500","407520",
            "409201","410621","410685","410834","412565","417633","419593",
            "420132","421141","42222200","422817","422818","422819","428331",
            "428671","428672","428673","431361","432328","434107","439954",
            "440533","440647","440795","442429","442463","445564","446393",
            "446404","446672","45488707","45501701","455036","455708","457865",
            "457997","458456","462220","468540","468541","468542","468543",
            "474491","483010","483011","483012","484783","486094","486095",
            "486096","489318","489319","49098000","49098001","492464","504300",
            "513213","515079","516138","520058","521076","52166100","524130",
            "524514","524940","529415","529741","530060","531196","535825",
            "535989","536023","537767","53973776","543085","543357","549760",
            "554180","555610","558563","588845","588848","588850","604906",
            "636120","968201","968202","968203","968204","968205","968206",
            "968207","968208","968209","968211","968212"
        ];
        if (in_array(substr($num, 0, 6), $madaBins, true)) return 'mada';

        return 'unknown';
    }

    protected function inRangePrefix(string $num, int $start, int $end, ?int $prefixLen = null): bool
    {
        $prefixLen = $prefixLen ?? strlen((string)$start);
        if (strlen($num) < $prefixLen) return false;
        $p = (int) substr($num, 0, $prefixLen);
        return $p >= $start && $p <= $end;
    }

    protected function validLengthForBrand(string $num, string $brand): bool
    {
        $len = strlen($num);
        return match ($brand) {
            'visa' => in_array($len, [13, 16, 19]),
            'mastercard' => $len === 16,
            'mada' => $len === 16,
            default => $len >= 12 && $len <= 19,
        };
    }
}
