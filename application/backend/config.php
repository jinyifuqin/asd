<?php
// 配置文件
return [

    // 后台用户在线时间
    'online_time' => 30,//单位：分钟

    // 用户名密码有效期，0表示永不过期
    'password_time' => 30,//单位：天

    'template' => [
        // 预先加载的标签库
        'taglib_pre_load' => 'app\common\taglib\Html',
    ],

    'page_size' => 10,

    'radio' => [
        '1' => '是',
        '0' => '否',
    ],

    'status' =>[
    	'1' => '通过',
        '0' => '未通过',
    ],
    'status_user' =>[
        '0' => '禁用',
        '1' => '正常',
    ],


    'is_show' =>[
        '1' => '是',
        '0' => '否',
    ],
    'cate_model' =>[
        '1' => '单页',
        '2' => '文章',
        '3' => '图文', //预留
        // '4' => '招聘', //预留
        '5' => '专题',
        '6' => '链接',
        '0' => '标识',
    ],

    'link_type' =>[
        '1' => '友情链接',
        '2' => '合作伙伴',
        '3' => '热门搜索',
    ],
    'link_target' =>[
        '_self'  => '当前页面',
        '_blank' => '新页面',
    ],

    'ad_type' =>[
        'image'  => '图片',
    ],
    'upload' => [
        'image_compress_enable' => true, //是否压缩图片
        'image_compress_border' => 2560, //图片压缩最长边限制
        'path' => 'uploadfile',
        'image_max_size' => 2048000,
        'image_allow_files' => [".png", ".jpg", ".jpeg", ".gif", ".bmp"],

        'video_max_size' => 2048000,
        'video_allow_files' => [".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid"],

        'file_max_size'  => 2048000,
        'file_allow_files' => [
                    ".png", ".jpg", ".jpeg", ".gif", ".bmp",
                    ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
                    ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid",
                    ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2", ".cab", ".iso",
                    ".doc", ".docx", ".xls", ".xlsx", ".ppt", ".pptx", ".pdf", ".txt", ".md", ".xml"
                ],
    ],

    // 默认跳转页面对应的模板文件
    'dispatch_success_tmpl'  => 'common@tpl/tips',
    'dispatch_error_tmpl'    => 'common@tpl/tips',

    //分页配置
    'paginate'               => [
        'type'      => '\paginator\Pintuer',
        'var_page'  => 'page',
        'list_rows' => 10,
    ],
];