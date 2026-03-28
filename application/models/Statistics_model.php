<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistics_model extends CI_Model {

    public function get_statistics($from, $to)
    {
        $from_datetime = $from . ' 00:00:00';
        $to_datetime   = $to   . ' 23:59:59';

        $sql = "
            SELECT 
                c.category_name AS website,
                DATE(p.product_datetime) AS stat_date,
                COUNT(p.product_id) AS total
            FROM tbl_product p
            LEFT JOIN tbl_category_dmtin c 
                ON c.id = p.product_category
            WHERE p.product_datetime BETWEEN ? AND ?
            GROUP BY website, stat_date
        ";

        return $this->db->query($sql, [$from_datetime, $to_datetime])
                        ->result_array();
    }
}