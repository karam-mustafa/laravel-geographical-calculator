<?php


namespace KMLaravel\GeographicalCalculator\Traits;


trait Areas
{
    public function getCenter()
    {
        if (!count($this->getPoints())) {
            return false;
        }

        $numCoords = count($this->getPoints());

        $X = 0.0;
        $Y = 0.0;
        $Z = 0.0;

        for ($i = 0; $i < count($this->getPoints()); $i++) {

            $lat = $this->getPoints()[$i]->lat * pi() / 180;
            $lon = $this->getPoints()[$i]->long * pi() / 180;

            $a = cos($lat) * cos($lon);
            $b = cos($lat) * sin($lon);
            $c = sin($lat);

            $X += $a;
            $Y += $b;
            $Z += $c;
        }

        $X /= $numCoords;
        $Y /= $numCoords;
        $Z /= $numCoords;

        $lon = atan2($Y, $X);
        $hyp = sqrt($X * $X + $Y * $Y);
        $lat = atan2($Z, $hyp);

        $newX = ($lat * 180 / pi());
        $newY = ($lon * 180 / pi());


        return [
            'lat' => $newX,
            'long' => $newY
        ];
    }
}
