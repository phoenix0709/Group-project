#!/bin/bash
RANDOM=$(head /dev/urandom | tr -dc A-Za-z0-9 | head -c 5)
FLAG="CTF{admin_flag_${RANDOM}}"
echo "$FLAG" > /var/www/html/flag.txt
