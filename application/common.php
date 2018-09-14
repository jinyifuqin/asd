<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 默认公共函数
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */

// 应用公共文件
use think\Cache;
use think\Config;
use think\Request;
use app\common\model\Ad;
use app\common\model\AdList;
use app\common\model\Nav;
use app\common\model\Link;
use app\common\model\Category;

use app\common\model\Fragment;

use app\common\model\Article;
use app\common\model\Job;

use app\common\model\ProductCate;

use app\common\model\ProductBrand;



/**
 * 根据导航id获取其所有子导航并分级
 * @param $parent_id 导航id
 * @return array
 */
function get_nav_child_all($parent_id = '0')
{
    $result = Cache::remember('navChildAll' . $parent_id, function () use ($parent_id) {
        $parent_id = is_int($parent_id) ? $parent_id : Nav::where('guid', $parent_id)->value('id');
        $result = Nav::all(function ($query) use ($parent_id) {
            $query->order('order_id', 'desc');
            if ($parent_id > 0) {
                $query->where(function($query) use ($parent_id) {
                    $query->where('parent_id', $parent_id)->whereOr('parent_path', 'like', '%,' . $parent_id . ',%');
                });
            }
        });
        return list_to_child($result, $parent_id);
    });
    return $result;
}
function get_nav_child($parent_id = '0')
{
    $result = Cache::remember('navChild' . $parent_id, function () use ($parent_id) {
        $parent_id = is_int($parent_id) ? $parent_id : Nav::where('guid', $parent_id)->value('id');
        $result = Nav::all(function ($query) use ($parent_id) {
            $query->order('order_id', 'desc');
            if ($parent_id > 0) {
                $query->where('parent_id', $parent_id);
            }
        });
        return $result;
    });
    return $result;
}

/**
 * 根据广告位id获取广告列表
 * @param $ad_id 广告id
 * @return array
 */
function get_ad_list($ad_id = '0')
{
    $getCd = is_int($ad_id) ? ['id' => $ad_id] : ['guid' => $ad_id];
    $ad_id = Ad::where($getCd)->where('is_show', 1)->value('id');
    return AdList::where(['ad_id' => $ad_id, 'is_show' => 1])
        ->field('ad_name,ad_img,ad_link,ad_target')
        ->order('order_id desc, id desc')
        ->select();
}

/**
 * 根据栏目id获取其所有子栏目并分级
 * @param $parent_id 栏目父id
 * @return array
 */
function get_cate_child_all($parent_id = '0')
{
    $result = Cache::remember('cateChildAll' . $parent_id, function () use ($parent_id) {
        $parent_id = is_int($parent_id) ? $parent_id : Category::where('guid', $parent_id)->value('id');
        $result = Category::all(function ($query) use ($parent_id) {
            $query->order('order_id', 'desc');
            if ($parent_id > 0) {                
                $query->where(function($query) use ($parent_id) {
                    $query->where('parent_id', $parent_id)->whereOr('parent_path', 'like', '%,' . $parent_id . ',%');
                });
            }
        });
        return list_to_child($result, $parent_id);
    });
    return $result;
}
function get_cate_child($parent_id = '0')
{
    $result = Cache::remember('cateChild' . $parent_id, function () use ($parent_id) {
        $parent_id = is_int($parent_id) ? $parent_id : Category::where('guid', $parent_id)->value('id');
        $result = Category::all(function ($query) use ($parent_id) {
            $query->order('order_id', 'desc');
            if ($parent_id > 0) {
                $query->where('parent_id', $parent_id);
            }
        });
        return $result;
    });
    return $result;
}

