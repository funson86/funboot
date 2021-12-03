FAQ
-------

Table of contents

- No write permission in linux
- Warning: Specified key was too long; max key length is 767 bytes
- No change in the frontend after modify the css file
- Class 'COM' not found
- com() has been disabled for security reasons
- Access website return 500, index.php cannot require root directory and other file
- curl url started with https:// error

### No write permission in linux

linux run with www account, no write permission in runtime directory, modify runtime directory permission

```
chmod 777 -R runtime
```


### Warning: Specified key was too long; max key length is 767 bytes

Funboot database use utf8mb4 by default, modify the table to utf8 or change varchar(255) to varchar(190) instead while using the field for indexs.


### No change in the frontend after modify the css file

The css file will be published in assets directory. Delete all files in /web/assets/ and /web/backend/assets/ after edit.


### Class 'COM' not found

- Only shown in Windows, check the php_com_dotnet.dll file existing in php ext directory.

- Add the code below in php.ini, then restart php-fpm

```
extension=php_com_dotnet.dll
```

- Start > Run > services.msc > Confirm COM+ Event System service running

### com() has been disabled for security reasons

Comment the disable_classes in php.ini, then restart php-fpm

```
; disable_classes = COM
```


### Access website return 500, index.php cannot require root directory and other file

While index.php is in /www/funboot/web directory, config /www/funboot/web/.user.ini is current directory by default. so index.php cannot require other php file in the root directory. 

Edit .user.ini file, change /www/funboot/web to /www/funboot

```
# chattr -i .user.ini

# vi .user.ini
open_basedir=/www/funboot:/tmp/:/proc/

# chattr +i .user.ini
```

### curl url started with https:// error

download CA file of https://curl.haxx.se/ca/cacert.pem to c:\ directory

Enabel ca in php.ini 

```
[curl]
; A default value for the CURLOPT_CAINFO option. This is required to be an
; absolute path.
curl.cainfo =c:\cacert.pem
```

Restart php-fpm or admin panel.
