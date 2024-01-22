<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thrill Data Calendar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .separation {
            border-left: 5px solid #dddddd;
        }

        .gradient-score {
            background-color: #ccffcc; /* Default green */
        }

        .gradient-0    {background-color: rgba(0, 135, 6, 1);}
        .gradient-10   {background-color: rgba(0, 135, 6, .7);}
        .gradient-20   {background-color: rgba(0, 135, 6, .5);}
        .gradient-30   {background-color: rgba(255, 136, 0, .7);}
        .gradient-40   {background-color: rgba(255, 0, 0, .5);}
        .gradient-50   {background-color: rgba(255, 0, 0, .7);}
        .gradient-60   {background-color: rgba(255, 0, 0, 1);}
        .gradient-70   {background-color: rgba(255, 0, 0, 1);}
        .gradient-80   {background-color: rgba(255, 0, 0, 1);}
        .gradient-90   {background-color: rgba(255, 0, 0, 1);}
        .gradient-100  {background-color: rgba(255, 0, 0, 1);}
    </style>
</head>
<body>
<h1>Thrill Data Calendar (2024)</h1>
<?php

$params = array(
    "api_key" => "tGa-zibffSpW",
  );
  
  $options = array(
    'http' => array(
      'method' => 'POST',
      'header' => 'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
      'content' => http_build_query($params)
    )
  );
  
  $context = stream_context_create($options);
  $result = file_get_contents('https://parsehub.com/api/v2/projects/tpOPa3_OsVVW/run', false, $context);

$params = http_build_query(array(
    "api_key" => "tGa-zibffSpW",
    "format" => "json"
));

$result = file_get_contents(
    'https://www.parsehub.com/api/v2/projects/tpOPa3_OsVVW/last_ready_run/data?' . $params,
    false,
    stream_context_create(array(
        'http' => array(
            'method' => 'GET'
        )
    ))
);

$decoded = gzdecode($result);
$data = json_decode($decoded, true);

if (!$data) {
    echo "Error retrieving data from ParseHub.";
} else {
    $thrillUrls = $data['thrill_urls'];
    $scores = [];
    $averages = [];
    $dates = [];
    $weeklyAverages = [];

    // Calculate average scores
    foreach ($thrillUrls as $thrillUrl) {
        foreach ($thrillUrl['box'] as $box) {
            $date = $box['date'];
            $score = (int)$box['score'];
            $scores[$date][] = $score;
        }
    }

    // Display the calendar
    echo '<table>';
    echo '<tr><th>Monday</th><th>Tuesday</th><th>Wednesday</th><th>Thursday</th><th>Friday</th><th>Saturday</th><th>Sunday</th><th class="separation">Weekly Avg</th></tr>';

    $rowCounter = 0;
    $daysInRow = 7;

    foreach ($scores as $date => $scoreArray) {
        if ($rowCounter % $daysInRow == 0) {
            // Start a new row
            echo '<tr>';

            // Clean the weekly averages array
            $weeklyAverages = [];
        }

        $averageScore = array_sum($scoreArray) / count($scoreArray);
        $averages[$rowCounter] = $averageScore;
        $dates[$rowCounter] = $date;
        $weeklyAverages[] = $averageScore;
        $class = 'gradient-score gradient-' . floor($averageScore / 10) * 10;

        echo "<td class='{$class}'>";
        echo "<strong>{$date}</strong><br>{$averageScore}";
        echo '</td>';

        $rowCounter++;

        if ($rowCounter % $daysInRow == 0) {
            // Calculate and display the weekly average
            $weeklyAvg = array_sum($weeklyAverages) / count($weeklyAverages);

            // Echo the weekly average with 2 decimal places
            echo "<td class='separation gradient-score gradient-" . floor($weeklyAvg / 10) * 10 . "'>";
            echo round($weeklyAvg, 2);
            echo '</td>';

            // End the row
            echo '</tr>';
        }
    }

    // If there are remaining cells in the last row, fill with empty cells
    while ($rowCounter % $daysInRow != 0) {
        echo '<td></td>';
        $rowCounter++;
    }

    // Calculate and display the weekly average
    $weeklyAvg = array_sum($weeklyAverages) / count($weeklyAverages);

    // Echo the weekly average with 2 decimal places
    echo "<td class='separation gradient-score gradient-" . floor($weeklyAvg / 10) * 10 . "'>";
    echo round($weeklyAvg, 2);
    echo '</td></tr></table>';

    // Find the best week
    $lowestAvg = 100;

    for ($i = 0; $i <= count($averages) - 7; $i++) {
        $avg = array_sum(array_slice($averages, $i, 7)) / 7;
        $lowestAvg = min($lowestAvg, $avg);

        if ($avg == $lowestAvg) {
            $bestWeek = array_slice($dates, $i, 7);
        }
    }

    echo '<br><br>';
    echo '<strong>Best week (= ' . round($lowestAvg,2) . '):</strong> ' . implode(', ', $bestWeek)  .'.';

}
?>

</body>
</html>