function get_cate($cate_id){
    $cate = Category::get(function($query) use ($cate_id){
        $getCd = is_int($cate_id) ? ['id' => $cate_id] : ['guid'=>$cate_id];
        $query->where($getCd)->where('is_show', 'eq',1);
    });    
    if(!$cate) return [];
    //查询其碎片数据
    $fragment = Fragment::field('id,guid,title,content')->where('cate_id', 'eq', $cate->id)->select();    
    foreach ($fragment as $key => $value) {
        $guid  = $value->guid;
        $cate->$guid = $value->content;
    }    
    return $cate;   
}
function get_cate_name($cate_id){
    $getCd = is_int($cate_id) ? ['id' => $cate_id] : ['guid'=>$cate_id];
    $cate_name = Category::where($getCd)->where('is_show', 'eq',1)->value('cate_name');
    return $cate_name ? $cate_name : '';
}
function get_cate_img($cate_id){
    $getCd = is_int($cate_id) ? ['id' => $cate_id] : ['guid'=>$cate_id];
    $cate_img = Category::where($getCd)->where('is_show', 'eq',1)->value('cate_img');
    return $cate_img ? $cate_img : '';
}
function get_cate_content($cate_id){
    $getCd = is_int($cate_id) ? ['id' => $cate_id] : ['guid'=>$cate_id];
    $cate_content = Category::where($getCd)->where('is_show', 'eq',1)->value('content');
    return $cate_content ? $cate_content : '';
}
function get_cate_description($cate_id){
    $getCd = is_int($cate_id) ? ['id' => $cate_id] : ['guid'=>$cate_id];
    $description = Category::where($getCd)->where('is_show', 'eq',1)->value('description');
    return $description ? $description : '';
}

/**
 * 碎片数据
 * @param $frag_id 碎片id或碎片标识
 */

function get_fragment($frag_id){
    $getCd = is_int($frag_id) ? ['id' => $frag_id] : ['guid'=>$frag_id];
    $fragment = Fragment::where($getCd)->where('is_show', 'eq',1)->value('content');
    return $fragment ? $fragment : '';
}


/**
 * 文章
 * @param $cate_id 栏目id
 * @param $limit 数量，0|不限
 * @param $type 类型，default|默认，hot|热门
 * @return array
 */
function get_article_list($cate_id, $limit = 0, $type = 'default'){    
    $cate_id = is_int($cate_id) ? $cate_id : Category::where('guid', $cate_id)->value('id');
    $article = new Article;
    $article->where(function($query) use ($cate_id) {
        $query->where('cate_id', $cate_id)->whereOr('parent_path', 'like', '%,'.$cate_id.',%');
    });
    $article->where('is_show', 'eq',1);
    switch ($type) {
        case 'hot':
            $order = ['views' => 'desc', 'order_id' => 'desc', 'update_time' => 'desc', 'id' => 'desc'];
            break;        
        case 'default':
        default:
            $order = ['order_id' => 'desc', 'update_time' => 'desc', 'id' => 'desc'];
            break;
    }
    $article->order($order);
    if($limit > 0){
        $result = $article->paginate($limit);
    }else{
        $result = $article->select();
    }    
    return $result;
}

function get_article($art_id){
    Article::where('id', $art_id)->setInc('views', 1);
    $result = Article::get(function($query) use ($art_id){
        $query->where('id', $art_id);
    });
    return $result;   
}

function get_link($link_type = '0'){
    $result = Cache::remember('link' . $link_type, function () use ($link_type) {
        $result = Link::all(function ($query) use ($link_type) {
            $query->order('order_id', 'desc');
            if ($link_type > 0) {
                $query->where('link_type', $link_type);
            }
        });
        return $result;
    });
    return $result;
}

function get_job_list($cate_id = '', $limit = 0){
    $job = new Job;
    if($cate_id){
        $job->where(function($query) use ($cate_id) {
            $query->where('cate_id', $cate_id)->whereOr('parent_path', 'like', '%,'.$cate_id.',%');
        });
    }
    $job->order(['order_id' => 'desc', 'update_time' => 'desc', 'id' => 'desc']);
    if($limit > 0){
        $result = $job->paginate($limit);
    }else{
        $result = $job->select();
    }
    return $result;
}
function get_job($job_id){
    $result = Job::get(function($query) use ($job_id){
        $query->where('id', $job_id);
    });
    return $result;   
}


// 以下是产品部分


function get_pro_cate_child_all($parent_id = '0')
{
    $result = Cache::remember('proCateChildAll' . $parent_id, function () use ($parent_id) {
        $result = ProductCate::all(function ($query) use ($parent_id) {
            $query->order('order_id', 'desc');
            if ($parent_id > 0) {                
                $query->where(function($query) use ($parent_id) {
                    $query->where('parent_id', $parent_id)->whereOr('parent_path', 'like', '%,' . $parent_id . ',%');
                });
            }
        });
        return list_to_child($result, $parent_id);
    });
    return $result;
}
function get_pro_cate_child($parent_id = '0')
{
    $result = Cache::remember('proCateChild' . $parent_id, function () use ($parent_id) {
        $result = ProductCate::all(function ($query) use ($parent_id) {
            $query->order('order_id', 'desc');
            // if ($parent_id > 0) {
                $query->where('parent_id', $parent_id);
            // }
        });
        return $result;
    });
    return $result;
}

