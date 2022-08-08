<?php

use common\components\swagger\SwaggerAsset;
use frontend\helpers\Url;

SwaggerAsset::register($this);

/** @var string $configurations */
/** @var string $title */
/** @var array $oauthConfiguration */

?><!-- HTML for static distribution bundle build -->
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Swagger UI</title>
    <link rel="icon" type="image/png" href="/backend/resources/images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="/backend/resources/images/favicon-16x16.png" sizes="16x16" />
    <style>
        html
        {
            box-sizing: border-box;
            overflow: -moz-scrollbars-vertical;
            overflow-y: scroll;
        }

        *,
        *:before,
        *:after
        {
            box-sizing: inherit;
        }

        body
        {
            margin:0;
            background: #fafafa;
        }
    </style>
    <?php $this->head() ?>
</head>
<?php $this->beginBody() ?>
<body>
<div id="swagger-ui"></div>

<div style="text-align: center"><span id="refresh" onclick="refreshDoc()" style="background-color: #000; color: #FFF; padding: .3rem 1rem; border-radius: .2rem">Refresh Document</span></div>
<script>
    function refreshDoc() {
        $.get("<?= Url::to(['swagger/refresh']); ?>", function(data, status) {
            if (status === "success") {
                alert(data.msg);
            } else {
                alert (status);
            }
            window.location.reload();
        });
    }
</script>
<script>
    window.onload = function() {
        // Begin Swagger UI call region
        const ui = SwaggerUIBundle({
            url: "<?= $url ?>",
            dom_id: '#swagger-ui',
            deepLinking: true,
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],
            plugins: [
                SwaggerUIBundle.plugins.DownloadUrl
            ],
            layout: "StandaloneLayout"
        })
        // End Swagger UI call region

        window.ui = ui
    }
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>