<?php
/*
Plugin Name: WordPress Plus +
Plugin URI: http://blog.czelo.com/wordpress_plus
Description: 多个功能优化集合插件，轻松增强和加速你的WordPress（仅建议中国大陆博主使用）
Version: 1.6
Author: CEO
Author URI: http://blog.czelo.com/
*/

// 启用插件自动跳转至设置 //
register_activation_hook(__FILE__, 'wordpressplus_activate');
add_action('admin_init', 'wordpressplus_redirect');
function wordpressplus_activate()
{
    add_option('do_activation_redirect', true);
}
function wordpressplus_redirect()
{
    if (get_option('do_activation_redirect', false)) {
        delete_option('do_activation_redirect');
        wp_redirect(admin_url('options-general.php?page=wordpress_plus'));
    }
}

// 添加插件控制面板 //
function register_wordpressplus_settings_link($links)
{
    $settings_link = '<a href="options-general.php?page=wordpress_plus">设置</a>';
    array_unshift($links, $settings_link);
    return $links;
}
$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_{$plugin}", 'register_wordpressplus_settings_link');


// 配置插件设置 //
if (is_admin()) {
    add_action('admin_menu', 'wordpress_plus_menu');
}

// 配置插件设置 //
function wordpress_plus_menu()
{
    add_options_page('WordPress Plus + 插件控制面板', 'WordPress Plus +', 'administrator', 'wordpress_plus', 'pluginoptions_page');
}

// 插件设置核心部分 //
function pluginoptions_page()
{
    // 保存设置 //
    if ($_POST['update_pluginoptions'] == 'true') {
        echo '<p><div id="message" class="updated"><p>设置已保存</p></div></p>';
        pluginoptions_update();
        echo "<script type='text/javascript'>document.location.href='options-general.php?page=wordpress_plus'</script>";
    }
?>
<div class="wrap">
<p>
<h2>WordPress Plus + 插件控制面板</h2>
<h3>感谢使用 WordPress Plus + 插件，请按照需要启用插件功能</h3>
<div id="message" class="updated">
<p><b>1.6 版本更新说明：</b><br />解决Pingback选项不起作用的问题，并添加“调用Bing美图作为登陆界面背景”功能（背景图每日更新）！</p>
</div>
<form method="POST" action="">
<input type="hidden" name="update_pluginoptions" value="true" />
<b>功能增强</b><hr />
<input type="checkbox" name="msyh" id="msyh" <?php
    echo get_option('wordpressplus_msyh');
?> /> 修改后台中文字体为微软雅黑<p>
<input type="checkbox" name="sslgravatar" id="sslgravatar" <?php
    echo get_option('wordpressplus_sslgravatar');
?> /> 使用SSL方式调用Gravatar头像<p>
<input type="checkbox" name="bing" id="bing" <?php
    echo get_option('wordpressplus_bing');
?> /> 调用Bing美图作为登陆界面背景<p>
<b>SEO优化</b><hr />
<input type="checkbox" name="pingback" id="pingback" <?php
    echo get_option('wordpressplus_pingback');
?> /> 禁止站内文章相互PingBack<p>
<input type="checkbox" name="nofollow" id="nofollow" <?php
    echo get_option('wordpressplus_nofollow');
?> /> 自动为博客内的连接添加nofollow属性并在新窗口打开链接<p>
<input type="submit" class="button-primary" value="保存设置" />
<p>WordPress Plus + 版本 1.6 &nbsp; <a href="http://blog.czelo.com/wordpress_plus">吐槽 & 建议 请点击此处</a> &nbsp; <a href="http://blog.czelo.com/wordpress_plus#thanks">点击查看致谢名单</a>
</form>
</div>
<?php
}
// 插件设置提交验证  //
function pluginoptions_update()
{
    if ($_POST['msyh'] == 'on') {
        $display = 'checked';
    } else {
        $display = '';
    }
    update_option('wordpressplus_msyh', $display);
	
    if ($_POST['sslgravatar'] == 'on') {
        $display = 'checked';
    } else {
        $display = '';
    }
    update_option('wordpressplus_sslgravatar', $display);
	
	if ($_POST['pingback'] == 'on') {
        $display = 'checked';
    } else {
        $display = '';
    }
    update_option('wordpressplus_pingback', $display);
	
	if ($_POST['nofollow'] == 'on') {
        $display = 'checked';
    } else {
        $display = '';
    }
    update_option('wordpressplus_nofollow', $display);
	
	if ($_POST['bing'] == 'on') {
        $display = 'checked';
    } else {
        $display = '';
    }
    update_option('wordpressplus_bing', $display);
}
?>
<?php
if (get_option('wordpressplus_msyh') == 'checked') {
?>
<?php
    // 改变后台字体为微软雅黑 //
    function admin_fonts()
    {
        echo '<style type="text/css">
        * { font-family: "Microsoft YaHei" !important; }
        i, .ab-icon, .mce-close, i.mce-i-aligncenter, i.mce-i-alignjustify, i.mce-i-alignleft, i.mce-i-alignright, i.mce-i-blockquote, i.mce-i-bold, i.mce-i-bullist, i.mce-i-charmap, i.mce-i-forecolor, i.mce-i-fullscreen, i.mce-i-help, i.mce-i-hr, i.mce-i-indent, i.mce-i-italic, i.mce-i-link, i.mce-i-ltr, i.mce-i-numlist, i.mce-i-outdent, i.mce-i-pastetext, i.mce-i-pasteword, i.mce-i-redo, i.mce-i-removeformat, i.mce-i-spellchecker, i.mce-i-strikethrough, i.mce-i-underline, i.mce-i-undo, i.mce-i-unlink, i.mce-i-wp-media-library, i.mce-i-wp_adv, i.mce-i-wp_fullscreen, i.mce-i-wp_help, i.mce-i-wp_more, i.mce-i-wp_page, .qt-fullscreen, .star-rating .star { font-family: dashicons !important; }
        .mce-ico { font-family: tinymce, Arial !important; }
        .fa { font-family: FontAwesome !important; }
        .genericon { font-family: "Genericons" !important; }
        .appearance_page_scte-theme-editor #wpbody *, .ace_editor * { font-family: Monaco, Menlo, "Ubuntu Mono", Consolas, source-code-pro, monospace !important; }
        .post-type-post #advanced-sortables, .post-type-post #autopaging .description { display: none !important; }
        .form-field input, .form-field textarea { width: inherit; border-width: 0; }
        </style>';
    }
    add_action('admin_head', 'admin_fonts');
?>
<?php
}
?>
<?php
if (get_option('wordpressplus_sslgravatar') == 'checked') {
?>
<?php
    // 使用SSL方式调用Gravatar头像 //
	function ssl_gravatar( $avatar ) {
    $avatar = str_replace( array( 'http://www.gravatar.com', 'http://0.gravatar.com', 'http://1.gravatar.com', 'http://2.gravatar.com' ), 'https://secure.gravatar.com', $avatar );
    return $avatar;
	}
	add_filter( 'get_avatar', 'ssl_gravatar' );
?>
<?php
}
?>
<?php
if (get_option('wordpressplus_pingback') == 'checked') {
?>
<?php
    // 禁止站内文章PingBack //
	function no_self_ping( &$links ) {
    $home = get_option( 'home' );
    foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, $home ) ) unset($links[$l]);
	}
	add_action( 'pre_ping', 'no_self_ping' );
