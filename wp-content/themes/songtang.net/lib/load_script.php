<?php
    //css
    $cssDir = '/static/css/';
    $cssFiles = [];
    if(is_home()){
        $cssFiles[] = 'home.css';
    }
    if(is_search()){
        //$cssFiles[] = 'search.css';
    }
    if(is_single()){
        $cssFiles[] = 'single.css';
    }
    if(is_page()){
        if('page_intro.php' == get_page_template_slug()){
            $cssFiles[] = 'page_intro.css';
        }elseif('page_blank.php' == get_page_template_slug()){
            $cssFiles[] = 'page_blank.css';
        }else{
            //$cssFiles[] = 'page.css';
        }
    }
    if(is_category()){
        $cssFiles[] = 'category.css';
    }
    if(is_month()){
        //$cssFiles[] = 'month.css';
    }
?>
<?php if(!empty($cssFiles)):?>
<?php foreach($cssFiles as $css):?>
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?><?=$cssDir.$css?>" type="text/css" media="screen" />
<?php endforeach;?>
<?php endif;?>

<?php
    //js
    $jsDir = '/static/js/';
    $jsFiles = [];
    if(is_home()){
        $jsFiles[] = 'home.js';
    }
    if(is_search()){
        //$jsFiles[] = 'search.js';
    }
    if(is_single()){
        //$jsFiles[] = 'single.js';
    }
    if(is_page()){
        if('page_intro.php' == get_page_template_slug()){
            $jsFiles[] = 'nav.js';
            //$jsFile = 'page_intro.js';
        }elseif('page_blank.php' == get_page_template_slug()){
            $jsFiles[] = 'nav.js';
        }else{
            //$jsFile = 'page.js';
        }
    }
    if(is_category()){
        //$jsFiles[] = 'category.js';
        $jsFiles[] = 'nav.js';
    }
    if(is_month()){
        //$jsFile = 'month.js';
    }

?>
<?php if(!empty($jsFiles)):?>
    <?php foreach($jsFiles as $js):?>
        <script src="<?php bloginfo('template_url'); ?><?=$jsDir.$js?>"></script>
    <?php endforeach;?>
<?php endif;?>

