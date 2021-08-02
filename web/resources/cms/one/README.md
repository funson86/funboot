

```

INSERT INTO `fb_cms_page` VALUES (250547269055543001, 4, 24, '网站标题', 'common_website_name', NULL, NULL, '', NULL, '', '', NULL, '', '', 0.00, '', 1, 1, 'list', 0, '', '', '', '', '', '', 0, 0, 0, 0.00, 'list', 50, 1, 1624958011, 1624959895, 4, 4);
INSERT INTO `fb_cms_page` VALUES (250547269055543021, 4, 24, '网站页脚', 'common_website_footer', NULL, NULL, '', NULL, '', '', NULL, '', 'Copyright © 2021 mayicun.com 版权所有', 0.00, '', 1, 1, 'list', 0, '', '', '', '', '', '', 0, 0, 0, 0.00, 'list', 50, 1, 1624958011, 1624959895, 4, 4);
INSERT INTO `fb_cms_page` VALUES (250547269055545001, 4, 24, 'banner1', 'home_banner_1', NULL, NULL, '/resources/cms/one/images/banner-01.jpg', NULL, '', '', NULL, '国家高新技术企业', '成立于2012年，2018年评为国家高新技术企业', 0.00, '', 1, 1, 'list', 0, '', '', '', '', '', '', 0, 0, 0, 0.00, 'list', 50, 1, 1624958011, 1624959895, 4, 4);
INSERT INTO `fb_cms_page` VALUES (250547269055545002, 4, 24, 'banner2', 'home_banner_2', NULL, NULL, '/resources/cms/one/images/banner-02.jpg', NULL, '', '', NULL, '专注嵌入式产品开发', '专业稳健发展，专注技术更新，专一客户服务，让企业获得利益最大化', 0.00, '', 1, 1, 'list', 0, '', '', '', '', '', '', 0, 0, 0, 0.00, 'list', 50, 1, 1624958011, 1624959895, 4, 4);
INSERT INTO `fb_cms_page` VALUES (250547269055545003, 4, 24, 'banner3', 'home_banner_3', NULL, NULL, '/resources/cms/one/images/banner-03.jpg', NULL, '', '', NULL, '', '', 0.00, '', 1, 1, 'list', 0, '', '', '', '', '', '', 0, 0, 0, 0.00, 'list', 50, 1, 1624958011, 1624959895, 4, 4);
INSERT INTO `fb_cms_page` VALUES (250547269055545004, 4, 24, 'banner4', 'home_banner_4', NULL, NULL, '/resources/cms/one/images/banner-04.jpg', NULL, '', '', NULL, '', '', 0.00, '', 1, 1, 'list', 0, '', '', '', '', '', '', 0, 0, 0, 0.00, 'list', 50, 1, 1624958011, 1624959895, 4, 4);
INSERT INTO `fb_cms_page` VALUES (250547269055545005, 4, 24, 'banner5', 'home_banner_5', NULL, NULL, '/resources/cms/one/images/banner-05.jpg', NULL, '', '', NULL, '', '', 0.00, '', 1, 1, 'list', 0, '', '', '', '', '', '', 0, 0, 0, 0.00, 'list', 50, 1, 1624958011, 1624959895, 4, 4);
INSERT INTO `fb_cms_page` VALUES (250547269055545344, 4, 24, '解决方案', 'home_solution', NULL, NULL, '', NULL, '', '', NULL, '响应式网站下单|搜索引擎优化', '专属品牌网站连接你和客人，通过手机下单方便快捷|网站对搜索引擎优化', 0.00, '', 1, 1, 'list', 0, 'fa-internet-explorer|fa-search|fa-puzzle-piece|fa-life-ring', '', '', '', '', '', 0, 0, 0, 0.00, 'list', 50, 1, 1624958011, 1624959895, 4, 4);
INSERT INTO `fb_cms_page` VALUES (250547269055545345, 4, 24, '产品服务', 'home_service', NULL, NULL, '', NULL, '', '', NULL, '嵌入式产品|行业解决方案|工控产品', '嵌入式产品的硬件电路设计和软件开发及技术服务|行业打印机解决方案和服务|工业控制产品的硬件设计和软件开发', 0.00, '', 1, 1, 'list', 0, 'fa-internet-explorer|fa-print|fa-puzzle-piece', '', '', '', '', '', 0, 0, 0, 0.00, 'list', 50, 1, 1624958011, 1624959895, 4, 4);
INSERT INTO `fb_cms_page` VALUES (250547269055545348, 4, 24, '主页公告', 'home_board', NULL, NULL, '/resources/cms/one/images/banner-01.jpg', NULL, '', '', NULL, '', '启视电子致力于为客户提供综合的解决方案，为客户提供优质的软硬件开发服务', 0.00, '', 1, 1, 'list', 0, '', '', '', '', '', '', 0, 0, 0, 0.00, 'list', 50, 1, 1624958011, 1624959895, 4, 4);
INSERT INTO `fb_cms_page` VALUES (250547269055545351, 4, 24, '关于我们', 'home_about_us', NULL, NULL, '', NULL, '', '', NULL, '诚信，创新，服务', '做人德为先，诚信是根本；创新不仅是一种卓越的工作方法，也是一种卓越的人生信念；一切以客户价值为依归，服务创造价值。 我们愿意与所有合作伙伴一起成长，分享成长的价值。', 0.00, '', 1, 1, 'list', 0, '', '', '', '', '', '', 0, 0, 0, 0.00, 'list', 50, 1, 1624958011, 1624959895, 4, 4);
INSERT INTO `fb_cms_page` VALUES (250547269055545352, 4, 24, '联系我们', 'home_contact_us', NULL, NULL, '', NULL, '', '', NULL, '', '', 0.00, '', 1, 1, 'list', 0, 'funson86@gmal.com|深圳市龙岗区永昌大厦609|0755-84704070|hi3375074', '', '', '', '', '', 0, 0, 0, 0.00, 'list', 50, 1, 1624958011, 1624959895, 4, 4);

```


### 显示地图

在后台的地图代码中写入如下代码：

- iframe的height要比src的height大10px

```js
<iframe src="http://www.funboot.com/site/baidu-map?lng=114.15&lat=22.62&width=99%&height=400px&title=Funboot系统&remark=加油" width="100%" height="410px" frameborder="0" style="border:0;" allowfullscreen></iframe>

```