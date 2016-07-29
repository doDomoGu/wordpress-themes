<?php
    get_header();
?>
<div id="content">
    <div id="banner">
        <div class="intro"></div>
    </div>
    <div id="nav" class="container">
        <div class="wrap">
            <div class="crumbs">
                <a href="<?php bloginfo('siteurl'); ?>/">首页</a>
                <?=get_category_parents_ex(get_query_var('cat')); ?>
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
            <div id="post_list" class="link-block clearfix">
            <?php if(have_posts()) :?>
                <?php while(have_posts()) : the_post(); ?>
                <a href="<?php the_permalink() ?>">
                    <div class="date-block">
                        <span class="day"><?php the_time('d') ?></span>
                        <?php the_time('M') ?><br>
                        <?php the_time('Y') ?>
                    </div>
                    <div class="summary">
                        <h1><?php the_title(); ?></h1>
                        <h3>发布者: <?php the_author (); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;浏览次数: <?=getPostViews($post->ID);?></h3>
                        <p><?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 420,"......"); ?></p>
                    </div>
                </a>
                <?php endwhile; ?>
                <ul class="pagination">
                    <?php /*gk_page($query_string);*/?>
                </ul>
            <?php else: ?>

            <?php endif; ?>
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