# jQuery Sina Emotion &middot; [![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/Lanfei/jquery-sina-emotion/blob/master/LICENSE) [![npm version](https://img.shields.io/npm/v/jquery-sina-emotion.svg)](https://www.npmjs.com/package/jquery-sina-emotion)

一个用于方便快速地创建新浪微博表情选择对话框的 jQuery 插件。

## 有何特点

- 使用简单，一行代码即可创创建出表情选择对话框
- 自带智能表情解析方法（但还是建议表情解析在服务端进行）
- 兼容IE6+、Chrome、Firefox、Opera等各种浏览器
<!--more-->

## 插件演示

[演示地址](https://lanfei.github.io/jquery-sina-emotion/)

## 使用方法

```js
// 未指定插入文本框时，自动寻找同表单中第一个 textarea 或 input[type=text] 元素
$(selector).click(function(event){
	$(this).sinaEmotion();
	event.stopPropagation();
});

// 手动指定插入文本框
$(selector).click(function(event){
	$(this).sinaEmotion(target);
	event.stopPropagation();
});
```
	
## 参数配置

```js
$.fn.sinaEmotion.options = {
    pageSize: 72 // 每页显示的表情数
};
```

## 表情解析

```js
$(selector).parseEmotion();
```

具体的使用方法请看 [Demo](https://github.com/Lanfei/jquery-sina-emotion/blob/master/index.html)

## 获取插件

- [npm](https://www.npmjs.com/package/jquery-sina-emotion)
- [GitHub](https://github.com/Lanfei/jquery-sina-emotion)
- [开源中国](https://gitee.com/lanfei/jquery-sina-emotion)

## 更新日志

- 1.0.0（2012.08.22）
	- [jQuery Sina Emotion v1.0][1] 诞生
- 1.1.0
	- 完善代码并于Google Code开源
- 1.2.0
	- 修正同一页面中对不同文本框使用该插件时插入位置错误的BUG（感谢 [@BelinChung][2] 提出）
- 1.3.0
	- 修正IE下负margin失效导致表情换行的小BUG（由 [@蜗牛都知道][3] 发现）
- 2.0.0
	- 全新重构插件代码
	- 新增表情解析方法
	- 开源于 [GitHub][4] 及 [码云][5]
- 2.1.0
	- 修复多次调用插件而对象文本框不同时，表情文本插入对象错乱问题
	- 修复表情接口未返回时，多次调用解析表情方法未成功解析的问题
	- 修改表情选择框显示机制，提高使用自由度（与低版本不兼容，升级插件时请注意修改调用方式，详见Demo）
	- 一些优化
- 3.0.0
	- 兼容 webpack 等模块打包器
	- 优化代码，修复一些偶现的 Bug
	- 作为 npm 模块发布
- 4.0.0
	- 移除新浪微博接口请求

  [1]: http://www.clanfei.com/2012/08/1644.html
  [2]: http://weibo.com/122311620
  [3]: https://weibo.com/u/1930696273
  [4]: https://github.com/Lanfei/jQuery-Sina-Emotion
  [5]: http://git.oschina.net/lanfei/jQuery-Sina-Emotion
