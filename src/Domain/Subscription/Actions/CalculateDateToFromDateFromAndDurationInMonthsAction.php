<?php

namespace Domain\Subscription\Actions;

use Carbon\Carbon;

class CalculateDateToFromDateFromAndDurationInMonthsAction
{
    public function __invoke(Carbon $dateFrom, int $durationInMonths): Carbon
    {
        return $dateFrom->copy()->addMonths($durationInMonths)->subDay();
    }
}
