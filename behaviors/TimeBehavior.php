<?php

namespace app\behaviors;

use yii\base\Behavior;

class TimeBehavior extends Behavior
{
    public function getTimeDiff($time): string
    {
        if ($time >= 60) {
            if ($time >= 1440) {
                $days = (int)($time / 1440);

                return "$days days ago";
            } else {
                $hours = (int)($time / 60);
                $minutes = $time - $hours * 60;

                return $hours . "hr " . $minutes . "min ago";
            }
        }

        return "$time min ago";
    }
}
