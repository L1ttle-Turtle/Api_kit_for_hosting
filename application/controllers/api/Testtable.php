<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testtable extends CI_Controller {

    public function index()
    {
        header('Content-Type: application/json');

        $from = '2026-02-05';
        $to   = '2026-02-11';

        $dates = [
            "2026-02-11",
            "2026-02-10",
            "2026-02-09",
            "2026-02-08",
            "2026-02-07",
            "2026-02-06",
            "2026-02-05"
        ];

        $data = [
            [
                "website" => "Manhantra.com",
                "stats" => [
                    "2026-02-11" => 1,
                    "2026-02-10" => 2,
                    "2026-02-09" => 2,
                    "2026-02-08" => 0,
                    "2026-02-07" => 1,
                    "2026-02-06" => 5,
                    "2026-02-05" => 7
                ]
            ],
            [
                "website" => "Hpnuts.com",
                "stats" => [
                    "2026-02-11" => 0,
                    "2026-02-10" => 2,
                    "2026-02-09" => 0,
                    "2026-02-08" => 1,
                    "2026-02-07" => 1,
                    "2026-02-06" => 8,
                    "2026-02-05" => 8
                ]
            ]
        ];

        echo json_encode([
            "from" => $from,
            "to" => $to,
            "dates" => $dates,
            "today_total" => 1326,
            "data" => $data
        ]);
    }
}