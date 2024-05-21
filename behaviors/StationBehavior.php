<?php

namespace app\behaviors;

use yii\base\Behavior;
use yii\helpers\ArrayHelper;

class StationBehavior extends Behavior
{
    private array $landingPadSizes = [
        'Coriolis Starport' => 'L',
        'Ocellus Starport' => 'L',
        'Orbis Starport' => 'L',
        'Asteroid base' => 'L',
        'Outpost' => 'M',
        'Planetary Outpost' => 'L',
        'Planetary Port' => 'L',
        'Mega ship' => 'L',
        'Fleet Carrier' => 'L',
        'Odyssey Settlement' => 'S or L',
    ];

    /**
     * @return array
     */
    public function getLandingPadSizes(): array
    {
        return $this->landingPadSizes;
    }
}
