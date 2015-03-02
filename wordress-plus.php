<?php
/*
Plugin Name: WordPress Plus +
Plugin URI: http://blog.czelo.com/wordpress_plus
Description: 多个小工具和功能集合插件，轻松增强和加速你的WordPress（仅建议中国大陆博主使用）
Version: 1.5 Beta
Author: CEO
Author URI: http://blog.czelo.com/
*/

// 启用插件自动跳转至设置 //
register_activation_hook(__FILE__, 'plugin_activate');
add_action('admin_init', 'plugin_redirect');
function plugin_activate()
{
    add_option('do_activation_redirect', true);
}
function plugin_redirect()
{
    if (get_option('do_activation_redirect', false)) {
        delete_option('do_activation_redirect');
        wp_redirect(admin_url('options-general.php?page=wordpress_plus'));
    }
}

// 添加插件控制面板 //
function register_plugin_settings_link($links)
{
    $settings_link = '<a href="options-general.php?page=wordpress_plus">设置</a>';
    array_unshift($links, $settings_link);
    return $links;
}
$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_{$plugin}", 'register_plugin_settings_link');


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
    // 表单提交后执行的操作 //
    if ($_POST['update_pluginoptions'] == 'true') {
        echo '<p><div id="message" class="updated"><p>设置已保存</p></div></p>';
        pluginoptions_update();
        echo "<script type='text/javascript'>document.location.href='options-general.php?page=wordpress_plus'</script>";
    }
?>
<div class="wrap">
<p>
<h2>WordPress Plus + 插件控制面板</h2>
<h3>欢迎使用WordPress Plus + 插件，请按需调整插件功能！</h3> 
<div id="message" class="updated"><p>WordPress Plus + 1.5 版本更新内容：</br>新增 禁止站内文章PingBack 和 自动为博客内的连接添加nofollow属性并在新窗口打开链接 功能</div>
</p>
<form method="POST" action="">
<input type="hidden" name="update_pluginoptions" value="true" />
<input type="checkbox" name="msyh" id="msyh" <?php
    echo get_option('wpplus_msyh');
?> /> 修改后台中文字体为微软雅黑<p>
<input type="checkbox" name="googlefont" id="googlefont" <?php
    echo get_option('wpplus_googlefont');
?> /> Open-Sans加载源替换为360前端库CDN<p>
<input type="checkbox" name="sslgravatar" id="sslgravatar" <?php
    echo get_option('wpplus_sslgravatar');
?> /> 使用SSL方式调用Gravatar头像<p>
<input type="checkbox" name="pingback" id="pingback" <?php
    echo get_option('wpplus_pingback');
?> /> 禁止站内文章相互PingBack（部分主题带有此功能）<p>
<input type="checkbox" name="nofollow" id="nofollow" <?php
    echo get_option('wpplus_nofollow');
?> /> 自动为博客内的连接添加nofollow属性并在新窗口打开链接<p>
<input type="submit" class="button-primary" value="保存设置" />
<p>WordPress Plus + 版本 1.5 &nbsp; 插件作者为<a href="http://blog.czelo.com">CEO</a>
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
    update_option('wpplus_msyh', $display);
    if ($_POST['googlefont'] == 'on') {
        $display = 'checked';
    } else {
        $display = '';
    }
    update_option('wpplus_googlefont', $display);
    if ($_POST['sslgravatar'] == 'on') {
        $display = 'checked';
    } else {
        $display = '';
    }
    update_option('wpplus_sslgravatar', $display);
	if ($_POST['pingback'] == 'on') {
        $display = 'checked';
    } else {
        $display = '';
    }
    update_option('wpplus_nofollow', $display);
	if ($_POST['nofollow'] == 'on') {
        $display = 'checked';
    } else {
        $display = '';
    }
    update_option('wpplus_nofollow', $display);
}
?>
<?php
if (get_option('wpplus_msyh') == 'checked') {
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
if (get_option('wpplus_googlefont') == 'checked') {
?>
<?php
    // 修改Open_sans加载源为360前端库CDN //
    function devework_replace_open_sans()
    {
        wp_deregister_style('open-sans');
        wp_register_style('open-sans', '//fonts.useso.com/css?family=Open+Sans:300italic,400italic,600italic,300,400,600');
        wp_enqueue_style('open-sans');
        if (is_admin())
            wp_enqueue_style('open-sans');
    }
    add_action('wp_enqueue_scripts', 'devework_replace_open_sans');
    add_action('admin_enqueue_scripts', 'devework_replace_open_sans');
    add_action('init', 'devework_replace_open_sans');
?>
<?php
}
?>
<?php
if (get_option('wpplus_sslgravatar') == 'checked') {
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
if (get_option('wpplus_pingback') == 'checked') {
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
if (get_option('wpplus_nofollow') == 'checked') {
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