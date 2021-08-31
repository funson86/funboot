# crontab检查队列监听进程是否一直在  如果没有该进程，则后台执行
# * * * * *  . /etc/profile; sh /www/funboot/console/shell/queue.sh >> /home/centos/log/queue.log

#!/bin/sh
ps -ef|grep 'funboot/yii queue/listen' |grep -v grep
if [ $? -ne 0 ]
then
echo "start process..."
/usr/bin/php /www/funboot/yii queue/listen &
else
echo `date +"%Y-%m-%d %H:%M:%S"` "running..."
fi
