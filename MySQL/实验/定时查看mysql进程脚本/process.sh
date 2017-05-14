#!/bin/sh

echo 'Verify that the PROFILING is open in mysql? ';
echo "press any key to start"
read
echo 'Collecting mysql process status every millisecond......'
echo 'press CTRL+C to exit.'
while true
do
    mysql -uroot -e 'show processlist \G' | grep State >> process.txt
    usleep 100000
done

