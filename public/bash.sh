#!/usr/bin/sh
/usr/bin/python3 /var/www/laravel/record/public/server.py > /dev/null 2>&1 &
/usr/bin/python3 /var/www/laravel/record/public/cabinet.py > /dev/null 2>&1 &
