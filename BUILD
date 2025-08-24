#!/bin/bash

set -e

#wget -c https://wordpress.org/wordpress-5.5.1.tar.gz
wget -c https://wordpress.org/wordpress-6.7.1.tar.gz

rm -rfv wp.php wordpress | awk ' { printf "." } '

tar xvf wordpress-6.7.1.tar.gz | awk ' { printf "." } '
echo

( cd wordpress; find -type f | php -r 'require "../" ."build.php";' ) > wp.php

ionice -c3 rm -rf wordpress &

echo ALL DONE.
