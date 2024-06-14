<?php

$dir = scandir("./reports/");

$total_timings = [];
$first_paint_timings = [];
$largest_paint_timings = [];
$accessibility_scores = [];
$performance_scores = [];
$seo_scores = [];
$best_practices_scores = [];
$average_scores = [];

foreach ($dir as $file) {
    if (substr_count($file, ".json") > 0) {
        $data = json_decode(file_get_contents("./reports/" . $file));
        $total = $data->timing->total;
        $first = $data->audits->{"first-contentful-paint"}->numericValue;
        $largest = $data->audits->{"largest-contentful-paint"}->numericValue;
        $performance = $data->categories->performance->score;
        $seo = $data->categories->seo->score;
        $accessibility = $data->categories->accessibility->score;
        $best_practices = $data->categories->{'best-practices'}->score;
        $score = ($performance + $seo + $accessibility + $best_practices) / 4;
        $total_timings[] = $total;
        $first_paint_timings[] = $first;
        $largest_paint_timings[] = $largest;
        $average_scores[] = $score;
        $accessibility_scores[] = $accessibility;;
        $performance_scores[] = $performance;
        $seo_scores[] = $seo;
        $best_practices_scores[] = $best_practices;
        print("$first $largest $total $score\n");
    }
}
print("\n");
print("------------------------\n");

if (count($total_timings)) {
    print("First Contentful Paint Total   :" . (array_sum($first_paint_timings) / count($total_timings)) . "\n");
    print("Largest Contentful Paint Total :" . (array_sum($largest_paint_timings) / count($total_timings)) . "\n");
    print("Total page load                :" . (array_sum($total_timings) / count($total_timings)) . "\n");
    print("Average Accessibility Score    :" . (array_sum($accessibility_scores) / count($accessibility_scores)) . "\n");
    print("Average Performance Score      :" . (array_sum($performance_scores) / count($performance_scores)) . "\n");
    print("Average SEO Score              :" . (array_sum($seo_scores) / count($seo_scores)) . "\n");
    print("Average Best Practices Score   :" . (array_sum($best_practices_scores) / count($best_practices_scores)) . "\n");

    print("------------------------\n");
    print("Average Score      :" . (array_sum($average_scores) / count($average_scores)) . "\n");
    print("------------------------\n");
} else {
    print("Average: No average, no iterations \n");
    print("------------------------\n");
}

