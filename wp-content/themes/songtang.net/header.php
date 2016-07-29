<!DOCTYPE HTML>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width" />
    <meta name="renderer" content="webkit">
    <?php include('lib/seo.php'); ?>
    <!--<link rel="pingback" href="<?php /*bloginfo( 'pingback_url' ); */?>" />-->
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
    <script src="<?php bloginfo('template_url'); ?>/static/js/jquery.min.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/static/js/header.js"></script>
    <?php
        //各页面加载css/js
        include('lib/load_script.php');
    ?>
    <?php
    //加载css
    //gk_load_css();
    //wp_head();
    //加载js
    //gk_load_js();
    //if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
    ?>
    <!--<script type="text/javascript">
        $(window).load(function() {
            $('.flexslider').flexslider();
        });
    </script>-->
</head>
<body>
<header id="header">
    <div class="container">
        <div id="logo">
            <a href="/">
                <img src="<?php  bloginfo('template_url'); ?>/static/img/logo.png" />
            </a>
        </div>
        <div id="menu">
            <?php wp_nav_menu(
                array(
                    'theme_location' => 'header-menu',
                    'container_class' => 'menu-container',
                    'menu_id' => 'header-menu',
                    'menu_class' => '',
                    'link_before' => '<span>',
                    'link_after' => '</span><span class="bkg"></span>',
                    'depth' => 2
                )); ?>


            <?php /*wp_nav_menu(
                array(
                    'theme_location'  => '', //指定显示的导航名，如果没有设置，则显示第一个
    'menu'            => 'header-menu',
    'container'       => 'nav', //最外层容器标签名
    'container_class' => 'primary', //最外层容器class名
    'container_id'    => '',//最外层容器id值
    'menu_class'      => 'sf-menu', //ul标签class
    'menu_id'         => 'topnav',//ul标签id
    'echo'            => true,//是否打印，默认是true，如果想将导航的代码作为赋值使用，可设置为false
    'fallback_cb'     => 'wp_page_menu',//备用的导航菜单函数，用于没有在后台设置导航时调用
    'before'          => '',//显示在导航a标签之前
    'after'           => '',//显示在导航a标签之后
    'link_before'     => '',//显示在导航链接名之后
    'link_after'      => '',//显示在导航链接名之前
    'items_wrap'      => '<ul id="%1$s">%3$s</ul>',
    'depth'           => 0,////显示的菜单层数，默认0，0是显示所有层
    'walker'          => ''// //调用一个对象定义显示导航菜单
                )); */?>
            <!--<ul>
                <li><a href="/">菜单1</a></li>
                <li><a href="/">菜单222</a></li>
                <li><a href="/">菜单333</a></li>
            </ul>-->
        </div>
    </div>
    <div class="clearfix"></div>
</header>
