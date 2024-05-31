<?php
// update_table.php

echo "boobyy";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get selected parks from the AJAX request
    $selectedParks = isset($_POST['parks']) ? $_POST['parks'] : [];

    // Echo selected parks for debugging
    echo "update_table.php: " . implode(', ', $selectedParks) . "<br>";

    // // Fetch data based on the selected parks
    // $params = http_build_query(array(
    //     "api_key" => "tGa-zibffSpW",
    //     "format" => "json"
    // ));

    // $result = file_get_contents(
    //     'https://www.parsehub.com/api/v2/projects/tpOPa3_OsVVW/last_ready_run/data?' . $params,
    //     false,
    //     stream_context_create(array(
    //         'http' => array(
    //             'method' => 'GET'
    //         )
    //     ))
    // );

    // $decoded = gzdecode($result);
    // $data = json_decode($decoded, true);

    // if (!$data) {
    //     echo "Error retrieving data from ParseHub.";
    // } else {
    //     // Filter data for selected parks
    //     $filteredData = array_filter($data['thrill_urls'], function ($thrillUrl) use ($selectedParks) {
    //         return in_array($thrillUrl['park'], $selectedParks);
    //     });

    //     // Continue with your existing logic to calculate averages and generate HTML
    //     // ...

    //     // Output the updated HTML for the calendar
    //     echo '<table>';
    //     // ... (your existing table generation logic)
    //     echo '</table>';
    // }
}

return;