function get_brand_list($parent_id = '', $limit = '')
{
    
    $brand = new ProductBrand;
    $brand->where(function ($query) use ($parent_id) {
        if (!is_null($parent_id)) {
            $query->where(function($query) use ($parent_id) {
                $query->where('parent_id', $parent_id)->whereOr('parent_path', 'like', '%,' . $parent_id . ',%');
            });
        }
    });
    $brand->order(['order_id' => 'desc', 'update_time' => 'desc', 'id' => 'desc']);
    if($limit > 0){
        $result = $brand->paginate($limit);
    }else{
        $result = $brand->select();
    }
    return $result;
    
}

/**
 * 自动生成网站头部TDK信息
 */
function get_seo($cid = '', $id = '', $str = ''){        
    $seoHtml = '';
    $request = Request::instance();
    $setting = Config::get('setting');
    $title       = $setting['title'];
    $generator   = $setting['generator'];
    $author      = $setting['author'];
    $keywords    = $setting['keywords'];
    $description = $setting['description'];
    $cid = !empty($cid) ? $cid : ($request->has('guid') ? $request->param('guid') : ($request->has('cid') ? $request->has('cid') : ''));    
    $id = !empty($id) ? $id : ($request->has('id') ? $request->param('id') : '');
    if(!empty($cid)){
        $getCd = is_int($cid) ? ['id' => $cid] : ['guid'=>$cid];
        $cate  = Category::field('cate_name,seo,keywords,description')->where($getCd)->find();
        $cate and $title = !empty($cate['seo']) ? $cate['seo'] : $cate['cate_name']. ' - '.$title;
    }
    if(!empty($id)){
        $article = Article::field('title,seo,keywords,description,cate_id')->find($id);        
        if(empty($cate) && !empty($article)){            
            $cate = Category::field('cate_name,seo,keywords,description')->find($article['cate_id']);             
            $cate and $title = !empty($cate['seo']) ? $cate['seo'] : $cate['cate_name']. ' - '.$title;
        }
        $article and $title = !empty($article['seo']) ? $article['seo'] : $article['title']. ' - '.$title;
    }
    if(!empty($article)){
        $keywords    = !empty($article['keywords']) ? $article['keywords']  : $keywords;
        $description = !empty($article['description']) ? $article['description']  : $description;
    }elseif(!empty($cate)){
        $keywords    = !empty($cate['keywords']) ? $cate['keywords']  : $keywords;   
        $description = !empty($cate['description']) ? $cate['description']  : $description;
    }else{        
        $title = $setting['seo'] ? $setting['seo'] : $title;
    }
    empty($str) or $title = $str;
    //默认显示首页seo标题    
    $seoHtml .= '<title>'.$title.'</title>'.PHP_EOL;
    $seoHtml .= '<meta name="generator" content="'.$generator.'" />'.PHP_EOL;
    $seoHtml .= '<meta name="author" content="'.$author.'" />'.PHP_EOL;
    $seoHtml .= '<meta name="keywords" content="'.$keywords.'" />'.PHP_EOL;
    $seoHtml .= '<meta name="description" content="'.$description.'" />';
    return $seoHtml;
}


