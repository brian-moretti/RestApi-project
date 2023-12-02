<?php

namespace App\Controllers;

use App\models\TotalTimeSaved;
use Core\Response;

class TotalTimeSavedControllers
{
    public function getSum()
    {
        $serviceTypeSum     = TotalTimeSaved::serviceTypeSum();
        $serviceProvidedSum = TotalTimeSaved::serviceProvidedSum();
        Response::get(200, ["Total time saved" => $serviceTypeSum, "Time saved per service" => $serviceProvidedSum]);
    }
}

?>