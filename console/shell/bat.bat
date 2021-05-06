Rem This is for bat get url from site
set  start=0
set /a start0=%start%
set /a start1=%start%+10000

start cmd /k "php ../../yii bat/all --startId="%start0%
start cmd /k "php ../../yii bat/all --startId="%start1%