//get拦截规则
$getfilter = "\\<.+javascript:window\\[.{1}\\\\x|<.*=(&#\\d+?;?)+?>|<.*(data|src)=data:text\\/html.*>|\\b(alert\\(|confirm\\(|expression\\(|prompt\\(|benchmark\s*?\(.*\)|sleep\s*?\(.*\)|\\b(group_)?concat[\\s\\/\\*]*?\\([^\\)]+?\\)|\bcase[\s\/\*]*?when[\s\/\*]*?\([^\)]+?\)|load_file\s*?\\()|<[a-z]+?\\b[^>]*?\\bon([a-z]{4,})\s*?=|^\\+\\/v(8|9)|\\b(and|or)\\b\\s*?([\\(\\)'\"\\d]+?=[\\(\\)'\"\\d]+?|[\\(\\)'\"a-zA-Z]+?=[\\(\\)'\"a-zA-Z]+?|>|<|\s+?[\\w]+?\\s+?\\bin\\b\\s*?\(|\\blike\\b\\s+?[\"'])|\\/\\*.*\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)|UPDATE\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE)@{0,2}(\\(.+\\)|\\s+?.+?\\s+?|(`|'|\").*?(`|'|\"))FROM(\\(.+\\)|\\s+?.+?|(`|'|\").*?(`|'|\"))|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
//post拦截规则
$postfilter = "<.*=(&#\\d+?;?)+?>|<.*data=data:text\\/html.*>|\\b(alert\\(|confirm\\(|expression\\(|prompt\\(|benchmark\s*?\(.*\)|sleep\s*?\(.*\)|\\b(group_)?concat[\\s\\/\\*]*?\\([^\\)]+?\\)|\bcase[\s\/\*]*?when[\s\/\*]*?\([^\)]+?\)|load_file\s*?\\()|<[^>]*?\\b(onerror|onmousemove|onload|onclick|onmouseover)\\b|\\b(and|or)\\b\\s*?([\\(\\)'\"\\d]+?=[\\(\\)'\"\\d]+?|[\\(\\)'\"a-zA-Z]+?=[\\(\\)'\"a-zA-Z]+?|>|<|\s+?[\\w]+?\\s+?\\bin\\b\\s*?\(|\\blike\\b\\s+?[\"'])|\\/\\*.*\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)|UPDATE\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE)(\\(.+\\)|\\s+?.+?\\s+?|(`|'|\").*?(`|'|\"))FROM(\\(.+\\)|\\s+?.+?|(`|'|\").*?(`|'|\"))|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
//cookie拦截规则
$cookiefilter = "benchmark\s*?\(.*\)|sleep\s*?\(.*\)|load_file\s*?\\(|\\b(and|or)\\b\\s*?([\\(\\)'\"\\d]+?=[\\(\\)'\"\\d]+?|[\\(\\)'\"a-zA-Z]+?=[\\(\\)'\"a-zA-Z]+?|>|<|\s+?[\\w]+?\\s+?\\bin\\b\\s*?\(|\\blike\\b\\s+?[\"'])|\\/\\*.*\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)|UPDATE\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE)@{0,2}(\\(.+\\)|\\s+?.+?\\s+?|(`|'|\").*?(`|'|\"))FROM(\\(.+\\)|\\s+?.+?|(`|'|\").*?(`|'|\"))|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
//referer获取
$webscan_referer = empty($_SERVER['HTTP_REFERER']) ? array() : array('HTTP_REFERER'=>$_SERVER['HTTP_REFERER']);

/*
参数拆分
*/

function webscan_arr_foreach($arr) {
  static $str;
  static $keystr;
  if (!is_array($arr)) {
    return $arr;
  }
  foreach ($arr as $key => $val ) {
    $keystr=$keystr.$key;
    if (is_array($val)) {

      webscan_arr_foreach($val);
    } else {

      $str[] = $val.$keystr;
    }
  }
  return implode($str);
}

/**
 *  攻击检查拦截
 */
 
function webscan_StopAttack($StrFiltKey,$StrFiltValue,$ArrFiltReq) {
  $StrFiltValue=webscan_arr_foreach($StrFiltValue);
  if (preg_match("/".$ArrFiltReq."/is",$StrFiltValue)==1){
    exit('代码君已私奔到月球~');
  }
  if (preg_match("/".$ArrFiltReq."/is",$StrFiltKey)==1){
    exit('代码君已私奔到月球~');
  }

}

foreach($_GET as $key=>$value) {
    webscan_StopAttack($key,$value,$getfilter);
}

foreach($_POST as $key=>$value) {
    webscan_StopAttack($key,$value,$postfilter);
}

foreach($_COOKIE as $key=>$value) {
    webscan_StopAttack($key,$value,$cookiefilter);
}

foreach($webscan_referer as $key=>$value) {
    webscan_StopAttack($key,$value,$postfilter);
}