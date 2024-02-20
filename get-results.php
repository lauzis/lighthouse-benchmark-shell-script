<?php

$dir = scandir("./reports/");

$total_timings = [];
$first_paint_timings = [];
$largest_paint_timings = [];

foreach($dir as $file){
    if (substr_count($file,".json")>0){
        $data = json_decode(file_get_contents("./reports/".$file));
        $total = $data->timing->total;
        $first = $data->audits->{"first-contentful-paint"}->numericValue;
        $largest = $data->audits->{"largest-contentful-paint"}->numericValue;
        $total_timings[] = $total;
        $first_paint_timings[] = $first;
        $largest_paint_timings[] = $largest;
        print("$first $largest $total\n");
    }
}
print("\n");
print("------------------------\n");

if (count($total_timings)){
    print("First Contentful Paint Total   :".(array_sum($first_paint_timings)/count($total_timings))."\n");
    print("Largest Contentful Paint Total :".(array_sum($largest_paint_timings)/count($total_timings))."\n");
    print("Total page load                :".(array_sum($total_timings)/count($total_timings))."\n");
    print("------------------------\n");
} else {
    print("Average: No average, no iterations \n");
    print("------------------------\n");
}