?>
<?php
}
?>
<?php
if (get_option('wordpressplus_nofollow') == 'checked') {
?>
<?php
    // 自动为博客内的连接添加nofollow属性并在新窗口打开链接 //
	add_filter( 'the_content', 'cn_nf_url_parse');
 
function cn_nf_url_parse( $content ) {
	$regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>";
	if(preg_match_all("/$regexp/siU", $content, $matches, PREG_SET_ORDER)) {
		if( !empty($matches) ) {
			$srcUrl = get_option('siteurl');
			for ($i=0; $i < count($matches); $i++)
			{
				$tag = $matches[$i][0];
				$tag2 = $matches[$i][0];
				$url = $matches[$i][0];
				$noFollow = '';
				$pattern = '/target\s*=\s*"\s*_blank\s*"/';
				preg_match($pattern, $tag2, $match, PREG_OFFSET_CAPTURE);
				if( count($match) < 1 )
					$noFollow .= ' target="_blank" ';
				$pattern = '/rel\s*=\s*"\s*[n|d]ofollow\s*"/';
				preg_match($pattern, $tag2, $match, PREG_OFFSET_CAPTURE);
				if( count($match) < 1 )
					$noFollow .= ' rel="nofollow" ';
				$pos = strpos($url,$srcUrl);
				if ($pos === false) {
					$tag = rtrim ($tag,'>');
					$tag .= $noFollow.'>';
					$content = str_replace($tag2,$tag,$content);
				}
			}
		}
	}
	$content = str_replace(']]>', ']]>', $content);
	return $content;
}
?>
<?php
}
?>
<?php
if (get_option('wordpressplus_bing') == 'checked') {
?>
<?php
    // 调用Bing美图作为登陆界面背景 //
	function custom_login_head(){
	$str=file_get_contents('http://cn.bing.com/HPImageArchive.aspx?idx=0&n=1');
	if(preg_match("/<url>(.+?)<\/url>/ies",$str,$matches)){
	$imgurl='http://cn.bing.com'.$matches[1];
    echo'<style type="text/css">body{background: url('.$imgurl.');width:100%;height:100%;background-image:url('.$imgurl.');-moz-background-size: 100% 100%;-o-background-size: 100% 100%;-webkit-background-size: 100% 100%;background-size: 100% 100%;-moz-border-image: url('.$imgurl.') 0;background-repeat:no-repeat\9;background-image:none\9;}</style>';
	}}
	add_action('login_head', 'custom_login_head');
?>
<?php
}
?>