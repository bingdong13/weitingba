#!/bin/bash

backupDbDir=/app/backup/db

mysqldump -uroot -pcsmysql weitingba > $backupDbDir/weitingba`date -d "-1 days" +%Y%m%d`.sql

find $backupDbDir/ -type f -mtime +30 -exec rm {} \; >/dev/null 2>&1