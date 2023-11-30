<?php

namespace App\Services;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Margin\Margin;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;

class QrcodeService
{
    /**
     * @var BuilderInterface
     */
    protected $builder;

    public function __construct(BuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    public function qrcode($agence,$adresse,$number)
    {

        // set qrcode
        $result = $this->builder
            ->data("Agence : ".$agence.' '. " Adresse: ".$adresse.' '."Tel : ".' '.$number)
            ->encoding(new Encoding('UTF-8'))
            ->size(200)
            ->margin(10)
            ->build()
        ;


        //Save img png
        $result->saveToFile('QRcode/'.'agence'.$agence.'png');

        return $result->getDataUri();
    }
}