<?php
use yii\helpers\Url;
?>

<div id="footer">
    <div class="footer-ensure-center">
        <img src="/resources/images/service.png" alt="家家优品服务特色">
    </div>

    <div class="shadowbar"></div>
    <div class="ft-bg">
        <div class="ft_main">
            <div class="footlogo">
                <img id='footlogo' src="/resources/images/logo.png" alt="家家优品商城"/>
                <img src="/resources/images/family.png" alt="家家优品商城，做最快乐的家"/>
            </div>
            <div class="links">
                <div  class="linksheader"><span>关于商城</span></div>
                <ul>
                    <li>
                        <a href="<?= Url::to(['/cms/default/page', 'id' => 55, 'surname' => 'about_us']) ?>" target="_blank" class="noborder" >商城协议</a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['/cms/default/page', 'id' => 13, 'surname' => 'about_hr']) ?>" target="_blank" >会员积分</a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['/cms/default/page', 'id' => 2, 'surname' => 'shipment_fee']) ?>" target="_blank" >配送政策</a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['/cms/default/page', 'id' => 23, 'surname' => 'sales_return_policy']) ?>" target="_blank">奶粉直邮</a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['/cms/default/page', 'id' => 42, 'surname' => 'sales_return_policy']) ?>" target="_blank">售后政策</a>
                    </li>
                </ul>
            </div>

            <div class="links">
                <div  class="linksheader"><span>关于我们</span></div>
                <ul>
                    <li>
                        <a href="<?= Url::to(['/cms/default/page', 'id' => 51, 'surname' => 'about_hr']) ?>" target="_blank" >关于我们</a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['/cms/default/page', 'id' => 53, 'surname' => 'about_hr']) ?>" target="_blank" >商务合作</a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['/cms/default/page', 'id' => 54, 'surname' => 'about_hr']) ?>" target="_blank" >加入我们</a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['/cms/default/page', 'id' => 41, 'surname' => 'shipment_fee']) ?>" target="_blank" >正品保障</a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['/cms/default/page', 'id' => 52, 'surname' => 'sales_return_policy']) ?>" target="_blank">联系我们</a>
                    </li>
                </ul>
            </div>

            <div class="contacts">
                <div  class="linksheader"><span>联系我们</span></div>
                <ul>
                    <li class="weixin">
                        公众号：jjypsc
                    </li>
                    <li class="QQ">
                        客服QQ:2843080052
                    </li>
                    <li class="phone">
                        热线：0731-85822600
                    </li>
                    <li class="email">
                        kf@jiajiayoupin.com
                    </li>
                </ul>
            </div>

            <div class="bicode">
                <div  class="linksheader"><span>扫码联系客服</span></div>
                <div  class="weichatcode"><img src="/resources/images/wechatsupport.png" alt="家家优品微信客服"/></div>
            </div>

            <div class="bicode">
                <div  class="linksheader"><span>扫码关注公众号</span></div>
                <div  class="weichatcode"><img src="/resources/images/wechatsupport.png" alt="家家优品微信客服"/></div>
            </div>

            <div class="clear"></div>
        </div>
    </div>

    <div class="shadowbar"></div>

    <div class="foot_bottom">
        <div class="leftbottom">
            <span>Copyright <?= date('Y') ?>, 湖南晨笑贸易有限公司 备案号：<a href="http://www.miitbeian.gov.cn" target="_blank" rel="nofollow">湘ICP备15005966号-2</a></span>
        </div>

        <div clas="rightbottom">
            <ul class="beian-logos">
                <li><a href="javascript:;"><img alt="商城获得电商金典奖" src="/resources/images/flogo-jindian.png" /></a></li>
                <li><a href="javascript:;"><img alt="中国人保为商城化妆品承保" src="/resources/images/flogo-picc.png" /></a></li>
                <li><a href="javascript:;"><img alt="互联网协会A级信用认证" src="/resources/images/flogo-xinyong.png" /></a></li>
                <li><a href="http://t.knet.cn/" target="_blank"><img alt="商城可信网站权威认证" src="/resources/images/flogo-kexin.png" class="no-border" rel="nofollow"/></a></li>
            </ul>
        </div>

        <div class="clear"></div>
    </div>
</div>
