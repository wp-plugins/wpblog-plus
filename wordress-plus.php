<?php
/*
Plugin Name: WordPress Plus +
Plugin URI: http://ceoblog.gq/wordpress_plus
Description: 多个小工具和功能集合插件，轻松增强和加速你的WordPress！
Version: 1.3.1
Author: CEO
Author URI: http://ceoblog.gq/
*/

// 启用插件自动跳转至设置
register_activation_hook(__FILE__, 'wpdaxue_plugin_activate');
add_action('admin_init', 'wpdaxue_plugin_redirect');
function wpdaxue_plugin_activate()
{
    add_option('my_plugin_do_activation_redirect', true);
}
function wpdaxue_plugin_redirect()
{
    if (get_option('my_plugin_do_activation_redirect', false)) {
        delete_option('my_plugin_do_activation_redirect');
        wp_redirect(admin_url('options-general.php?page=wordpress_plus'));
    }
}

// 添加插件控制面板
function register_plugin_settings_link($links)
{
    $settings_link = '<a href="options-general.php?page=wordpress_plus">设置</a>';
    array_unshift($links, $settings_link);
    return $links;
}
$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_{$plugin}", 'register_plugin_settings_link');


// 配置插件设置
if (is_admin()) {
    add_action('admin_menu', 'wordpress_plus_menu');
}

// 配置插件设置
function wordpress_plus_menu()
{
    add_options_page('WordPress Plus + 插件控制面板', 'WordPress Plus +', 'administrator', 'wordpress_plus', 'pluginoptions_page');
}

// 插件设置核心部分
function pluginoptions_page()
{
    if ($_POST['update_pluginoptions'] == 'true') {
        pluginoptions_update();
    }
?>
<div class="wrap">
<h2>WordPress Plus + 插件控制面板</h2>
<h3>欢迎使用WordPress Plus + 插件，请按需调整插件功能！</h3>
<div id="message" class="updated"><p>WordPress Plus + 1.3.1版本更新日志：</br>优化插件代码</div>
<form method="POST" action="">
<input type="hidden" name="update_pluginoptions" value="true" />
<input type="checkbox" name="msyh" id="msyh" <?php
    echo get_option('wpplus_msyh');
?> /> 启用“修改后台中文字体为微软雅黑”功能<p>
<input type="checkbox" name="googlefont" id="googlefont" <?php
    echo get_option('wpplus_googlefont');
?> /> 启用“Open-Sans加载源替换为360前端库CDN”功能<p>
<input type="checkbox" name="sslgravatar" id="sslgravatar" <?php
    echo get_option('wpplus_sslgravatar');
?> /> 启用“使用SSL方式调用Gravatar头像”功能<p>
<input type="submit" class="button-primary" value="保存设置" /> &nbsp; 修改后台字体为雅黑功能需要刷新后生效
<p>WordPress Plus + 版本 1.3.1 &nbsp; 插件作者为<a href="http://ceoblog.gq">CEO</a>
</form>
</div>
<?php
}
// 插件设置验证
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
}
?>
<?php
if (get_option('wpplus_msyh') == 'checked') {
?>
<?php
// 改变后台字体为微软雅黑
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
// 修改Open_sans加载源为360前端库CDN
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
// 使用SSL方式调用Gravatar头像
    function get_ssl_avatar($avatar)
    {
        $avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/', '<img src="https://secure.gravatar.com/avatar/$1?s=$2" class="avatar avatar-$2" height="$2" width="$2">', $avatar);
        return $avatar;
    }
    add_filter('get_avatar', 'get_ssl_avatar');
?>
<?php
}
?>