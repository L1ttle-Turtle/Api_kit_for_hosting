<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistics extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Statistics_model');
    }

    public function index()
    {
        header('Content-Type: application/json');

        $from = $this->input->get('from');
        $to   = $this->input->get('to');

        if (!$from || !$to) {
            $to   = date('Y-m-d');
            $from = date('Y-m-d', strtotime('-6 days'));
        }

        $raw = $this->Statistics_model->get_statistics($from, $to);

        // Tạo danh sách ngày
        $dates = [];
        $current = strtotime($from);
        $end = strtotime($to);

        while ($current <= $end) {
            $dates[] = date('Y-m-d', $current);
            $current = strtotime('+1 day', $current);
        }

        $dates = array_reverse($dates);

        $result = [];
        $today_total = 0;

        foreach ($raw as $row) {

            $website = $row['website'] ?? 'Không xác định';

            if (!isset($result[$website])) {
                $result[$website] = [
                    'website' => $website,
                    'stats' => array_fill_keys($dates, 0)
                ];
            }

            $result[$website]['stats'][$row['stat_date']] = (int)$row['total'];

            if ($row['stat_date'] == $dates[0]) {
                $today_total += (int)$row['total'];
            }
        }

        echo json_encode([
            "from" => $from,
            "to" => $to,
            "dates" => $dates,
            "today_total" => $today_total,
            "data" => array_values($result)
        ]);
    }
}