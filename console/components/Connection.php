<?php

namespace console\components;

use yii\db\mssql\PDO;

/**
 * Class Connection
 * @package console\components
 * @author funson86 <funson86@gmail.com>
 */
class Connection extends \yii\db\Connection
{
    public $attributes = [PDO::ATTR_PERSISTENT => true];

    private $stamp;

    public function createCommand($sql = null, $params = [])
    {
        try {
            // send ping on every 60 seconds
            if ($this->stamp < time()) {
                $this->stamp = time() + 60;
                parent::createCommand('DO 1')->execute();
            }
        } catch (\yii\db\Exception $e) {
            // if ping fail, reconnect
            $this->close();
            $this->open();
        }

        return parent::createCommand($sql, $params);
    }
}
