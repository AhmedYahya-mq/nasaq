<?php

namespace App\Traits;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\SvgWriter;

trait ProfileQrCode
{
    /**
     * Generate QR code PNG for the user's profile link
     *
     * @return string Binary PNG data
     */
    public function profileQrCodePng(): string
    {
        $url = $this->profile_link ?? '#';

        $builder = new Builder(
            writer: new PngWriter(),
            data: $url,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Low,
            size: 300,
            margin: 0,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255),
            logoPath: __DIR__ . '/../../public/favicon.ico',
            logoResizeToWidth: 50,
            logoPunchoutBackground: true,
        );

        $result = $builder->build();
        return $result->getDataUri();
    }

    /**
     * Generate QR code SVG for the user's profile link
     *
     * @return string SVG string
     */
    public function profileQrCodeSvg(): string
    {
        $url = $this->profile_link ?? '#';

        $builder = new Builder(
            writer: new SvgWriter(),
            writerOptions: [
                SvgWriter::WRITER_OPTION_EXCLUDE_XML_DECLARATION => true
            ],
            data: $url,
            encoding: new Encoding('UTF-8'),
            size: 192,
            margin: 0,
        );

        $result = $builder->build();

        return $result->getString();
    }



}
