# mysqldump备份数据库
# * * * * *  . /etc/profile; sh /www/funboot/console/shell/mysqlbackup.sh >> /home/centos/log/mysqlbackup.log
# 文件修改：增加密码  :%s/funboot/your/g

# 单独备份log修改部分 sqlName=log_$database   --ignore-table=funboot.fb_base_log替换为--tables fb_base_log

# !/bin/bash
# 备份文件存储目录
dumpDir='/www/funboot/console/runtime/mysqlbackup'
# mysqldump 命令
execMysql='/usr/local/mysql/bin/mysqldump'
# mysql 账号
username='root'
# mysql 密码
password=''
# mysql 主机地址
server='127.0.0.1'
# 单个数据库 如果要多个加空格不建议 如:funboot funboot1
database='funboot'

echo "start dump mysql db "$database
# 备份sql名称
sqlName=$database`date +%Y%m%d-%H%M%S`
echo $sqlName
mkdir -p $dumpDir
$execMysql -h $server -u$username -p$password $database --ignore-table=funboot.fb_base_log > $dumpDir/$sqlName.sql
echo "dump ok"

echo "start tar..."
# 压缩后的文件名
tarFileName=$sqlName.sql.tar.gz
cd $dumpDir/
tar zcf $tarFileName $sqlName.sql

# -f是判断压缩文件是否存在
if [ -f $tarFileName ]
then
rm -rf $sqlName.sql
fi

# 删除超过7天的备份数据，保留3个月里的 10号 20号 30号的备份数据
find $dumpDir/ -mtime +7 -name $database'*[1-9]-*.sql.tar.gz' -exec rm -rf {} \;
find $dumpDir/ -mtime +92 -name $database'*.sql.tar.gz' -exec rm -rf {} \;

echo "tar ok"

