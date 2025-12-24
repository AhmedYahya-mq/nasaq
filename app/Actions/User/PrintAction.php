<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\ImageManager;
use Mpdf\Mpdf;

class PrintAction implements \App\Contract\Actions\PrintAction
{
    protected User $user;

    private const FORMAT_CER = [297, 210];
    private const FORMAT_CARD = [185.2, 105.8];

    private const VIEW_CARD = 'components.membership.card-pdf';
    private const VIEW_CER = 'components.membership.certificate-pdf';

    private const DEFAULT_FONT = 'tajawal';
    private const FONT_DIR = 'Tajawal';

    public function __construct()
    {
        $this->user = Auth::user();
        if (!$this->user) {
            abort(403, 'Unauthorized');
        }
    }

    /**
     * Render a view into a PDF response.
     *
     * @param string $view
     * @param array|int|string $format
     */
    protected function printPdf(string $view = self::VIEW_CER, array|int|string $format = self::FORMAT_CER, array $data = [])
    {
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $mpdf = $this->initMpdf($fontDirs, $fontData, $format);
        if ($view === self::VIEW_CER) {
            $watermarkPath = imageLogo();
            $mpdf->SetWatermarkImage(
                $watermarkPath,
                0.06,
                120,
                120,
                true,
                'L'
            );
            $mpdf->showWatermarkImage = true;
        }
        $html = view($view, array_merge(['user' => $this->user], $data))->render();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('certificate.pdf', 'S');
    }

    /**
     * Build the membership card image and return PNG binary.
     *
     * @return string
     */
    protected function printImage(): string
    {
        $manager = new ImageManager(new Driver());
        // 1) الخلفية
        $card = $manager->read(public_path('card.png'));
        if ($this->user->photo === null) {
            $profileUrl = $this->user->profile_photo_url . '&format=png&size=300';
            $profile = makeCircularWithShadow(($profileUrl));
        } else {
            $profile = makeCircularWithShadow(public_path('storage/' . $this->user->photo));
        }
        $card->place($profile, 'top-right', 165, 110);
        // 3) QR Code
        $qrCode = $manager->read(file_get_contents($this->user->profileQrCodePng()))->cover(180, 180);
        $card->place(
            $qrCode,
            'bottom-right',
            220,
            120
        );
        // 4) اسم المستخدم (عربي)
        $card->text($this->user->getTranslatedName('en'), 810, 120, function ($font) {
            $font->file(public_path('fonts/' . self::FONT_DIR . '/Tajawal-Black-Regular.ttf'));
            $font->size(32);
            $font->color('#5f652c');
            $font->align('right');
        });
        // 5) نوع العضوية
        $card->text($this->user->getMembershipNameAttribute('en'), 810, 210, function ($font) {
            $font->file(public_path('fonts/' . self::FONT_DIR . '/Tajawal-Regular.ttf'));
            $font->size(28);
            $font->color('#5f652c');
            $font->align('right');
        });
        // 6) رقم العضوية
        $card->text($this->user->id, 755, 375, function ($font) {
            $font->file(public_path('fonts/' . self::FONT_DIR . '/Tajawal-Black-Regular.ttf'));
            $font->size(25);
            $font->color('#5f652c');
            $font->align('right');
        });
        $card->text($this->user->created_at->format('d/m/Y'), 390, 375, function ($font) {
            $font->file(public_path('fonts/' . self::FONT_DIR . '/Tajawal-Black-Regular.ttf'));
            $font->size(25);
            $font->color('#5f652c');
            $font->align('right');
        });
        $card->text($this->user->membership_status->getLabel(), 755, 540, function ($font) {
            $font->file(public_path('fonts/' . self::FONT_DIR . '/Tajawal-Black-Regular.ttf'));
            $font->size(25);
            $font->color('#5f652c');
            $font->align('right');
        });
        $card->text($this->user->membership_started_at->format('d/m/Y') . ' - ' . $this->user->membership_expires_at->format('d/m/Y'), 390, 540, function ($font) {
            $font->file(public_path('fonts/' . self::FONT_DIR . '/Tajawal-Black-Regular.ttf'));
            $font->size(25);
            $font->color('#5f652c');
            $font->align('right');
        });
        return $card->toPng();
    }

    /**
     * Print membership card as image or PDF.
     *
     * @param string $format 'image' or other
     * @return Response
     */
    public function printCard(string $format): Response
    {
        $img = $this->printImage();
        if ($format === 'image') {
            //
            return response($img)->header('Content-Type', 'image/png')->header('Content-Disposition', 'attachment; filename="membership-card.png"');
        }
        $pdf = $this->printPdf(self::VIEW_CARD, self::FORMAT_CARD, ['img' => $img]);
        return response($pdf)->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="membership-card.pdf"');
    }

    /**
     * Print certificate (PDF).
     *
     * @param mixed $format
     * @return Response
     */
    public function printCertifi(string $format): Response
    {
         $pdf = $this->printPdf(self::VIEW_CER, self::FORMAT_CER);
         if($format === 'pdf'){
            return response($pdf)->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="membership-certificate.pdf"');
         }
         $manager = new ImageManager(new Driver());
         $image = $manager->read(
            'data:image/png;base64,' . base64_encode($pdf)
         )->encode(new PngEncoder());
         return response($image)->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="membership-certificate.png"');
    }


    protected function initMpdf(array $fontDirs = [], array $fontData = [], array|int|string $format = self::FORMAT_CER): Mpdf
    {
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => $format,
            'default_font' => self::DEFAULT_FONT,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_left' => 0,
            'margin_right' => 0,
            'fontDir'  => array_merge($fontDirs, [storage_path('app/public/fonts/')]),
            'fontData' => $fontData + [
                self::DEFAULT_FONT => [
                    'R' => self::FONT_DIR . '/Tajawal-Regular.ttf',
                    'B' => self::FONT_DIR . '/Tajawal-Black-Regular.ttf',
                    'useOTL' => 255,
                    'useKashida' => 75,
                ],
            ],
        ]);
        return $mpdf;
    }
}
