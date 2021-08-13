/**
 * echarts 配置
 * @type {*[]}
 */
let echartsList = [];
let echartsListConfig = [];

/**
 * 带checkbox的树形控件使用说明
 * @data 应该是一个js数组
 * @id: 将树渲染到页面的某个div上，此div的id
 * @checkId:需要默认勾选的数节点id；1.checkId="all"，表示勾选所有节点 2.checkId=[1,2]表示勾选id为1,2的节点
 * 节点的id号由url传入json串中的id决定
 */
function showCheckboxTree(data, id, checkId) {
    var that = $("#" + id);

    menuTree = that.bind("loaded.jstree", function (e, data) {
        that.jstree("open_all");
        that.find("li").each(function () {
            if (checkId == 'all') {
                that.jstree("check_node", $(this));
            }

            if (checkId instanceof Array) {
                for (var i = 0; i < checkId.length; i++) {
                    if ($(this).attr("id") == checkId[i]) {
                        that.jstree("check_node", $(this));
                    }
                }
            }
        });
    }).jstree({
        "core": {
            "data": data,
            "attr": {
                "class": "jstree-checked"
            }
        },
        "types": {
            "default": {
                "valid_children": ["default", "file"]
            },
            "file": {
                "icon": "glyphicon glyphicon-file",
                "valid_children": []
            }
        },
        "checkbox": {
            "keep_selected_style": false,
            "real_checkboxes": true
        },
        "plugins": [
            "contextmenu", "dnd", "search",
            "types", "checkbox"
        ],
        "contextmenu": {
            "items": {
                "create": null,
                "rename": null,
                "remove": null,
                "ccp": null
            }
        }
    });

    // 加载完毕折叠所有节点
    that.bind('ready.jstree', function (obj, e) {
        that.jstree('close_all');
    });
}

/**
 * 获取所有选择的数据
 * @param treeId
 */
function getCheckTreeIds(treeId) {
    // 打开所有的节点，不然获取不到子节点数据
    var that = $("#" + treeId);
    that.jstree('open_all');

    var ids = [];
    var treeNode = that.jstree(true).get_selected(true);

    for (var i = 0; i < treeNode.length; i++) {

        var node = treeNode[i];
        var nodeId = node.original.id;

        // 判断是否重复
        if ($.inArray(nodeId, ids) == -1) {
            ids.push(nodeId);
        }

        for (var j = 0; j < node.parents.length; j++) {
            // 判断是否重复
            var parentId = node.parents[j];
            if (parentId != "#" && $.inArray(parentId, ids) == -1) {
                ids.push(parentId);
            }
        }
    }

    return ids;
}

//------------------- 文件上传 ------------------//
// 显示蒙版
$(document).on("mouseenter", ".upload-box", function (e) {
    var obj = $(e.currentTarget);
    if (!obj.is(":hidden") && $(window).width() > 769) {
        obj.parent().find('.select-upload').removeClass('hidden');
    }
});

// 移除文件蒙层
$(document).on("mouseleave", ".upload-list", function (e) {
    $(e.currentTarget).parent().find('.select-upload').addClass('hidden');
});

// 触发上传
$(document).on("click", ".upload-box", function (e) {
    if (e.target == this) {
        let boxId = $(this).parent().attr('data-boxId');
        $('#upload-' + boxId + ' .webuploader-container input').trigger('click');
    }
});

// 触发上传2
$(document).on("click", ".upload-box .fa-cloud-upload", function (e) {
    if (e.target == this) {
        let boxId = $(this).parent().parent().attr('data-boxId');
        $('#upload-' + boxId + ' .webuploader-container input').trigger('click');
    }
});

// 触发上传
$('.upload-box-immediately').click(function () {
    let boxId = $(this).parent().parent().parent().attr('data-boxId');

    $('#upload-' + boxId + ' .webuploader-container input').trigger('click');
});

