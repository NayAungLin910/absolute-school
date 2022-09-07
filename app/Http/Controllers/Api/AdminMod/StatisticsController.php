<?php

namespace App\Http\Controllers\Api\AdminMod;

use App\Http\Controllers\Controller;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function getData(Request $request)
    {
        $firstYear = "";
        $secondYear = "";
        if ($request->firstYear) {
            $firstYear = $request->firstYear;
        }
        if ($request->secondYear) {
            $secondYear = $request->secondYear;
        }

        $data = [];
        $totalFirstYear = 0;
        $totalSecondYear = 0;

        for ($i = 1; $i <= 12; $i++) {
            $monthNum  = $i;
            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
            $monthName = $dateObj->format('F');

            $fd = User::whereYear("created_at", "=", $firstYear)->whereMonth("created_at", "=", $monthNum)->count();
            $sd = User::whereYear("created_at", "=", $secondYear)->whereMonth("created_at", "=", $monthNum)->count();

            $totalFirstYear += $fd;
            $totalSecondYear += $sd;

            $data[] = [
                "name" => substr($monthName, 0, 3),
                $firstYear => $fd,
                $secondYear => $sd,
            ];
        }

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => [
                "data" => $data,
                "totalFirstYear" => $totalFirstYear,
                "totalSecondYear" => $totalSecondYear,
            ],
        ]);
    }
}
