<?php

class ChartService {

    //lineChartAggregation Param format
    //$data -> [{date: 2024-09-01, value: 200}, {date: 2024-09-01, value: 200}, ...]
    public function lineChartAggregation($data) {
        if (empty($data)) {
            return [
                'labels' => "",
                'data' => ""
            ];
        }

        $noOfDays = count($data);
        
        $labels = array();
        $values = array();

        if ($noOfDays <= 90) {
            foreach ($data as $d) {
                //Change Date formet 2024-09-01 to Sep 01
                $date = new DateTime($d['date']);
                $labels[] = $date->format('M d');
                $values[] = $d['value'];
            }

            return [
                'labels' => $labels,
                'data' => $values
            ];
        } elseif ($noOfDays > 90 && $noOfDays <= 730) {
            $date = new DateTime($data[0]['date']);
            $monthEndDate = $date->modify('last day of this month');
            $value = 0;
            foreach ($data as $d) {
                $currentDate = new DateTime($d['date']);

                if($currentDate <= $monthEndDate) {
                    $value = $value + $d['value'];
                } else {
                    $labels[] = $monthEndDate->format('M');
                    $values[] = $value;

                    $value = 0;
                    $monthEndDate = $currentDate->modify('last day of this month');

                    $value += $d['value'];
                }
            }
            $labels[] = $monthEndDate->format('M');
            $values[] = $value;

            return [
                'labels' => $labels,
                'data' => $values
            ];
        } else {
            $date = new DateTime($data[0]['date']);
            $yearEndDate = $date->modify('last day of December this year');
            $value = 0;
            foreach ($data as $d) {
                $currentDate = new DateTime($d['date']);

                if($currentDate <= $yearEndDate) {
                    $value = $value + $d['value'];
                } else {
                    $labels[] = $yearEndDate->format('Y');
                    $values[] = $value;

                    $value = 0;
                    $yearEndDate = $currentDate->modify('last day of this month');

                    $value += $d['value'];
                }
            }
            $labels[] = $yearEndDate->format('Y');
            $values[] = $value;

            return [
                'labels' => $labels,
                'data' => $values
            ];
        }
    }
}

// $service = new ChartService();
// $data = [['date' => '2024-09-01', 'value' => 200], ['date' => '2024-09-02', 'value' => 300], ['date' => '2025-10-02', 'value' => 600], ['date' => '2025-10-15', 'value' => 400]];
// echo json_encode($service->lineChartAggregation($fromDate, $toDate, $data));


