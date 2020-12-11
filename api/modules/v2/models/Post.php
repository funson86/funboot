<?php
namespace api\modules\v2\models;

use funson86\blog\models\BlogPost;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;

/**
 * Country Model
 *
 * @author Budi Irawan <deerawan@gmail.com>
 */
class Post extends BlogPost
{
    public function fields()
    {
        $fields = parent::fields();

        // remove fields that contain sensitive information
        //unset($fields['auth_key'], $fields['password_hash'], $fields['password_reset_token']);
        $fields[] = 'links';

        return $fields;
    }

    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['user/view', 'id' => $this->id], true),
        ];
    }

    public function extraFields()
    {
        return ['catalog'];
    }

}
