#!/bin/bash

prodectDir=/app/www/weitingba_dev/uploads/
qiniuDir=/app/www/weitingba_dev/data/qiniu

$qiniuDir/qboxrsctl login bingdong13@msn.com QNhaizi@2014

for file in `awk '{print $1}' $qiniuDir/filelist.txt`
do
echo $file
	$qiniuDir/qboxrsctl get img-wtb $file /app/www/weitingba_dev/uploads/${file}
done


