<?php
/*
Template Name:单页面_集团介绍
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
        <div id="left">
            <div id="post_content">
            <?=$post->post_content?>
            </div>
        </div>
        <div id="right">
            <?php include('sider_right.php');?>
        </div>
    </div>
</div>
<div class="clearfix"></div>


<div class="container">
    <?php
/*    var_dump($post);echo "<br/><br/>";

    var_dump($menu_items_related);echo "<br/><br/>";


    $menu_items = get_menu_items();
    foreach($menu_items as $si){
        echo $si->ID.' ';
        echo $si->title.' ';
        echo $si->post_title.' ';
        echo $si->url.' ';
        echo $si->type.' ';
        echo $si->post_type.' ';
        echo $si->object_id.' ';
        echo $si->post_parent.' ';
        echo $si->menu_item_parent;
        echo '<br/><br/>';
    }

    exit;

    foreach($menu_items as $si){
        var_dump($si);echo '<br/><br/>';
    }
    echo '<br/><Br/>';
    var_dump(songtang_wp_nav_menu_objects( 7 ));
    echo '<br/><BR/>';


    echo "<br/><br/>";
    $menus = get_terms('nav_menu');
    foreach( $menus as $menu ){
        echo '<pre>'; var_export($menu); echo '</pre>';
    }
    exit;

    var_dump($nav_menu);
    echo "<br/>";
    echo "<br/>";
    $s = get_menu_x();
    var_dump($s);exit;

    var_dump($post->ID);exit;


    echo '<br/><br/>';
    $ite = wp_page_menu();
    echo '<br/><br/>';
    var_dump($ite);exit;

    $list = wp_get_nav_menus();
    foreach($list as $l){

        var_dump($sl);
        echo '<Br/>';
        echo '<Br/>';
        $items = wp_get_nav_menu_items($l);
        foreach($items as $it){
            var_dump($it);
            echo '<br/>';
            echo '<br/>';
        }
        echo '<br/><br/>';
        echo '<br/><br/>';
    }
    */?>
    <?php /*$s = get_nav_menu_locations();var_dump($s);*/?>
</div>
<?php
    get_footer();
?>