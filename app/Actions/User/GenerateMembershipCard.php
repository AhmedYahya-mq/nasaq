<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;

class MembershipCardGenerator
{
    protected $user;
    protected $width = 600;
    protected $height = 350;
    protected $logoPath;
    protected $watermarkPath;
    protected $imageManager;

    public function __construct($user)
    {
        $this->user = $user;
        $this->logoPath = public_path('images/site-logo.png'); // شعار الموقع للـ QR
        $this->watermarkPath = public_path('images/watermark.png'); // علامة مائية
        $this->imageManager = new ImageManager(['driver' => 'gd']); // أو 'imagick' إذا مثبت
    }

    public function generate(): string
    {
        // إنشاء خلفية البطاقة
        $card = $this->imageManager->canvas($this->width, $this->height, '#f7f7f7');

        // تدرج لوني احترافي
        $gradient = $this->imageManager->canvas($this->width, $this->height)->fill('#4e54c8')->opacity(40);
        $card->insert($gradient, 'top-left');

        // العلامة المائية
        $this->insertWatermark($card);

        // باقي عناصر البطاقة
        $this->insertProfileImage($card);
        $this->insertUserName($card);
        $this->insertMembershipInfo($card);
        $this->insertMembershipDates($card);
        $this->insertQrCode($card);

        return $this->saveCard($card);
    }

    protected function insertProfileImage($card)
    {
        if ($this->user->profile_photo_url && file_exists(public_path($this->user->profile_photo_url))) {
            $profileImage = $this->imageManager->make($this->user->profile_photo_url)
                ->resize(120, 120)
                ->circle();
            $card->insert($profileImage, 'left', 40, 40);
        }
    }

    protected function insertUserName($card)
    {
        $card->text($this->user->name, 220, 60, function ($font) {
            $font->file(public_path('fonts/arial-bold.ttf'));
            $font->size(28);
            $font->color('#ffffff');
        });
    }

    protected function insertMembershipInfo($card)
    {
        $membershipText = $this->user->membership ? $this->user->membership->name : 'عضوية عادي';
        $statusText = $this->user->membership_status->label(); // Active / Pending / Expired
        $card->text("عضوية: {$membershipText} ({$statusText})", 220, 120, function ($font) {
            $font->file(public_path('fonts/arial.ttf'));
            $font->size(20);
            $font->color('#ffffff');
        });
    }

    protected function insertMembershipDates($card)
    {
        if ($this->user->membership_started_at && $this->user->membership_expires_at) {
            $dates = $this->user->membership_started_at->format('d/m/Y') . ' - ' . $this->user->membership_expires_at->format('d/m/Y');
            $card->text("تاريخ العضوية: {$dates}", 220, 160, function ($font) {
                $font->file(public_path('fonts/arial.ttf'));
                $font->size(16);
                $font->color('#ffffff');
            });
        }
    }

    protected function insertQrCode($card)
    {
        // شعار وسط QR
        $logo = Logo::create($this->logoPath)
            ->resizeToWidth(50)
            ->punchoutBackground();

        // توليد QR
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($this->user->uuid)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(120)
            ->logo($logo)
            ->build();

        $qrImage = $this->imageManager->make($result->getString());
        $card->insert($qrImage, 'bottom-right', 40, 40);
    }

    protected function insertWatermark($card)
    {
        if (file_exists($this->watermarkPath)) {
            $watermark = $this->imageManager->make($this->watermarkPath)
                ->resize($this->width / 2, null, fn($constraint) => $constraint->aspectRatio())
                ->opacity(20);
            $card->insert($watermark, 'center');
        }
    }

    protected function saveCard($card): string
    {
        $path = "cards/{$this->user->uuid}.png";
        Storage::disk('public')->put($path, (string)$card->encode('png'));
        return Storage::url($path);
    }
}
