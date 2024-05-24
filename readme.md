# Testing total load time for particular url
Had to test some page load time and get some overall performance.
So wrote small script that does lighthouse reports and then with a php script one can get average 
load time for particular page/url.

# What this actually does
Shell script - For x (20 is default) amount times runs lighthouse benchmark / speed test stores report
Php script - Collects load times and calculates the average of all iterations.

# Prerequisites 
Install these
* php (cli) https://www.php.net/
* node https://github.com/nodejs
  * npm https://github.com/npm/cli
  * lighthouse https://github.com/GoogleChrome/lighthouse

# Setup
Verify that you have everything we need in terminal
Do you have php cli?
> php -v

Do you have lighthouse
> lighthouse --version

Might be that you need to add executable flag to the script file
> chmod +x ./run-lighthouse-benchmark.sh

# Run
Run the benchmarks, wait till it is done
>./run-lighthouse-benchmark.sh

Get the results
> php get-results.php


# Change log

## Version 0.2
Fixed some default values. Was not possible to run the script.
As settings file had some variable naming differences

## Version 0.1
Initial push, MVP
