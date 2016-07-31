<?php
get_header();
setPostViews(get_the_ID());
?>
    <div id="content">
        <div id="banner">
            <div class="intro"></div>
        </div>
        <div id="nav" class="container">
            <div class="wrap">
                <div class="crumbs">
                    <a href="<?php bloginfo('siteurl'); ?>/">首页</a>
                    <?=get_category_parents_ex(); ?>
                    <a class="on">文章</a>
                </div>
                <div class="columns">
                    <?php
                    $current_menu_item_id = get_current_menu_item_id();
                    $menu_items_related = get_related_menu_items($current_menu_item_id);?>
                    <?php foreach($menu_items_related as $mir):?>
                        <a href="<?=$mir->url?>" <?=$mir->ID==$current_menu_item_id?'class="on"':''?>><?=$mir->post_title!=''?$mir->post_title:$mir->title?><span></span></a>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
        <div id="main" class="container clearfix">
            <div id="left">
                <div class="date-block">
                    <span class="day"><?php the_time('d') ?></span>
                    <?php the_time('M') ?><br>
                    <?php the_time('Y') ?>
                </div>
                <div id="post">
                    <h1><?php the_title(); ?></h1>
                    <h3>发布者: <?php the_author_meta('display_name',$post->post_author);?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;浏览次数: <?=getPostViews(get_the_ID());?></h3>
                    <div id="post_content">
                        <?=$post->post_content?>
                    </div>
                </div>
            </div>
            <div id="right">
                <?php include('sider_right.php');?>
            </div>
        </div>
    </div>

<?php
get_footer();
?>