#!/bin/bash
# author: Aivars Lauzis
# email: lauzis@inbox.lv

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
settingsfile=$DIR"/settings.cfg";


#checks if settings file exists if not exits
if [ -f "$settingsfile" ]
then
	source $settingsfile
else
	echo ERR:1 Settings file $settingsfile not found... sorry, can not continue...
	echo HELP: Copy the example config and adjust the paramters in the config
	exit
fi

declare -i counter=0;
declare -i max_iterations=$settings_iterations;

preset=""
if [[ "$settings_desktop_mode" == 1 ]]
then
  preset="--preset=desktop"
fi

url=$settings_url_to_test;

echo "Running test on:" $url;

while [[ $counter -lt $max_iterations ]]; do
  counter+=1;
  echo "------"$counter"/"$max_iterations"------";
  #echo $url --quiet --chrome-flags="--headless" --output=json $preset --output-path=$reports_dir$counter-report.json
  lighthouse $url  --quiet --chrome-flags="--headless" --output=json $preset --output-path=$reports_dir$counter-report.json
  sleep $sleep_time_between_requests;
done

echo "Reports saved in:" $reports_dir;

php $DIR"/get-results.php";

exit;
