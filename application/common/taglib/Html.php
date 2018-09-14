<?php
/**
 * 自定义变标签库
 * 依赖pintuer样式
 * @author TechLee
 * @since 2016-12-11
 */
namespace app\common\taglib;
use think\template\TagLib;
use think\Url;
use think\Config;
class Html extends TagLib
{    
    // 标签定义
    protected $tags = array(
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1不闭合） alias 标签别名 level 嵌套层次
        'button'   => array(
            'attr'  => 'id,class,value,href,addstr',
            'close' => 1,
        ),
        'input'    => array(
            'attr'  => 'id,class,style,value,tip',
            'close' => 0,
        ),
        'text'     => array(
            'attr'  => 'id,class,style,value,tip',
            'close' => 0,
        ),
        'date'     => array(
            'attr'  => 'id,class,style,value,tip',
            'close' => 0,
        ),
        'fileimg'  => array(
            'attr'  => 'id,class,style,value,tip,more',
            'close' => 0,
        ),
        'hidden'   => array(
            'attr'  => 'id,class,value',
            'close' => 0,
        ),
        'timer'    => array(
            'attr'  => 'id,style,value,tip,arg',
            'close' => 0,
        ),
        'radio'    => array(
            'attr'  => 'id,style,value,datakey,vt,tip,separator',
            'close' => 0,
        ),
        'textarea' => array(
            'attr'  => 'id,style,value,tip,class,addstr',
            'close' => 0,
        ),
        'editor'   => array(
            'attr'  => 'id,style,w,h,type,value,type',
            'close' => 1,
        ),
        'select'   => array(
            'attr'  => 'id,style,value,datakey,vt,tip,default,ishtml,NoDefalut,class',
            'close' => 0,
        ),
        'checkbox' => array(
            'attr'  => 'name,checked,separator',
            'close' => 0,
        ),
    );
    /**
     * button按钮
     * @param unknown $tag
     * @return string
     */
    public function tagButton($tag, $content)
    {
        $id     = @$tag['id']; // id
        $class  = isset($tag['class']) ? $tag['class'] : 'border-main"'; // id
        $href   = isset($tag['href']) ? ($tag['href']) : ''; // 文本框值
        $addstr = @$tag['addstr']; // 样式名
        $parseStr = "";
        $flag     = substr($href, 0, 1);
        if (':' == $flag) {
            $href = $this->autoBuildVar($href);
            $parseStr .= '<?php $_result=' . $href . ';?>';
            $href = '$_result';
        } elseif (!empty($href)) {
            $href = $this->autoBuildVar($href);
        }
        $parseStr .= '<button id="' . $id . '" class="button ' . $class . '" type="submit"';
        if (!empty($href)) {
            $parseStr .= ' chick-href="<?php echo ' . $href . '; ?>"';
        }
        $parseStr .= $addstr . '>' . $content . '</button>';
        return $parseStr;
    }
    /**
     * input隐藏域
     * 格式： {html:hidden value=""}
     * @param unknown $tag
     * @return string
     */
    public function tagHidden($tag)
    {
        $id     = @$tag['id']; // name 和 id
        $name   = @$tag['name']; // name 和 id
        $addstr = isset($tag['addstr']) ? $tag['addstr'] : '';
        $value  = ''; // 文本框值
        $className = isset($tag['class']) ? " " . $tag['class'] : '';
        if (isset($tag['value'])) {
            $value = $this->autoBuildVar($tag['value']); // 文本框值
            $value = '<?php echo ' . $value . ';?>';
        }
        $parseStr = '';
        if ($id) {
            $id = 'id="' . $id . '"';
        }
        $parseStr .= '<input name="' . $name . '" ' . $id . ' class="input' . $className . '" type="hidden" value="' . $value . '" ' . $addstr . '>';
        $parseStr .= '';
        return $parseStr;
    }
    /**
     * input文本框
     * 格式： {html:input type="" value=""}
     * @param unknown $tag
     * @return string
     */
    public function tagInput($tag)
    {
        $id        = @$tag['id']; // name 和 id
        $type        = @$tag['type'] ? $tag['type'] : 'text'; // name 和 id
        $name      = $this->getVal(@$tag['name']); // name 和 id
        $addstr    = isset($tag['addstr']) ? $tag['addstr'] : '';
        $value     = $this->getVal(@$tag['value']); // 文本框值
        $label     = $this->getVal(@$tag['label']); // span tip提示内容
        $note      = $this->getVal(@$tag['note']); // span tip提示内容
        $style     = isset($tag['style']); // 附加样式 style="widht:100"
        $className = isset($tag['class']) ? " " . $tag['class'] : ''; // 附加样式 style="widht:100"
        $name  = '<?php echo ' . $name . ';?>';
        $value = '<?php echo ' . $value . ';?>';
        $label = '<?php echo ' . $label . ' . \'：\';?>';
        $note  = $note ? '<?php echo ' . $note . ';?>' : '';
        $parseStr = '<div class="form-group"><div class="label"><label>' . $label . '</label></div><div class="field">';
        if ($style) {
            $style = 'style="' . $style . '"';
        }
        if ($id) {
            $id = 'id="' . $id . '"';
        }
        $parseStr .= '<input name="' . $name . '" ' . $id . ' ' . $style . ' class="input' . $className . '" type="'.$type.'" value="' . $value . '" ' . $addstr . '>';
        $parseStr .= '<div class="input-note">' . $note . '</div>';
        $parseStr .= '</div></div>';
        return $parseStr;
    }
    /**
     * input文本框
     * 格式： {html:input type="" value=""}
     * @param unknown $tag
     * @return string
     */
    public function tagText($tag)
    {
        $id        = @$tag['id']; // name 和 id
        $addstr    = isset($tag['addstr']) ? $tag['addstr'] : '';
        $value     = $this->getVal(@$tag['value']); // 文本框值
        $label     = $this->getVal(@$tag['label']); // span tip提示内容
        $style     = isset($tag['style']); // 附加样式 style="widht:100"
        $className = isset($tag['class']) ? " " . $tag['class'] : ''; // 附加样式 style="widht:100"
        $value     = '<?php echo ' . $value . ';?>';
        $label     = '<?php echo ' . $label . ' . \'：\';?>';
        $parseStr = '<div class="form-group"><div class="label"><label>' . $label . '</label></div><div class="field">';
        if ($style) {
            $style = 'style="' . $style . '"';
        }
        if ($id) {
            $id = 'id="' . $id . '"';
        }
        $parseStr .= '<label ' . $id . ' ' . $style . ' class="' . $className . '" ' . $addstr . ' >' . $value . '</label>';
        $parseStr .= '</div></div>';
        return $parseStr;
    }
    /**
     * 日历
     * 格式： {html:input type="" value=""}
     * @param unknown $tag
     * @return string
     */
    public function tagDate($tag)
    {        
        $id   = @$tag['id']; // name 和 id        
        $name = $this->getVal(@$tag['name']); // name 和 id   
        $addstr = isset($tag['addstr']) ? $tag['addstr'] : ''; 
        $value = $this->getVal(@$tag['value']);// 文本框值        
        $label = $this->getVal(@$tag['label']); // span tip提示内容
        $note      = $this->getVal(@$tag['note']); // span tip提示内容
        $note  = $note ? '<?php echo ' . $note . ';?>' : '';
        $style = isset($tag['style']); // 附加样式 style="widht:100"
        $className = isset($tag['class']) ? " " . $tag['class'] : ''; // 附加样式 style="widht:100"
        
        $name = '<?php echo ' . $name . ';?>';
        $value = '<?php echo is_int(' . $value . ') ? date("Y-m-d H:i:s", ' . $value . ') : (empty(' . $value . ') ? date("Y-m-d H:i:s") : ' . $value . ');?>';
        $label = '<?php echo ' . $label . ' . \'：\';?>';
        $parseStr = '<div class="form-group"><div class="label"><label>'.$label.'</label></div><div class="field">';
        
        if ($style){
            $style = 'style="' . $style . '"';
        }
        $id = $id ? $id : $name;
        $idStr = 'id="' . $id . '"';
        
        $parseStr .= '<input name="' . $name . '" ' . $idStr . ' ' . $style . ' class="input laydate ' . $className . ' laydate-icon" type="text" value="'.$value.'" ' . $addstr . '>';  
        
        $parseStr .= '<?php if(!isset($_laydate) || $_laydate != true): ;?>';                
        $parseStr .= '<script type="text/javascript" src="'.Config::get('view_replace_str.__STATIC__').'backend/plugin/laydate/laydate.js"></script>';        
        $parseStr .= '<?php $_laydate = true; endif;?>';
        $parseStr .= '<script type="text/javascript">laydate({elem: \'#'.$id.'\', festival: true, format: \'YYYY-MM-DD hh:mm:ss\',istime: true, event: \'focus\'});</script>';
        $parseStr .= '<div class="input-note">' . $note . '</div>';
        $parseStr .= '</div></div>';
        return $parseStr;
    }
    /**
     * 文件上传
     * 格式： {html:input type="" value=""}
     * @param unknown $tag
     * @return string
     */
    public function tagFileImg($tag)
    {           
        $id = $this->getVal(@$tag['id']); // name 和 id
        $name = $this->getVal(@$tag['name']); // name 和 id
        $id   = '<?php echo ' . $id . ';?>';
        $name   = '<?php echo ' . $name . ';?>';
        $more   = isset($tag['more']) && $tag['more'] == 1 ? 1 : 0;
        $addstr = isset($tag['addstr']) ? $tag['addstr'] : '';
        $value  = ''; // 文本框值
        $label     = $this->getVal(@$tag['label']); // span tip提示内容
        $note      = $this->getVal(@$tag['note']); // span tip提示内容
        $note  = $note ? '<?php echo ' . $note . ';?>' : '';
        $style   = @$tag['style'];
        $class   = @$tag['class'];         
        $label   = '<?php echo ' . $label . ' . \'：\';?>';
        $nameTmp = 'v_' . md5(microtime() . time());
        if (isset($tag['value'])) {
            $value = $this->autoBuildVar($tag['value']); // 文本框值
            $value = '<?php echo ' . $value . ';?>';
        }
        $parseStr = '<div class="form-group"><div class="label"><label>' . $label . '</label></div><div class="field">';
        if ($style) {
            $style = 'style="' . $style . '"';
        }
        if ($id) {
            $id = 'id="' . $id . '"';
        }
        if ($more) {
            $name .= '[]';
        }
        $parseStr .= '<a class="button input-flie" more="' . $more . '" file-name="' . $name . '" id="' . $nameTmp . '_button" href="javascript:void(0);">+ 浏览文件</a>';
        $parseStr .= '<div class="imgdiv"></div>';
        $parseStr .= '<?php if(!isset($_ueditor) || $_ueditor != true): ;?>';
        $parseStr .= '<script type="text/javascript">var ueControllerPath = "' . Url::build('Ueditor/index') . '";</script>';
        $parseStr .= '<script type="text/javascript" src="'.Config::get('view_replace_str.__STATIC__').'backend/plugin/ueditor/ueditor.config.js"></script>';
        $parseStr .= '<script type="text/javascript" src="'.Config::get('view_replace_str.__STATIC__').'backend/plugin/ueditor/ueditor.all.min.js"></script>';
        $parseStr .= '<script type="text/javascript" src="'.Config::get('view_replace_str.__STATIC__').'backend/plugin/ueditor/lang/zh-cn/zh-cn.js"></script>';
        $parseStr .= '<?php $_ueditor = true; endif;?>';
        $parseStr .= '<script id="' . $nameTmp . '"></script><script>';
        $parseStr .= 'var ' . $nameTmp . '_imgstr = "' . $value . '";
                    var ' . $nameTmp . '_imgarr = ' . $nameTmp . '_imgstr.split(",");';
        $parseStr .= '<?php if(!isset($_has_addimg) || $_has_addimg != true): ;?>';        
        $parseStr .= '
                    function addImg(imgsrc, obj, class_name){
                        var name = $(obj).attr("file-name");
                        var html = \'<div class="padding border float-left margin-right badge-corner"><span class="imgremove badge bg-red">X</span><img src="\'+imgsrc+\'" class="img-border radius-small" />\';
                        html += \'<input name="\'+name+\'" ' . $id . ' class="input \'+class_name+\'" type="hidden" value="\'+imgsrc+\'" ' . $addstr . '>\';
                        if($(obj).attr("more") == 1){
                            html += \'<br><button class="imgprev button border-main button-little float-left"  type="button" >前移</button><button class="imgnext button border-sub button-little float-right"  type="button" >后移</button></div>\';
                        }
                        if($(obj).attr("more") == 1){
                            $(obj).siblings(".imgdiv").append(html);
                        }else{
                            $(obj).siblings(".imgdiv").html(html);
                        }
                        // return html;
                    }
                    $(document).ready(function() {
                        $(document).on("click", ".imgremove", function(event) {
                            $(this).parent("div").remove();
                        });
                        $(document).on("click", ".imgprev", function(event) {
                            $(this).parent("div").after($(this).parent("div").prev("div").prop("outerHTML"));
                            $(this).parent("div").prev("div").remove();
                        });
                        $(document).on("click", ".imgnext", function(event) {
                            $(this).parent("div").before($(this).parent("div").next("div").prop("outerHTML"));
                            $(this).parent("div").next("div").remove();
                        });
                    });
                    ';
        $parseStr .= '<?php $_has_addimg = true; endif;?>';
        $parseStr .= 'if(' . $nameTmp . '_imgstr != "" && ' . $nameTmp . '_imgarr){
                        $.each(' . $nameTmp . '_imgarr, function(index, val) {
                            // console.log(val);
                            addImg(val, "#' . $nameTmp . '_button",\''.$class.'\');
                        });
                    }
                    var ' . $nameTmp . ' = UE.getEditor("' . $nameTmp . '");
                    ' . $nameTmp . '.ready(function (){
                        //设置编辑器不可用(事实上不可以设置不可用...所以注释掉,以观后效)
                        // ' . $nameTmp . '.setDisabled();
                        //隐藏编辑器,因为只使用上传功能
                        ' . $nameTmp . '.hide();
                        //侦听图片上传
                        ' . $nameTmp . '.addListener(\'beforeInsertImage\',function(t,arg){
                            console.log(arg);
                            var imgsrc = arg[0].src;
                        ';
        if ($more) {
            $parseStr .= '
                            $.each(arg, function(index, val) {
                                imgsrc = val.src;';
        }
        //将图片地址赋给input
        $parseStr .= '
                            // $("#' . $nameTmp . '_button").prev("input[type=text]").val(imgsrc);
                                addImg(imgsrc, "#' . $nameTmp . '_button",\''.$class.'\');';
        if ($more) {
            $parseStr .= '
                        });';
        }
        $parseStr .= '
                        // if(layer) layer.msg("上传成功！");
                        });
                    });
                    //上传dialog
                    $(document).ready(function() {
                        $("#' . $nameTmp . '_button").click(function(event) {
                            var myImage = ' . $nameTmp . '.getDialog("insertimage");
                            // var myImage = ' . $nameTmp . '.getDialog("attachment");
                            myImage.open();
                        });
                    });
                    </script>';
        $parseStr .= '<div class="clear"></div><div class="input-note">' . $note . '</div>';
        $parseStr .= '</div></div>';
        return $parseStr;
    }
    /**
     * +----------------------------------------------------------
     * timer标签解析
     * 格式： <html:input type="" value="" />
     * +----------------------------------------------------------
     *
     * @access public
     *         +----------------------------------------------------------
     * @param string $attr
     *            标签属性
     *            +----------------------------------------------------------
     * @return string|void +----------------------------------------------------------
     */
    public function tagTimer($attr)
    {
        $tag   = $this->parseXmlAttr($attr, 'input');
        $id    = $tag['id']; // name 和 id
        $value = $tag['value'] ? $tag['value'] : ''; // 文本框值
        $class = $tag['class'] ? " " . $tag['class'] : ''; // 文本框值
        $arg   = $tag['arg'] ? $tag['arg'] : ''; // 文本框值
        $tip   = $tag['tip']; // span tip提示内容
        $style = $tag['style']; // 附加样式 style="widht:100"
        $parseStr = "";
        if ($tip) {
            if ($style) {
                $style = 'style="' . $style . '"';
            }
            $parseStr = '<input onclick="WdatePicker(' . $arg . ');" name="' . $id . '" id="' . $id . '" ' . $style . ' class="input' . $class . '" type="text" value="' . $value . '"><span id="tip_' . $id . '" class="tip">' . $tip . '</span>';
        } else {
            if ($style) {
                $style = 'style="' . $style . '"';
            }
            $parseStr = '<input onclick="WdatePicker(' . $arg . ');" name="' . $id . '" id="' . $id . '" ' . $style . ' class="input' . $class . '" type="text" value="' . $value . '">';
        }
        return $parseStr;
    }
    /**
     * +----------------------------------------------------------
     * text标签解析
     * 格式： <html:text type="" value="" />
     * +----------------------------------------------------------
     *
     * @access public
     *         +----------------------------------------------------------
     * @param string $attr
     *            标签属性
     *            +----------------------------------------------------------
     * @return string|void +----------------------------------------------------------
     */
    public function tagTextarea($tag)
    {
        $id   = @$tag['id']; // name 和 id
        $name = $this->getVal(@$tag['name']); // name 和 id
        $addstr = isset($tag['addstr']) ? $tag['addstr'] : '';
        $value  = ''; // 文本框值
        $label     = $this->getVal(@$tag['label']); // span tip提示内容
        $note      = $this->getVal(@$tag['note']); // span tip提示内容
        $style     = isset($tag['style']) ? $tag['style'] : ''; // 附加样式 style="widht:100"
        $className = isset($tag['class']) ? " " . $tag['class'] : ''; // 附加样式 style="widht:100"
        $name  = '<?php echo ' . $name . ';?>';
        $label = '<?php echo ' . $label . ' . \'：\';?>';
        $note  = $note ? '<?php echo ' . $note . ';?>' : '';
        if (isset($tag['value'])) {
            $value = $this->autoBuildVar($tag['value']); // 文本框值
            $value = '<?php echo ' . $value . ';?>';
        }
        $parseStr = '<div class="form-group"><div class="label"><label>' . $label . '</label></div><div class="field">';
        if ($style) {
            $style = 'style="' . $style . '"';
        }
        if ($id) {
            $id = 'id="' . $id . '"';
        }
        $parseStr .= '<textarea name="' . $name . '" ' . $id . ' ' . $style . ' class="input' . $className . '" type="text" ' . $addstr . '>';
        $parseStr .= $value;
        $parseStr .= '</textarea>';
        $parseStr .= '<div class="input-note">' . $note . '</div>';
        $parseStr .= '</div></div>';
        return $parseStr;
    }
    /**
     * +----------------------------------------------------------
     * editor标签解析 插入可视化编辑器
     * 格式： <html:editor id="editor" name="remark" type="FCKeditor" style="" >{$vo.remark}</html:editor>
     * +----------------------------------------------------------
     *
     * @access public
     *         +----------------------------------------------------------
     * @param string $attr
     *            标签属性
     *            +----------------------------------------------------------
     * @return string|void +----------------------------------------------------------
     */
    public function tagEditor($tag, $content)
    {
        $id     = $this->getVal(@$tag['id']);
        $name   = $this->getVal(@$tag['name']);
        $id = '<?php echo ' . $id . ' ;?>';
        $name = '<?php echo ' . $name . ' ;?>';
        $class  = @$tag['class'];
        $addstr = isset($tag['addstr']) ? $tag['addstr'] : '';
        $type   = isset($tag['type']) ? $tag['type'] : 'ueditor';
        $note      = $this->getVal(@$tag['note']); // span tip提示内容
        $note  = $note ? '<?php echo ' . $note . ';?>' : '';
        $label = $this->getVal(@$tag['label']);
        $label = '<?php echo ' . $label . ' . \'：\';?>';
        $parseStr = '<div class="form-group"><div class="label"><label>' . $label . '</label></div><div class="field">';
        $parseStr .= '<textarea name="' . $name . '" ';
        if (!empty($id)) {
            $parseStr .= 'id="' . $id . '" ';
        }
        if (!empty($class)) {
            $parseStr .= 'class="' . $class . '" ';
        }
        $parseStr .= $addstr . '>' . $content . '</textarea>';
        switch (strtolower($type)) {
            case 'ueditor':
                $parseStr .= '<?php if(!isset($_ueditor) || $_ueditor != true): ;?>';
                $parseStr .= '<script type="text/javascript">var ueControllerPath = "' . Url::build('Ueditor/index') . '";</script>';
                $parseStr .= '<script type="text/javascript" src="'.Config::get('view_replace_str.__STATIC__').'backend/plugin/ueditor/ueditor.config.js"></script>';
                $parseStr .= '<script type="text/javascript" src="'.Config::get('view_replace_str.__STATIC__').'backend/plugin/ueditor/ueditor.all.min.js"></script>';
                $parseStr .= '<script type="text/javascript" src="'.Config::get('view_replace_str.__STATIC__').'backend/plugin/ueditor/lang/zh-cn/zh-cn.js"></script>';
                $parseStr .= '<?php $_ueditor = true; endif;?>';
                $parseStr .= '<script>var ue = UE.getEditor("' . $id . '"); </script>';
                break;
            default:
                break;
        }
        $parseStr .= '<div class="input-note">' . $note . '</div>';
        $parseStr .= "</div></div>";
        return $parseStr;
    }
    /**
     * +----------------------------------------------------------
     * select标签解析
     * 格式： <html:select options="name" selected="value" />
     * +----------------------------------------------------------
     *
     * @access public
     *         +----------------------------------------------------------
     * @param string $attr
     *            标签属性
     *            +----------------------------------------------------------
     * @return string|void +----------------------------------------------------------
     */
    public function tagSelect($tag, $content)
    {
        $name     = $this->getVal(@$tag['name']);
        $name = '<?php echo ' . $name . ' ;?>';
        $option   = $tag['option'];
        $prefix   = @$tag['prefix'] ? $tag['prefix'] : 'prefix';
        $addstr   = isset($tag['addstr']) ? $tag['addstr'] : '';
        $ext_attr = isset($tag['ext_attr']) ? $tag['ext_attr'] : '';
        $id    = @$tag['id'];
        $class = 'input ' . @$tag['class'];
        $label = $this->getVal(@$tag['label']);
        $label = '<?php echo ' . $label . ' . \'：\';?>';
        $value    = $tag['value'];
        $selected = isset($tag['selected']) ? $this->getVal($tag['selected']) : '';
        // 允许使用函数设定数据集 <volist name=":fun('arg')" id="vo">{$vo.name}</volist>
        $parseStr = '<div class="form-group"><div class="label"><label>' . $label . '</label></div><div class="field">';
        $parseStr .= '<?php ';
        $flag = substr($option, 0, 1);
        if (':' == $flag) {
            $option = $this->autoBuildVar($option);
            $parseStr .= '$_result=' . $option . ';';
            $option = '$_result';
        } else {
            $option = $this->autoBuildVar($option);
        }
        $parseStr .= 'if(is_array(' . $option . ') || ' . $option . ' instanceof \think\Collection): ';
        // 设置了输出数组长度
        $parseStr .= ' $__LIST__ = ' . $option . ';';
        $ext_attr_arr = $ext_attr ? explode(',', $ext_attr) : [];
        $parseStr .= ' $__ATTR__ = \'' . $ext_attr . '\';';
        $parseStr .= ' $__ATTR__ = $__ATTR__ ? explode(\',\', $__ATTR__) : [];';
        $parseStr .= 'if( count($__LIST__)==0 ) : echo "' . '" ;';
        $parseStr .= 'else: ?>';
        $parseStr .= '<select name="' . $name . '" ';
        if (!empty($id)) {
            $parseStr .= 'id="' . $id . '" ';
        }
        if (!empty($class)) {
            $parseStr .= 'class="' . $class . '" ';
        }
        if ($selected != '') {
            $parseStr .= 'data-select="<?php echo ' . $selected . ' ;?>" ';
        }
        $parseStr .= $addstr . '>';
        $valueto = explode("->", $value);
        if (!isset($valueto[1])) {
            $valueto[1] = $valueto[0];
        }
        $parseStr .= '<option value="0">--请选择--</option>';
        $parseStr .= '<?php foreach($__LIST__ as $val): ?>';
        $parseStr .= '<option value="<?php echo $val[\'' . $valueto[0] . '\'];?>" ';
        $parseStr .= '<?php foreach($__ATTR__ as $val_attr): ';
        $parseStr .= 'echo isset($val[$val_attr]) ? $val_attr.\'="\'.$val[$val_attr].\'"\' : \'\';';
        $parseStr .= ' endforeach; ?>';
        $parseStr .= '> <?php echo (isset($val[\'' . $prefix . '\']) ? $val[\'' . $prefix . '\'] : "").$val[\'' . $valueto[1] . '\'];?></option>';
        $parseStr .= '<?php endforeach; endif; ?>';
        $parseStr .= '</select>';
        $parseStr .= '<?php else: echo "' . '" ;endif; ?>';
        $parseStr .= '<div class="tips"></div></div></div>';
        if (!empty($parseStr)) {
            return $parseStr;
        }
        return;
    }
    /**
     * @access public
     *         +----------------------------------------------------------
     * @param string $attr
     *            标签属性
     *            +----------------------------------------------------------
     * @return string|void +----------------------------------------------------------
     */
    public function tagRadio($tag)
    {
        $id       = @$tag['id'];
        $class    = @$tag['class'];
        $label    = $this->getVal(@$tag['label']);
        $note     = $this->getVal(@$tag['note']); // span tip提示内容
        $name     = $this->getVal(@$tag['name']);
        $name = '<?php echo ' . $name . ' ;?>';
        $option   = $tag['value'];
        $default  = $this->getVal(@$tag['default']);
        $parseStr = "";
        $label = '<?php echo ' . $label . ' . \'：\';?>';
        $note  = $note ? '<?php echo ' . $note . ';?>' : '';
        $parseStr = '<div class="form-group"><div class="label"><label>' . $label . '</label></div><div class="field"><div class="button-group border-main radio">';
        if (!empty($id)) {
            $id .= 'id="' . $id . '" ';
        }
        $parseStr .= '<?php ';
        $flag = substr($option, 0, 1);
        if (':' == $flag) {
            $option = $this->autoBuildVar($option);
            $parseStr .= '$_result=' . $option . ';';
            $option = '$_result';
        } else {
            $option = $this->autoBuildVar($option);
        }
        $parseStr .= ' $__LIST__ = ' . $option . ';';
        $parseStr .= ' foreach($__LIST__ as $key => $val): ?>';
        $parseStr .= '<label class="button ' . $class . ' <?php if(!is_null(' . $default . ') && $key == ' . $default . '): echo "active"; endif;?>" ' . $id . '><input name="' . $name . '" value="<?php echo $key;?>" type="radio" <?php if(!is_null(' . $default . ') && $key == ' . $default . '): echo "checked=\"checked\""; endif;?>><?php echo $val;?></label>';
        $parseStr .= '<?php endforeach; ?>';
        $parseStr .= '</div>';
        $parseStr .= '<div class="input-note">' . $note . '</div>';
        $parseStr .= '</div></div>';
        return $parseStr;
    }
    public function tagCheckbox($tag)
    {
        $id       = @$tag['id'];
        $class    = @$tag['class'];
        $label    = $this->getVal(@$tag['label']);
        $note     = $this->getVal(@$tag['note']); // span tip提示内容        
        $name     = $this->getVal(@$tag['name']);
        $name     = '<?php echo ' . $name . ' ;?>'. '[]';
        $option   = $tag['value'];
        $default  = $this->getVal(@$tag['default']);
        $parseStr = "";
        $label = '<?php echo ' . $label . ' . \'：\';?>';
        $note  = $note ? '<?php echo ' . $note . ';?>' : '';
        $parseStr = '<div class="form-group"><div class="label"><label>' . $label . '</label></div><div class="field"><div class="button-group border-main checkbox">';
        if (!empty($id)) {
            $id .= 'id="' . $id . '" ';
        }
        $parseStr .= '<?php ';
        $flag = substr($option, 0, 1);
        if (':' == $flag) {
            $option = $this->autoBuildVar($option);
            $parseStr .= '$_result=' . $option . ';';
            $option = '$_result';
        } else {
            $option = $this->autoBuildVar($option);
        }
        $parseStr .= ' $__LIST__ = ' . $option . ';';
        $parseStr .= ' foreach($__LIST__ as $key => $val): ?>';
        $parseStr .= '<label class="button ' . $class . ' <?php if(!is_null(' . $default . ') && $key == ' . $default . '): echo "active"; endif;?>" ' . $id . '><input name="' . $name . '" value="<?php echo $key;?>" type="checkbox" <?php if(!is_null(' . $default . ') && $key == ' . $default . '): echo "checked=\"checked\""; endif;?>><?php echo $val;?></label>';
        $parseStr .= '<?php endforeach; ?>';
        $parseStr .= '</div>';
        $parseStr .= '<div class="input-note">' . $note . '</div>';
        $parseStr .= '</div></div>';
        return $parseStr;
    }
    private function getVal($value = '')
    {        
        $flag = substr($value, 0, 1);
        if ('$' == $flag || ':' == $flag) {
            $value = $this->autoBuildVar($value);
        } else {
            $value = '\'' . $value . '\'';
        }
        return $value;
    }
}
