<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// 从样式表获取主题名称
	$themename = wp_get_theme();

	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  请阅读:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	// 测试数据
	$test_array = array(
		'one' => __('1', 'options_framework_theme'),
		'two' => __('2', 'options_framework_theme'),
		'three' => __('3', 'options_framework_theme'),
		'four' => __('4', 'options_framework_theme'),
		'five' => __('5', 'options_framework_theme'),
		'six' => __('6', 'options_framework_theme'),
		'seven' => __('7', 'options_framework_theme')
	);

	// 复选框数组
	$multicheck_array = array(
		'one' => __('法国吐司', 'options_framework_theme'),
		'two' => __('薄煎饼', 'options_framework_theme'),
		'three' => __('煎蛋', 'options_framework_theme'),
		'four' => __('绉绸', 'options_framework_theme'),
		'five' => __('感化饼干', 'options_framework_theme')
	);

	// 复选框默认值
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// 背景默认值
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// 版式默认值
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );
		
	// 版式设置选项
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => '普通','bold' => '粗体' ),
		'color' => false
	);

	// 将所有分类（categories）加入数组
	$options_categories = [false=>'==请选择=='];
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// 将所有标签（tags）加入数组
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// 将所有页面（pages）加入数组
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// 如果使用图片单选按钮, define a directory path
	$imagepath =  OPTIONS_FRAMEWORK_DIRECTORY.'images/';

	$options = array();

    $options[] = [
        'name' => '首页设置',
        'type' => 'heading'
    ];

    $options[] = [
        'name' => '轮播banner 1',
        'desc' => '尺寸（1140~1920）*400 有效区域1140*400',
        'id' => 'index_banner_pics_1',
        'type' => 'upload'
    ];

    $options[] = [
        'name' => '轮播banner 1的链接地址',
        'desc' => '带http://开头的完整地址',
        'id' => 'index_banner_link_1',
        'type' => 'text'
    ];

    $options[] = [
        'name' => '轮播banner 2',
        'desc' => '尺寸（1140~1920）*400 有效区域1140*400',
        'id' => 'index_banner_pics_2',
        'type' => 'upload'
    ];

    $options[] = [
        'name' => '轮播banner 2的链接地址',
        'desc' => '带http://开头的完整地址',
        'id' => 'index_banner_link_2',
        'type' => 'text'
    ];

    $options[] = [
        'name' => '轮播banner 3',
        'desc' => '尺寸（1140~1920）*400 有效区域1140*400',
        'id' => 'index_banner_pics_3',
        'type' => 'upload'
    ];

    $options[] = [
        'name' => '轮播banner 3的链接地址',
        'desc' => '带http://开头的完整地址',
        'id' => 'index_banner_link_3',
        'type' => 'text'
    ];

    if ( $options_categories ) {
        $options[] = [
            'name' => '首页新闻分类选择',
            'desc' => '选择所需要显示的分类,显示最新5条，不选择则从全部文章中选择',
            'id' => 'index_news_cate_id',
            'type' => 'select',
            'options' => $options_categories
        ];
    }

    $options[] = [
        'name' => '页面（集团简介）',
        'type' => 'heading'
    ];

    $options[] = [
        'name' => '侧边栏 1',
        'desc' => '',
        'id' => 'page_intro_pics_1',
        'type' => 'upload'
    ];

    $options[] = [
        'name' => '侧边栏 1的链接地址',
        'desc' => '带http://开头的完整地址',
        'id' => 'page_intro_link_1',
        'type' => 'text'
    ];

    $options[] = [
        'name' => '侧边栏 2',
        'desc' => '',
        'id' => 'page_intro_pics_2',
        'type' => 'upload'
    ];

    $options[] = [
        'name' => '侧边栏 2的链接地址',
        'desc' => '带http://开头的完整地址',
        'id' => 'page_intro_link_2',
        'type' => 'text'
    ];

    $options[] = [
        'name' => '侧边栏 3',
        'desc' => '',
        'id' => 'page_intro_pics_3',
        'type' => 'upload'
    ];

    $options[] = [
        'name' => '侧边栏 3的链接地址',
        'desc' => '带http://开头的完整地址',
        'id' => 'page_intro_link_3',
        'type' => 'text'
    ];

	/*$options[] = array(
		'name' => __('基本设置', 'options_framework_theme'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('窄文本框', 'options_framework_theme'),
		'desc' => __('窄文本框输入字段。', 'options_framework_theme'),
		'id' => 'example_text_mini',
		'std' => '默认',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('文本框', 'options_framework_theme'),
		'desc' => __('文本框输入字段。', 'options_framework_theme'),
		'id' => 'example_text',
		'std' => '默认值',
		'type' => 'text');

	$options[] = array(
		'name' => __('文本域', 'options_framework_theme'),
		'desc' => __('文本域说明', 'options_framework_theme'),
		'id' => 'example_textarea',
		'std' => '默认文本',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('窄下拉列表', 'options_framework_theme'),
		'desc' => __('一个窄下拉列表', 'options_framework_theme'),
		'id' => 'example_select',
		'std' => 'three',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $test_array);

	$options[] = array(
		'name' => __('宽下拉列表', 'options_framework_theme'),
		'desc' => __('一个宽下拉列表', 'options_framework_theme'),
		'id' => 'example_select_wide',
		'std' => 'two',
		'type' => 'select',
		'options' => $test_array);

	if ( $options_categories ) {
	$options[] = array(
		'name' => __('选择分类', 'options_framework_theme'),
		'desc' => __('通过cat_ID和cat_name选择categories数组', 'options_framework_theme'),
		'id' => 'example_select_categories',
		'type' => 'select',
		'options' => $options_categories);
	}
	
	if ( $options_tags ) {
	$options[] = array(
		'name' => __('选择标签', 'options_check'),
		'desc' => __('通过trem_id和term_name选择tags数组', 'options_check'),
		'id' => 'example_select_tags',
		'type' => 'select',
		'options' => $options_tags);
	}

	$options[] = array(
		'name' => __('选择页面', 'options_framework_theme'),
		'desc' => __('通过ID和post_title选择pages', 'options_framework_theme'),
		'id' => 'example_select_pages',
		'type' => 'select',
		'options' => $options_pages);

	$options[] = array(
		'name' => __('单选框（one）', 'options_framework_theme'),
		'desc' => __('单选按钮选中时值为“one”', 'options_framework_theme'),
		'id' => 'example_radio',
		'std' => 'one',
		'type' => 'radio',
		'options' => $test_array);

	$options[] = array(
		'name' => __('示例信息', 'options_framework_theme'),
		'desc' => __('这是一条示例信息，你可以在设置面板中加入它', 'options_framework_theme'),
		'type' => 'info');

	$options[] = array(
		'name' => __('复选框', 'options_framework_theme'),
		'desc' => __('复选框示例，默认为true', 'options_framework_theme'),
		'id' => 'example_checkbox',
		'std' => '1',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('高级设置', 'options_framework_theme'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('单击显示隐藏的文本框', 'options_framework_theme'),
		'desc' => __('单击这里看发生了什么', 'options_framework_theme'),
		'id' => 'example_showhidden',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('隐藏文本框', 'options_framework_theme'),
		'desc' => __('这是一个隐藏的文本框，选中复选框后显示', 'options_framework_theme'),
		'id' => 'example_text_hidden',
		'std' => '你好',
		'class' => 'hidden',
		'type' => 'text');

	$options[] = array(
		'name' => __('上传测试', 'options_framework_theme'),
		'desc' => __('预览图像将以全尺寸上传。', 'options_framework_theme'),
		'id' => 'example_uploader',
		'type' => 'upload');

	$options[] = array(
		'name' => "图片单选按钮",
		'desc' => "",
		'id' => "example_images",
		'std' => "2c-l-fixed",
		'type' => "images",
		'options' => array(
			'1col-fixed' => $imagepath . '1col.png',
			'2c-l-fixed' => $imagepath . '2cl.png',
			'2c-r-fixed' => $imagepath . '2cr.png')
	);

	$options[] = array(
		'name' =>  __('背景示例', 'options_framework_theme'),
		'desc' => __('修改背景CSS', 'options_framework_theme'),
		'id' => 'example_background',
		'std' => $background_defaults,
		'type' => 'background' );

	$options[] = array(
		'name' => __('复选框', 'options_framework_theme'),
		'desc' => __('复选框说明', 'options_framework_theme'),
		'id' => 'example_multicheck',
		'std' => $multicheck_defaults, // These items get checked by default
		'type' => 'multicheck',
		'options' => $multicheck_array);

	$options[] = array(
		'name' => __('拾色器', 'options_framework_theme'),
		'desc' => __('默认未选择颜色', 'options_framework_theme'),
		'id' => 'example_colorpicker',
		'std' => '',
		'type' => 'color' );
		
	$options[] = array( 'name' => __('版式', 'options_framework_theme'),
		'desc' => __('版式示例', 'options_framework_theme'),
		'id' => "example_typography",
		'std' => $typography_defaults,
		'type' => 'typography' );
		
	$options[] = array(
		'name' => __('自定义版式', 'options_framework_theme'),
		'desc' => __('自定义版式设置', 'options_framework_theme'),
		'id' => "custom_typography",
		'std' => $typography_defaults,
		'type' => 'typography',
		'options' => $typography_options );

	$options[] = array(
		'name' => __('文本编辑器', 'options_framework_theme'),
		'type' => 'heading' );*/

	/**
	 * For $settings options see:
	 * http://codex.wordpress.org/Function_Reference/wp_editor
	 *
	 * 'media_buttons' are not supported as there is no post to attach items to
	 * 'textarea_name' is set by the 'id' you choose
	 */

	/*$wp_editor_settings = array(
		'wpautop' => true, // 默认
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);
	
	$options[] = array(
		'name' => __('默认文本编辑器', 'options_framework_theme'),
		'desc' => sprintf( __( '您可以设置编辑器，更多关于wp_editor的说明请阅读<a href="%1$s" target="_blank">the WordPress codex</a>', 'options_framework_theme' ), 'http://codex.wordpress.org/Function_Reference/wp_editor' ),
		'id' => 'example_editor',
		'type' => 'editor',
		'settings' => $wp_editor_settings );*/

	return $options;
}