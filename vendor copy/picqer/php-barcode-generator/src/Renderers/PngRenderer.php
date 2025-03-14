<?php

namespace Picqer\Barcode\Renderers;

use Imagick;
use ImagickDraw;
use ImagickPixel;
use Picqer\Barcode\Barcode;
use Picqer\Barcode\BarcodeBar;
use Picqer\Barcode\Exceptions\BarcodeException;

class PngRenderer
{
    protected array $foregroundColor = [0, 0, 0];
    protected bool $useImagick;

    /**
     * @throws BarcodeException
     */
    public function __construct()
    {
        // Auto switch between GD and Imagick based on what is installed
        if (extension_loaded('imagick')) {
            $this->useImagick = true;
        } elseif (function_exists('imagecreate')) {
            $this->useImagick = false;
        } else {
            throw new BarcodeException('Neither gd-lib or imagick are installed!');
        }
    }

    /**
     * Force the use of Imagick image extension
     */
    public function useImagick(): self
    {
        $this->useImagick = true;
        return $this;
    }

    /**
     * Force the use of the GD image library
     */
    public function useGd(): self
    {
        $this->useImagick = false;
        return $this;
    }

    public function render(Barcode $barcode, int $widthFactor = 2, int $height = 30): string
    {
        $width = (int)round($barcode->getWidth() * $widthFactor);

        if ($this->useImagick) {
            $imagickBarsShape = new ImagickDraw();
            $imagickBarsShape->setFillColor(new ImagickPixel('rgb(' . implode(',', $this->foregroundColor) .')'));
        } else {
            $image = $this->createGdImageObject($width, $height);
            $gdForegroundColor = \imagecolorallocate($image, $this->foregroundColor[0], $this->foregroundColor[1], $this->foregroundColor[2]);
        }

        // print bars
        $positionHorizontal = 0;
        /** @var BarcodeBar $bar */
        foreach ($barcode->getBars() as $bar) {
            $barWidth = (int)round(($bar->getWidth() * $widthFactor));

            if ($bar->isBar() && $barWidth > 0) {
                $y = (int)round(($bar->getPositionVertical() * $height / $barcode->getHeight()));
                $barHeight = (int)round(($bar->getHeight() * $height / $barcode->getHeight()));

                // draw a vertical bar
                if ($this->useImagick) {
                    $imagickBarsShape->rectangle($positionHorizontal, $y, ($positionHorizontal + $barWidth - 1), ($y + $barHeight));
                } else {
                    \imagefilledrectangle($image, $positionHorizontal, $y, ($positionHorizontal + $barWidth - 1), ($y + $barHeight), $gdForegroundColor);
                }
            }
            $positionHorizontal += $barWidth;
        }

        if ($this->useImagick) {
            $image = $this->createImagickImageObject($width, $height);
            $image->drawImage($imagickBarsShape);
            return $image->getImageBlob();
        } else {
            ob_start();
            $this->generateGdImage($image);
            return ob_get_clean();
        }
    }

    public function setForegroundColor(array $color): self
    {
        $this->foregroundColor = $color;
        
        return $this;
    }

    protected function createGdImageObject(int $width, int $height)
    {
        $image = \imagecreate($width, $height);
        $colorBackground = \imagecolorallocate($image, 255, 255, 255);
        \imagecolortransparent($image, $colorBackground);

        return $image;
    }

    protected function createImagickImageObject(int $width, int $height): Imagick
    {
        $image = new Imagick();
        $image->newImage($width, $height, 'none', 'PNG');

        return $image;
    }

    protected function generateGdImage($image): void
    {
        \imagepng($image);
        \imagedestroy($image);
    }
}
