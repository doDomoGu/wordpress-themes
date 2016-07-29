<?php
/*
Template Name:单页面_空白
*/
?>

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
                <a href="/">首页</a>
                <a class="on"><?=$post->post_title?></a>
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
    <div id="main" class="container">
        <div id="post_content">
        <?=$post->post_content?>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<?php
    get_footer();
?>