#!/bin/sh

echo 'collecting (Queries, Threads_connected, Threads_running) from mysql every second......'
echo 'press CTRL+C to exit.'
while true
do
   mysqladmin -uroot ext | awk '/Queries/{q=$4} /Threads_connected/{c=$4} /Threads_running/{r=$4} END{printf "%d  %d  %d\n", q,c,r}' >> status.txt
   sleep 1
done