$(function () {
    //初始化上传控件
    $.fn.InitUploader = function (config) {
        //待上传文件的md5值（key为file id）
        var md5 = {};
        var filesGuid = {};
        var uploadProgress = {};
        let guid = WebUploader.Base.guid();
        let fun = function (parentObj) {
            let uploader = WebUploader.create(config);
            //当validate不通过时，会以派送错误事件的形式通知
            uploader.on('error', function (type) {
                console.log(type);
                switch (type) {
                    case 'Q_EXCEED_NUM_LIMIT':
                        fbError("上传文件数量过多！");
                        break;
                    case 'Q_EXCEED_SIZE_LIMIT':
                        fbError("文件总大小超出限制！");
                        break;
                    case 'F_EXCEED_SIZE':
                        fbError("文件大小超出限制！");
                        break;
                    case 'Q_TYPE_DENIED':
                        fbError("禁止上传该类型文件！", '请检查文件类型或文件为空文件');
                        break;
                    case 'F_DUPLICATE':
                        fbError("请勿重复上传该文件！");
                        break;
                    default:
                        fbError('错误代码：' + type);
                        break;
                }
            });

            //当有一个文件添加进来的时候
            uploader.on('fileQueued', function (file) {
                $(document).trigger('upload-file-queued-' + config.boxId, [file, uploader, config]);
            });

            //当有一批文件添加进来的时候
            uploader.on('filesQueued', function (files) {
                for (let i = 0; i < files.length; i++) {
                    md5File(files[i], uploader, config);
                }

                $(document).trigger('upload-files-queued-' + config.boxId, [files, uploader, config]);
            });

            // 某个文件开始上传前触发，一个文件只会触发一次
            uploader.on('uploadStart', function (file) {
                var tmpFormData = uploader.options.formData;
                tmpFormData['x:md5'] = md5[file.id];
                tmpFormData['md5'] = md5[file.id];
                uploader.options.formData = tmpFormData;

                // 创建进度条
                $(document).trigger('upload-create-progress-' + config.boxId, [file, uploader, config]);
            });

            // 当某个文件的分块在发送前触发，主要用来询问是否要添加附带参数，大文件在开起分片上传的前提下此事件可能会触发多次。
            uploader.on('uploadBeforeSend', function (object, data) {
                // 给与唯一数
                if (filesGuid[object.file.id] === undefined) {
                    filesGuid[object.file.id] = WebUploader.Base.guid();
                }

                data.md5 = md5[object.file.id];
                data.guid = filesGuid[object.file.id];
            });

            // 文件上传过程中创建进度条实时显示
            uploader.on('uploadProgress', function (file, percentage) {
                // 进入进度条库
                uploadProgress[file.id] = Math.floor(percentage * 100);
                // 实时进度条
                $(document).trigger('upload-progress-' + config.boxId, [file, percentage, config]);
            });

            //当文件上传出错时触发
            uploader.on('uploadError', function (file, reason) {
                // 触发失败回调
                $(document).trigger('upload-error-' + config.boxId, [file, reason, uploader, config]);
            });

            //当文件上传成功时触发
            uploader.on('uploadSuccess', function (file, data) {

                console.log(uploadProgress);
                console.log(data);

                if (parseInt(data.code) === 200) {
                    data = data.data;
                    // 如果需要合并回调
                    if (data.merge == true) {
                        $.ajax({
                            type: "post",
                            url: config.mergeUrl,
                            dataType: "json",
                            data: {guid: data.guid},
                            success: function (data) {
                                if (data.code == 200) {
                                    data = data.data;
                                    // 触发回调
                                    $(document).trigger('upload-success-' + config.boxId, [data, config]);
                                } else {
                                    fbError(data.message);
                                }
                            }
                        });
                    } else {
                        // 触发主动回调
                        $(document).trigger('upload-success-' + config.boxId, [data, config]);
                        // 被动回调
                        if (config.callback) {
                            $(document).trigger(config.callback, [data, config]);
                        }
                    }
                } else {
                    fbError(data.message);
                }

                uploader.removeFile(file); //从队列中移除
            });

            //不管成功或者失败，文件上传完成时触发
            uploader.on('uploadComplete', function (file) {
                let num = uploader.getStats().queueNum;
                $(document).trigger('upload-complete-' + config.boxId, [file, num, config, uploadProgress]);
            });
        };

        // 校验md5
        function md5File(file, uploader, config) {
            // 接管的直接上传跳过验证
            if (config.independentUrl == true || config.md5Verify == false) {
                $(document).trigger('md5Verify-create-progress-' + config.boxId, [file, uploader, config, '0%']);
                // 开始上传
                uploader.upload(file);
                return;
            }

            // 创建进度条默认验证中
            $(document).trigger('md5Verify-create-progress-' + config.boxId, [file, uploader, config]);
            // 加入进度条为-1
            uploadProgress[file.id] = -1;

            //获取文件MD5值
            uploader.md5File(file).progress(function (percentage) {
                console.log(percentage);
            })
                .then(function (val) {
                    // 完成
                    md5[file.id] = val;
                    // 完成进度条为-2
                    uploadProgress[file.id] = -2;

                    $.ajax({
                        type: "post",
                        url: config.verifyMd5Url,
                        dataType: "json",
                        data: {md5: md5[file.id], drive: config.formData.driver},
                        success: function (data) {
                            if (parseInt(data.code) === 200) {
                                //跳过如果存在则跳过
                                uploader.removeFile(file);

                                data = data.data;
                                // 触发完成验证(和完成上传一样)
                                $(document).trigger('upload-complete-' + config.boxId, [file, 0, config, uploadProgress]);
                                // 触发回调
                                $(document).trigger('upload-success-' + config.boxId, [data, config]);
                                // 被动回调
                                if (config.callback) {
                                    $(document).trigger(config.callback, [ossData, config]);
                                }
                            } else {
                                // fbError(data.message);
                                $(document).trigger('md5Verify-create-progress-' + config.boxId, [file, uploader, config, '0%']);
                                // 开始上传
                                uploader.upload(file);
                            }
                        }
                    });
                });
        }

        return $(this).each(function () {
            fun($(this));
        });
    };

    // 图片/文件选择
    $(document).on("click", ".mailbox-attachment-icon", function (e) {
        if (!$(this).parent().hasClass('active')) {
            // 判断是否多选
            if ($('#fbAttachmentList').data('multiple') != true) {
                $('#fbAttachmentList .active').each(function (i, data) {
                    $(data).removeClass('active');
                });
            }

            $(this).parent().addClass('active');
        } else {
            $(this).parent().removeClass('active');
        }
    });
});
