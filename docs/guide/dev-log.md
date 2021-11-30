Log Component
-----------

Table of contents
- System Log
- Saving log to MongoDb

### 系统日志 

System log includes Operation Log, Error Log, Login Log, Database Log, Console Log, Mail Log 

- Operation Log for monitoring database table modification
- Error Log for system error, config log level including error warning info trace
- Login Log: record user login info of backend
- Database Log: some useful code self-defined by developer  
- Console Log: log in console. 
- Mail Log for recording email log


common/config/main.php
```
        'logSystem' => [
            'class' => 'common\components\base\LogSystem',
            'queue' => false,//true, // use queue to save log or not
            'driver' => 'mysql', //'mongodb', // driver, mysql or mongodb
            'levels' => ['error', 'warning'], // level of log: error warning info trace
            'ignoreCodes' => [404], // ignore code of log
        ],
```

### Save log in Mongodb

Refer to [High Concurrency & Performance](appendix-high.md) chapter Mongodb
