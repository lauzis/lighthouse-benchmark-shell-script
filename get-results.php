<?php

$dir = scandir("./reports/");

$total_timings = [];
$total_min = null;
$total_max = null;

$first_paint_timings = [];
$first_paint_min = null;
$first_paint_max = null;

$largest_paint_timings = [];
$largest_paint_min = null;
$largest_paint_max  = null;

$accessibility_scores = [];
$accessibility_min = null;
$accessibility_max = null;

$performance_scores = [];
$performance_min = null;
$performance_max = null;

$seo_scores = [];
$seo_min = null;
$seo_max = null;

$best_practices_scores = [];
$best_practices_min = null;
$best_practices_max = null;

$average_scores = [];
$average_min = null;
$average_max = null;

$html_sizes = [];
$css_sizes = [];
$js_sizes = [];



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
        $html_sizes[] = $data->audits->{'resource-summary'}->details->items[0]->transferSize;



        foreach ($data->audits->{'resource-summary'}->details->items as $item) {
            if ($item->resourceType === 'stylesheet') {
                $css_sizes[] = $item->transferSize;
            } elseif ($item->resourceType === 'script') {
                $js_sizes[] = $item->transferSize;
            }
        }


        print("$first $largest $total $score\n");
    }
}

$total_max = count($total_timings) ? max($total_timings) : null;
$total_min = count($total_timings) ? min($total_timings) : null;

$first_paint_max = count($first_paint_timings) ? max($first_paint_timings) : null;
$first_paint_min = count($first_paint_timings) ? min($first_paint_timings) : null;

$largest_paint_max = count($largest_paint_timings) ? max($largest_paint_timings) : null;
$largest_paint_min = count($largest_paint_timings) ? min($largest_paint_timings) : null;

$accessibility_max = count($accessibility_scores) ? max($accessibility_scores) : null;
$accessibility_min = count($accessibility_scores) ? min($accessibility_scores) : null;

$performance_max = count($performance_scores) ? max($performance_scores) : null;
$performance_min = count($performance_scores) ? min($performance_scores) : null;

$seo_max = count($seo_scores) ? max($seo_scores) : null;
$seo_min = count($seo_scores) ? min($seo_scores) : null;

$best_practices_max = count($best_practices_scores) ? max($best_practices_scores) : null;
$best_practices_min = count($best_practices_scores) ? min($best_practices_scores) : null;

print("\n");
print("------------------------\n");

if (count($total_timings)) {
    print("First Contentful Paint Total   :" . round(array_sum($first_paint_timings) / count($total_timings),2) . " | Min: $first_paint_min | Max: $first_paint_max\n");
    print("Largest Contentful Paint Total :" . round(array_sum($largest_paint_timings) / count($total_timings),2 ) . " | Min: $largest_paint_min | Max: $largest_paint_max\n");
    print("Total page load                :" . round(array_sum($total_timings) / count($total_timings),2) . " | Min: $total_min | Max: $total_max \n");
    print("Average Accessibility Score    :" . round(array_sum($accessibility_scores) / count($accessibility_scores),2) . " | Min: $accessibility_min | Max: $largest_paint_max\n");
    print("Average Performance Score      :" . round(array_sum($performance_scores) / count($performance_scores),2) . " | Min: $performance_min | Max: $performance_max\n");
    print("Average SEO Score              :" . round(array_sum($seo_scores) / count($seo_scores), 2) . " | Min: $seo_min | Max: $seo_max\n");
    print("Average Best Practices Score   :" . round(array_sum($best_practices_scores) / count($best_practices_scores), 2) . " | Min: $best_practices_min | Max: $best_practices_max\n");
    print("------------------------\n");
    print("Average HTML Size              :" . round(array_sum($html_sizes) / count($html_sizes) / 1024, 2) . " KB\n");
    print("Average CSS Size               :" . round(array_sum($css_sizes) / count($css_sizes) / 1024, 2) . " KB\n");
    print("Average JS Size                :" . round(array_sum($js_sizes) / count($js_sizes) / 1024, 2) . " KB\n");

    print("------------------------\n");
    print("Average Score      :" . (array_sum($average_scores) / count($average_scores)) . "\n");
    print("------------------------\n");
} else {
    print("Average: No average, no iterations \n");
    print("------------------------\n");
}

