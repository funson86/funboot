<?php

use yii\helpers\Html;
use common\models\pay\Payment;
use common\helpers\CommonHelper;

/* @var $this yii\web\View */
/* @var $model common\models\pay\Payment */
/* @var $store common\models\Store */
/* @var $listProduct array */

?>

<style type="text/css">
    .ReadMsgBody { width: 100%; background-color: #ffffff; }
    .ExternalClass { width: 100%; background-color: #ffffff; }
    .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }
    html { width: 100%; }
    body { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; margin: 0; padding: 0; }
    table { border-spacing: 0; border-collapse: collapse; table-layout: fixed; margin:0 auto; }
    table table table { table-layout: auto; }
    img { display: block !important; }
    table td { border-collapse: collapse; }
    .yshortcuts a { border-bottom: none !important; }
    a { color: #7f8c8d; text-decoration: none;}
    .textbutton a { font-family: 'open sans', arial, sans-serif !important; color: #ffffff !important; }
    .footer-link a { color: #7f8c8d !important; }
</style>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ffffff">

    <!-- header -->

    <tr>
        <td align="center">
            <table bgcolor="#f8f8f8" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr align="center" valign="top">
                    <td>
                        <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="208" align="center" valign="top" bgcolor="#607e9d">
                                    <table width="158" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td height="40"></td>
                                        </tr>
                                        <!-- logo -->
                                        <tr>
                                            <td align="center" style="line-height:0px;">
                                                <img style="display:block;font-size:0px; border:0px; line-height:0px;" src="<?= $store->settings['website_logo'] ?: CommonHelper::getHostPrefix($store->host_name) . Yii::$app->params['defaultLogo'] ?>" height="60" alt="logo" />
                                            </td>
                                        </tr>
                                        <!-- end logo -->

                                        <tr>
                                            <td height="20"></td>
                                        </tr>

                                        <!-- Compane Name -->
                                        <tr>
                                            <td align="center" style="font-family: 'Open Sans', Arial, sans-serif; font-size:16px; color:#FFFFFF; line-height:26px; font-weight: bold;"><?= $store->settings['website_name'] ?></td>
                                        </tr>
                                        <!-- end Compane Name -->

                                        <tr>
                                            <td height="25"></td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="392" align="center" valign="top">
                                    <table width="342" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td height="30"></td>
                                        </tr>

                                        <!-- title -->
                                        <tr>
                                            <td align="right" style="font-family: 'Open Sans', Arial, sans-serif; font-size:38px; color:#3b3b3b; line-height:26px;"><?= Yii::t('app', 'Payment Confirmed') ?></td>
                                        </tr>
                                        <!-- end title -->

                                        <tr>
                                            <td height="25"></td>
                                        </tr>
                                        <tr>
                                            <td align="right">
                                                <table align="right" width="50" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td bgcolor="#ff646a" height="3" style="line-height:0px; font-size:0px;">&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="15"></td>
                                        </tr>

                                        <!-- address -->
                                        <tr>
                                            <td align="right" style="font-family: 'Open Sans', Arial, sans-serif; font-size:13px; color:#7f8c8d; line-height:26px;">
                                                Website: <a href="<?= CommonHelper::getHostPrefix($store->host_name) ?>"><?= CommonHelper::getHostPrefix($store->host_name) ?></a>
                                            </td>
                                        </tr>
                                        <!-- end address -->

                                        <tr>
                                            <td height="25"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- end header -->

    <!-- title -->

    <tr>
        <td align="center">
            <table align="center" width="600" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center" style="border-bottom:3px solid #bcbcbc;">
                        <table align="center" width="550" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td height="20"></td>
                            </tr>

                            <!-- header -->
                            <tr>
                                <td>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="100%" align="left" valign="top" style="font-size:13px; color:#3b3b3b; line-height:26px;">
                                                <?php if ($type == 1) { ?>
                                                    <p>New payment <?= Html::encode($model->money) ?> from <?= Html::encode($model->name) ?> <?= Html::encode($model->email) ?> by <?= Html::encode($model->bank_code) ?> .</p>
                                                <?php } else { ?>
                                                    <p>Thank you for your donation on <?= CommonHelper::getHostPrefix($store->host_name) ?>.</p>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <!-- end header -->
                            <tr>
                                <td height="10"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- end title -->
    <!-- list -->
    <tr>
        <td align="center">
            <table width="600" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center" style="border-bottom:1px solid #ecf0f1;">
                        <table width="550" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td height="5"></td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="250" align="left" valign="top" style="font-family: 'Open Sans', Arial, sans-serif; font-size:14px; color:#3b3b3b; line-height:26px;  font-weight: bold;">Payment Method</td>
                                            <td width="300" align="right" valign="top" style="font-family: 'Open Sans', Arial, sans-serif; font-size:14px; color:#3b3b3b; line-height:26px;  font-weight: bold;"><?= $model->bank_code ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="5"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- end list -->

    <!-- list -->
    <tr>
        <td align="center">
            <table width="600" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center" style="border-bottom:1px solid #ecf0f1;">
                        <table width="550" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td height="5"></td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="250" align="left" valign="top" style="font-family: 'Open Sans', Arial, sans-serif; font-size:14px; color:#3b3b3b; line-height:26px;  font-weight: bold;">Payment Status</td>
                                            <td width="300" align="right" valign="top" style="font-family: 'Open Sans', Arial, sans-serif; font-size:14px; color:#3b3b3b; line-height:26px;  font-weight: bold;"><?= Payment::getStatusLabels($model->status) ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="5"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- end list -->

    <!-- list -->
    <tr>
        <td align="center">
            <table width="600" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center" style="border-bottom:1px solid #ecf0f1;">
                        <table width="550" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td height="5"></td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="250" align="left" valign="top" style="font-family: 'Open Sans', Arial, sans-serif; font-size:14px; color:#3b3b3b; line-height:26px;  font-weight: bold;">Remark</td>
                                            <td width="300" align="right" valign="top" style="font-family: 'Open Sans', Arial, sans-serif; font-size:14px; color:#3b3b3b; line-height:26px;  font-weight: bold;"><?= $model->remark ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="5"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- end list -->

    <!-- total -->
    <tr>
        <td align="center">
            <table align="center" width="600" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td height="20"></td>
                </tr>
                <tr>
                    <td align="center" height="0" style="border-bottom:3px solid #bcbcbc;"></td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- end total -->

    <!-- list -->
    <tr>
        <td align="center">
            <table width="600" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center" style="border-bottom:1px solid #ecf0f1;">
                        <table width="550" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td height="10"></td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="250" align="left" valign="top" style="font-family: 'Open Sans', Arial, sans-serif; font-size:14px; color:#3b3b3b; line-height:26px;  font-weight: bold;">Amount</td>
                                            <td width="300" align="right" valign="top" style="font-family: 'Open Sans', Arial, sans-serif; font-size:14px; color:#3b3b3b; line-height:26px;  font-weight: bold;"><?= number_format($model->money, 2) ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="10"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- end list -->

    <!-- total -->
    <tr>
        <td align="center">
            <table align="center" width="600" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center" height="0" style="border-bottom:3px solid #3b3b3b;"></td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- end total -->

    <!-- note -->
    <?php if ($type == 1) { ?>
    <tr>
        <td align="center">
            <table align="center" width="600" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td height="20"></td>
                </tr>

                <!-- content -->
                <tr>
                    <td style="font-size:13px; color:#7f8c8d; line-height:26px;">
                        请确认后点击以下对应按钮进行审核(3小时内有效)：
                    </td>
                </tr>
                <!-- end content -->

                <?php foreach ($buttons as $item) { ?>
                <tr>
                    <td height="20"></td>
                </tr>

                <tr>
                    <td align="center">
                        <!--button-->
                        <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="<?= $item['color'] ?>" class="textbutton" style="border-radius:5px;border-bottom:3px solid #e6e6e6">
                            <tr>
                                <td height="40" align="center" style="font-size:16px;color:#FFFFFF;line-height: 28px;padding-left: 15px;padding-right: 15px;">
                                    <a href="<?= $item['url'] ?>" style="display: block;"><?= $item['label'] ?></a>
                                </td>
                            </tr>
                        </table>
                        <!--end button-->
                    </td>
                </tr>

                <?php } ?>


                <tr>
                    <td height="20"></td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- end note -->

    <!-- total -->
    <tr>
        <td align="center">
            <table align="center" width="600" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center" height="0" style="border-bottom:3px solid #bcbcbc;"></td>
                </tr>
            </table>
        </td>
    </tr>
    <?php } ?>
    <!-- end total -->

    <!-- footer -->
    <tr>
        <td align="center">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td height="15" align="center" valign="top" style="border-bottom:10px solid #ecf0f1;">
                        <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td height="25"></td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="13" align="center" style="line-height:0px;">
                                                <img style="display:block;font-size:0px; border:0px; line-height:0px;" src="<?= CommonHelper::getHostPrefix($store->host_name) ?>/resources/images/email.png" width="14" height="11" alt="img" />
                                            </td>
                                            <td width="10"></td>
                                            <td class="footer-link" width="120" align="left" style="font-family: 'Open Sans', Arial, sans-serif; font-size:13px; color:#3b3b3b; line-height:26px;"><?= $store->settings['website_name'] ?></td>
                                            <td class="footer-link" width="300" align="right" style="font-family: 'Open Sans', Arial, sans-serif; font-size:13px; color:#3b3b3b; line-height:26px;">
                                                <a href="<?= CommonHelper::getHostPrefix($store->host_name) ?>"><?= CommonHelper::getHostPrefix($store->host_name) ?></a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="25"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- end footer -->

</table>
</body>
</html>
