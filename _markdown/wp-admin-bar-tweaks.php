

//Disable the WordPress Admin Bar for all Users and Visitors
//Turn off the toolbar with one simple line.
//
//view plain
/* 
 * Disable the WordPress Admin Bar for all Users and Visitors 
 */  
//remove_action( 'init', '_wp_admin_bar_init' );
//^ top
//Enable the WordPress Admin Bar for admins only
//If the user can not manage options, then do not show them the admin bar.
//
//view plain
/* 
 * Enable the WordPress Admin Bar for admins only 
 */  
if ( !current_user_can( 'manage_options' ) ) {  
    remove_action( 'init', '_wp_admin_bar_init' );  
}  
^ top
Display the WordPress Admin Bar in the Admin Area only
Turns off the Admin Bar when viewing the Website.

view plain
/* 
 * Display the WordPress Admin Bar in the Admin Area only 
 */  
if ( is_admin() ) {  
    remove_action( 'init', '_wp_admin_bar_init' );  
}  
^ top
Display the WordPress Admin bar on Websites only
Turns off the Admin Bar when viewing the Admin Area.

view plain
/* 
 * Display the WordPress Admin bar on Websites only 
 */  
if ( !is_admin() ) {  
    remove_action( 'init', '_wp_admin_bar_init' );  
}  
^ top
Disable The Admin Bar within the Network Admin only
Remove the Admin Bar when viewing the Network Admin.

This Snip MUST be placed within the must use /mu-plugins/ plugins directory.

view plain
/* 
 * Disable The Admin Bar within the Network Admin only 
 */  
if ( is_network_admin() ) {  
    remove_action( 'init', '_wp_admin_bar_init' );  
}  
^ top
Removes the 28px margin for the Admin Bar
A disabled Admin Bar leave a 28px space at the top of the page, the snip below removes the extra space. The example removes the space for both the Admin Area and Websites.

view plain
/* 
 * Removes the 28px margin for the Admin Bar 
 */  
function remove_adminbar_margin() {  
    $remove_adminbar_margin = '<style type="text/css">  
        html { margin-top: -28px !important; }  
        * html body { margin-top: -28px !important; }  
    </style>';  
    echo $remove_adminbar_margin;  
}  
/* wp-admin area */  
if ( is_admin() ) {  
    remove_action( 'init', '_wp_admin_bar_init' );  
    add_action( 'admin_head', 'remove_adminbar_margin' );  
}  
/* websites */  
if ( !is_admin() ) {  
    remove_action( 'init', '_wp_admin_bar_init' );  
    add_action( 'wp_head', 'remove_adminbar_margin' );  
}  
^ top
Remove the WordPress Logo from the WordPress Admin Bar
This is the WP Logo displayed directly on the Admin Bar.

view plain
/* 
 * Remove the WordPress Logo from the WordPress Admin Bar 
 */  
function remove_wp_logo() {  
    global $wp_admin_bar;  
    $wp_admin_bar->remove_menu('wp-logo');  
}  
add_action( 'wp_before_admin_bar_render', 'remove_wp_logo' );  
^ top
Remove the Howdy menu from the WordPress Admin Bar
Disables the Howdy, Handle/Username menu on the main Admin Bar.

view plain
/* 
 * Remove the Howdy menu from the WordPress Admin Bar 
 */  
function remove_my_account() {  
    global $wp_admin_bar;  
    $wp_admin_bar->remove_menu('my-account');  
}  
add_action( 'wp_before_admin_bar_render', 'remove_my_account' );  
^ top
Remove the Comment Bubble from the WordPress Admin Bar
Removes those pesky Comment Notices.

view plain
/* 
 * Remove the Comment Bubble from the WordPress Admin Bar 
 */  
function remove_comment_bubble() {  
    global $wp_admin_bar;  
    $wp_admin_bar->remove_menu('comments');  
}  
add_action( 'wp_before_admin_bar_render', 'remove_comment_bubble' );  
^ top
Disable the My Sites menu in the Admin Bar
Removes the default My Sites menu from the main Admin Bar display.

view plain
/* 
 * Disable the My Sites menu in the Admin Bar 
 */  
function remove_my_sites() {  
    global $wp_admin_bar;  
    $wp_admin_bar->remove_menu('my-sites');  
}  
add_action( 'wp_before_admin_bar_render', 'remove_my_sites' );  
^ top
Disable the current Site Name menu in the Admin Bar
Removes the ‘this Site menu’ from the main Admin Bar display.

This is the menu shows the current site, with a dropdown to visit the Website.

view plain
/* 
 * Disable the current Site Name menu in the Admin Bar 
 */  
function remove_this_site() {  
    global $wp_admin_bar;  
    $wp_admin_bar->remove_menu('site-name');  
}  
add_action( 'wp_before_admin_bar_render', 'remove_this_site' );  
^ top
Disable the Add New Content menu
Removes the + New menu from the main Admin Bar.

view plain
/* 
 * Disable the Add New Content menu 
 */  
function disable_new_content() {  
    global $wp_admin_bar;  
    $wp_admin_bar->remove_menu('new-content');  
}  
add_action( 'wp_before_admin_bar_render', 'disable_new_content' );  
^ top
Disable the Search Icon and Input within the Admin Bar
Completely removes the Search Feature from the Admin Bar. Located to the far right within the toolbar, on the Website itself.

view plain
/* 
 * Disable the Search Icon and Input within the Admin Bar 
 */  
function disable_bar_search() {  
    global $wp_admin_bar;  
    $wp_admin_bar->remove_menu('search');  
}  
add_action( 'wp_before_admin_bar_render', 'disable_bar_search' );  
^ top
Disable the Update Menus
Removes those pesky Update Notices.

view plain
/* 
 * Disable the Update Menus 
 */  
function disable_bar_updates() {  
    global $wp_admin_bar;  
    $wp_admin_bar->remove_menu('updates');  
}  
add_action( 'wp_before_admin_bar_render', 'disable_bar_updates' );  
^ top
Add a simple menu and link that opens in a new window
Add a quick menu and link to the admin bar.

view plain
/* 
 * Add a simple menu & link that opens in a new window 
 * Change the Menu 'title' name and 'href' link. 
 */  
function custom_adminbar_menu( $meta = TRUE ) {  
    global $wp_admin_bar;  
        if ( !is_user_logged_in() ) { return; }  
        if ( !is_super_admin() || !is_admin_bar_showing() ) { return; }  
    $wp_admin_bar->add_menu( array(  
        'id' => 'custom_menu',  
        'title' => __( 'Menu Name' ),  
        'href' => 'http://google.com/',  
        'meta'  => array( target => '_blank' ) )  
    );  
}  
add_action( 'admin_bar_menu', 'custom_adminbar_menu', 15 );  
/* The add_action # is the menu position: 
10 = Before the WP Logo 
15 = Between the logo and My Sites 
25 = After the My Sites menu 
100 = End of menu 
*/  
^ top
Add a Menu to the Theme Editor for Multisite and Standalone WordPress
Adds a custom menu option that opens the Theme Editor directly.

view plain
/* 
 * Add a Menu to the Theme Editor for Multisite and Standalone WordPress 
 */  
function add_theme_menu() {  
    global $wp_admin_bar;  
        if ( !is_user_logged_in() ) { return; }  
        if ( !is_super_admin() || !is_admin_bar_showing() ) { return; }  
    if ( function_exists('is_multisite') && is_multisite() ) {  
        $wp_admin_bar->add_menu( array(  
            'id' => 'theme-editor',  
            'title' => __('Edit Theme'),  
            'href' => network_admin_url( 'theme-editor.php' ) )  
        );  
    }else{  
        $wp_admin_bar->add_menu( array(  
            'id' => 'theme-editor',  
            'title' => __('Edit Theme'),  
            'href' => admin_url( 'theme-editor.php' ) )  
        );  
    }  
}  
add_action( 'admin_bar_menu', 'add_theme_menu', 100 );  
^ top
Add a menu, with a dropdown to link that opens in a new window
Adds a custom menu option that opens links in a new window or tab.

view plain
/* 
 * Add a menu, with a dropdown to link that opens in a new window 
 * Change the Menu title, the link title and and href link. 
 */  
function custom_adminbar_menu( $meta = TRUE ) {  
    global $wp_admin_bar;  
        if ( !is_user_logged_in() ) { return; }  
        if ( !is_super_admin() || !is_admin_bar_showing() ) { return; }  
    $wp_admin_bar->add_menu( array(  
        'id' => 'custom_menu',  
        'title' => __( 'Menu Name' ) )       /* set the menu name */  
    );  
    $wp_admin_bar->add_menu( array(  
        'parent' => 'custom_menu',  
        'id'     => 'custom_links',  
        'title' => __( 'Google'),            /* Set the link title */  
        'href' => 'http://google.com/',      /* Set the link a href */  
        'meta'  => array( target => '_blank' ) )  
    );  
}  
add_action( 'admin_bar_menu', 'custom_adminbar_menu', 15 );  
^ top
Add a menu, with sub-menu, that contains multiple links, that all open in a new window
Works much like the My Sites menu but with custom links.

view plain
/* 
 * Add a menu, with sub-menu, that contains multiple links, that all open in a new window 
 * Change the Menu 'title' name and 'href' link. 
 */  
function custom_adminbar_menu( $meta = TRUE ) {  
    global $wp_admin_bar;  
        if ( !is_user_logged_in() ) { return; }  
        if ( !is_super_admin() || !is_admin_bar_showing() ) { return; }  
    $wp_admin_bar->add_menu( array(  
        'id' => 'custom_menu',  
        'title' => __( 'Menu Name' ) )           /* set the menu name */  
    );  
    /* sub-menu */  
    $wp_admin_bar->add_menu( array(  
        'parent' => 'custom_menu',  
        'id'     => 'custom_links',  
        'title' => __( 'Sub menu') )         /* set the sub-menu name */  
    );  
            /* menu links */  
            $wp_admin_bar->add_menu( array(  
                'parent'    => 'custom_links',  
                'title'     => 'Google',             /* Set the link title */  
                'href'  => 'http://google.com/', /* Set the link a href */  
                'meta'  => array( target => '_blank' ) )  
            );  
            $wp_admin_bar->add_menu( array(  
                'parent'    => 'custom_links',  
                'title'     => 'Yahoo',          /* Set the link title */  
                'href'  => 'http://yahoo.com/',  /* Set the link a href */  
                'meta'  => array( target => '_blank' ) )  
            );  
}  
add_action( 'admin_bar_menu', 'custom_adminbar_menu', 15 );  
^ top
Make Visit Site links open in a new window
This is the “Visit Site” link found under: My Sites Menu > Site Name > Visit Site

view plain
/* 
 * Make Visit Site links open in a new window: My Sites > Site Name > Visit Site 
 */  
function my_site_links() {
    global $wp_admin_bar;  
    foreach ( (array) $wp_admin_bar->user->blogs as $blog ) {  
        $menu_id  = 'blog-' . $blog->userblog_id;  
        $wp_admin_bar->add_menu( array(  
            'parent'    => $menu_id,  
            'id'    => $menu_id . '-v',  
            'title'     => __( 'Visit Site' ),  
            'href'  => get_home_url( $blog->userblog_id, '/' ),  
            'meta'  => array( target => '_blank' ) )  
        );  
    }  
}  
add_action( 'wp_before_admin_bar_render', 'my_site_links' );  
^ top
Remove My Sites Sub-Menu Options: Dashboard, New Post, Manage Comments and Visit Site
Customizes the My Sites menu.

view plain
/* 
 * Remove My Sites Sub-Menu Options: Dashboard, New Post, Manage Comments and Visit Site 
 */  
function remove_mysites_links () {  
    global $wp_admin_bar;  
    foreach ( (array) $wp_admin_bar->user->blogs as $blog ) {  
        $menu_id_d  = 'blog-' . $blog->userblog_id . '-d';       /* Dashboard var */  
        $menu_id_n  = 'blog-' . $blog->userblog_id . '-n';       /* New Post var */  
        $menu_id_c  = 'blog-' . $blog->userblog_id . '-c';       /* Manage Comments var */  
        $menu_id_v  = 'blog-' . $blog->userblog_id . '-v';       /* Visit Site var */  
        $wp_admin_bar->remove_menu($menu_id_d);              /* Remove Dashboard Link */  
        $wp_admin_bar->remove_menu($menu_id_n);              /* Remove New Post Link */  
        $wp_admin_bar->remove_menu($menu_id_c);              /* Remove Manage Comments Link */  
        $wp_admin_bar->remove_menu($menu_id_v);              /* Remove Visit Site Link */  
    }  
}  
add_action( 'wp_before_admin_bar_render', 'remove_mysites_links' );  
^ top
Add Links to My Sites Sub-Menus: Log Out, Media, Links, Pages, Appearance, Plugins, Users, Tools and Settings
This example expands the My Sites menu.

view plain
/* 
 * Add Links to My Sites Sub-Menus: Log Out, Media, Links, Pages, Appearance, Plugins, Users, Tools and Settings 
 */  
function add_mysites_link () {  
    global $wp_admin_bar;  
    foreach ( (array) $wp_admin_bar->user->blogs as $blog ) {  
        $menu_id  = 'blog-' . $blog->userblog_id;  
        /* Add a Log Out Link */  
        $wp_admin_bar->add_menu( array(  
            'parent'    => $menu_id,  
            'id'    => $menu_id . '-logout',  
            'title'     => __( 'Log Out' ),  
            'href'  => get_home_url( $blog->userblog_id, '/wp-login.php?action=logout' ) )  
        );  
        /* Media Admin */  
        $wp_admin_bar->add_menu( array(  
            'parent'    => $menu_id,  
            'id'    => $menu_id . '-media',  
            'title'     => __( 'Media Admin' ),  
            'href'  => get_home_url( $blog->userblog_id, '/wp-admin/upload.php' ) )  
        );  
        /* Links Admin */  
        $wp_admin_bar->add_menu( array(  
            'parent'    => $menu_id,  
            'id'    => $menu_id . '-links',  
            'title'     => __( 'Links Admin' ),  
            'href'  => get_home_url( $blog->userblog_id, '/wp-admin/link-manager.php' ) )  
        );  
        /* Pages Admin */  
        $wp_admin_bar->add_menu( array(  
            'parent'    => $menu_id,  
            'id'    => $menu_id . '-pags',  
            'title'     => __( 'Pages Admin' ),  
            'href'  => get_home_url( $blog->userblog_id, '/wp-admin/edit.php?post_type=page' ) )  
        );  
        /* Appearance Admin */  
        $wp_admin_bar->add_menu( array(  
            'parent'    => $menu_id,  
            'id'    => $menu_id . '-appearance',  
            'title'     => __( 'Appearance' ),  
            'href'  => get_home_url( $blog->userblog_id, '/wp-admin/themes.php' ) )  
        );  
        /* Plugin Admin */  
        $wp_admin_bar->add_menu( array(  
            'parent'    => $menu_id,  
            'id'    => $menu_id . '-plugins',  
            'title'     => __( 'Plugin Admin' ),  
            'href'  => get_home_url( $blog->userblog_id, '/wp-admin/plugins.php' ) )  
        );  
        /* Users Admin */  
        $wp_admin_bar->add_menu( array(  
            'parent'    => $menu_id,  
            'id'    => $menu_id . '-users',  
            'title'     => __( 'Users Admin' ),  
            'href'  => get_home_url( $blog->userblog_id, '/wp-admin/users.php' ) )  
        );  
        /* Tools Admin */  
        $wp_admin_bar->add_menu( array(  
            'parent'    => $menu_id,  
            'id'    => $menu_id . '-tools',  
            'title'     => __( 'Tools Admin' ),  
            'href'  => get_home_url( $blog->userblog_id, '/wp-admin/tools.php' ) )  
        );  
        /* Settings Admin */  
        $wp_admin_bar->add_menu( array(  
            'parent'    => $menu_id,  
            'id'    => $menu_id . '-settings',  
            'title'     => __( 'Settings Admin' ),  
            'href'  => get_home_url( $blog->userblog_id, '/wp-admin/options-general.php' ) )  
        );  
    }  
}  
add_action( 'wp_before_admin_bar_render', 'add_mysites_link' );  
^ top
Change My Sites “Site Names” to “Domain.com” as the displayed name
Transforms: techNerdia – Description to technerdia.com.

view plain
/* 
 * Change My Sites Menu Names to Domain.com as the menu name 
 */  
function change_site_names() {  
    global $wp_admin_bar;  
        $blue_wp_logo_url = includes_url('images/wpmini-blue.png');  
        $blavatar = '<img src="' . esc_url($blue_wp_logo_url) . '" alt="' . esc_attr__( 'Blavatar' ) . '" width="16" height="16" class="blavatar"/>';  
    foreach ( (array) $wp_admin_bar->user->blogs as $blog ) {  
            $menu_id  = 'blog-' . $blog->userblog_id;  
            $blogname = ucfirst( $blog->domain );  
        $wp_admin_bar->add_menu( array(  
            'parent'    => 'my-sites-list',  
            'id'    => $menu_id,  
            'title'     => $blavatar . $blogname,  
            'href'  => get_admin_url( $blog->userblog_id ) )  
        );  
    }  
}  
add_action( 'wp_before_admin_bar_render', 'change_site_names' );  
^ top
Remove the WP Logo from the My Sites Menu
Disables the WordPress Logo.

NOTE: On line 08 or 09 – The $blogname = empty() part, the snip may add an extra empty line, like: emptyempty(). If so delete the extra empty to remove the error.

view plain
/* 
 * Remove the WP Logo from the My Sites Menu 
 */  
function remove_wplogo_mysites() {  
    global $wp_admin_bar;  
    foreach ( (array) $wp_admin_bar->user->blogs as $blog ) {  
        $menu_id  = 'blog-' . $blog->userblog_id;  
        $blogname = emptyempty( $blog->blogname ) ? $blog->domain : $blog->blogname;  
        $wp_admin_bar->add_menu( array(  
            'parent'    => 'my-sites-list',  
            'id'    => $menu_id,  
            'title'     => $blogname,  
            'href'  => get_admin_url( $blog->userblog_id ) )  
        );  
    }  
}  
add_action( 'wp_before_admin_bar_render', 'remove_wplogo_mysites' );  
^ top
Change the WP Logo Icon within the My Sites Menu to any icon you want
Create your own icon, upload it to the active themes /images/ directory, then change the NEW-ICON-HERE.png to the proper name.

view plain
/* 
 * Change the WP Logo Icon within the My Sites Menu to any icon you want 
 * Update the NEW-ICON-HERE.png name to match the proper file name. 
 */  
function add_mysites_logo() {  
    global $wp_admin_bar;  
    foreach ( (array) $wp_admin_bar->user->blogs as $blog ) {  
        $menu_id  = 'blog-' . $blog->userblog_id;  
        $blogname = emptyempty( $blog->blogname ) ? $blog->domain : $blog->blogname;  
        $blavatar = '<img src="' . get_bloginfo('template_directory') . '/images/NEW-ICON-HERE.png" alt="' . esc_attr__( 'Blavatar' ) . '" width="16" height="16" class="blavatar"/>';  
        $wp_admin_bar->add_menu( array(  
            'parent'    => 'my-sites-list',  
            'id'    => $menu_id,  
            'title'     => $blavatar . $blogname,  
            'href'  => get_admin_url( $blog->userblog_id ) )  
        );  
    }  
}  
add_action( 'wp_before_admin_bar_render', 'add_mysites_logo' );  
^ top
Force the WordPress Admin Bar to display for all visitors
Even Logged Out Users can use the Admin Bar.

view plain
/* 
 * Force the WordPress Admin Bar to display for all visitors 
 */  
add_filter( 'show_admin_bar', '__return_true' );  
^ top
Create a Menu for Logged Out Users
Activates the Admin Bar for users not Logged in.

view plain
/* 
 * Create a menu for Logged Out Users 
 */  
function loggedout_menu( $meta = TRUE ) {  
    global $wp_admin_bar;  
        if ( is_user_logged_in() ) { return false; }  
    $wp_admin_bar->add_menu( array(  
        'id' => 'custom_menu',  
        'title' => __( 'Menu Name' ),  
        'href' => 'http://google.com/',  
        'meta'  => array( target => '_blank' ) )  
    );  
}  
add_action( 'admin_bar_menu', 'loggedout_menu', 15 );  
^ top
Add a Log In Link for Logged Out Users to the Admin Bar
Allows for quick Access to the Login Page.

view plain
/* 
 * Add a Log In Link for Logged Out Users to the Admin Bar 
 */  
function add_login_link( $meta = FALSE ) {  
    global $wp_admin_bar, $blog_id;  
    if ( is_user_logged_in() ) { return false; }  
    $wp_admin_bar->add_menu( array(  
        'id' => 'custom_menu',  
        'title' => __( 'Login' ),  
        'href' => get_home_url( $blog_id, '/wp-login.php' ) )  
    );  
}  
add_filter( 'show_admin_bar', '__return_true' ); /* turn on adminbar for logged out users */  
add_action( 'admin_bar_menu', 'add_login_link', 15 );  
^ top
Change the Opacity of WordPress Admin Bar
Customize the look of the Admin Bar.

view plain
/* 
 * Change the opacity of WordPress Admin Bar 
 */  
function adminbar_opacity() {  
    $adminbar_opacity = '<style type="text/css">#wpadminbar { filter:alpha(opacity=50); opacity:0.5; }</style>';  
    echo $adminbar_opacity;  
}  
/* wp-admin area */  
if ( is_admin() ) {  
    add_action( 'admin_head', 'adminbar_opacity' );  
}  
/* websites */  
if ( !is_admin() ) {  
    add_action( 'wp_head', 'adminbar_opacity' );  
}  
^ top
Hide the WordPress Admin Bar with CSS, then display the Admin Bar on hover with CSS and jQuery
Customize the look of the Admin Bar.

view plain
/* 
 * Hide the WordPress Admin Bar with CSS, then display the Admin Bar on hover with CSS and jQuery 
 */  
function hide_adminbar() {  
    $hide_adminbar = '<script type="text/javascript">  
        $(document).ready( function() {  
            $("#wpadminbar").fadeTo( "slow", 0 );  
            $("#wpadminbar").hover(function() {  
                $("#wpadminbar").fadeTo( "slow", 1 );  
            }, function() {  
                $("#wpadminbar").fadeTo( "slow", 0 );  
            });  
        });  
    </script>  
    <style type="text/css">  
        html { margin-top: -28px !important; }  
        * html body { margin-top: -28px !important; }  
        #wpadminbar {  
            -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";  
            filter: alpha(opacity=0);  
            -moz-opacity:0;  
            -khtml-opacity:0;  
            opacity:0;  
        }  
        #wpadminbar:hover, #wpadminbar:focus {  
            -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";  
            filter: alpha(opacity=100);  
            -moz-opacity:1;  
            -khtml-opacity:1;  
            opacity:1;  
        }  
    </style>';  
    echo $hide_adminbar;  
}  
/* wp-admin area */  
if ( is_admin() ) {  
    add_action( 'admin_head', 'hide_adminbar' );  
}  
/* websites */  
if ( !is_admin() ) {  
    add_action( 'wp_head', 'hide_adminbar' );  
}  
^ top
Change the Admin Bar Color Scheme
The colors below create a Blue Admin Bar. Modify the #color values to customize the look.

view plain
/* 
 * Change the Admin Bar Color Scheme 
 */  
function change_adminbar_colors() {  
    $change_adminbar_colors = '<style type="text/css">  
        #wpadminbar *, #wpadminbar{ color:#ffffff;text-shadow:#444444 0 -1px 0; }  
        #wpadminbar{  
            background-color:#003399;  
            background-image:-ms-linear-gradient(bottom,#000033,#003399 5px);  
            background-image:-moz-linear-gradient(bottom,#000033,#003399 5px);  
            background-image:-o-linear-gradient(bottom,#000033,#003399 5px);  
            background-image:-webkit-gradient(linear,left bottom,left top,from(#000033),to(#003399));  
            background-image:-webkit-linear-gradient(bottom,#000033,#003399 5px);  
            background-image:linear-gradient(bottom,#000033,#003399 5px);  
        }  
        /* menu separators */  
        #wpadminbar .quicklinks>ul>li{border-right:1px solid #003399;}  
        #wpadminbar .quicklinks>ul>li>a,#wpadminbar .quicklinks>ul>li>.ab-emptyempty-item{border-right:1px solid #000033;}  
        #wpadminbar .quicklinks .ab-top-secondary>li{border-left:1px solid #000033;}  
        #wpadminbar .quicklinks .ab-top-secondary>li>a,#wpadminbar .quicklinks .ab-top-secondary>li>.ab-emptyempty-item{border-left:1px solid #003399;}  
        /* menu hover color and hover link color */  
        #wpadminbar.nojs .ab-top-menu>li.menupop:hover>.ab-item,#wpadminbar .ab-top-menu>li.menupop.hover>.ab-item{background:#333333;color:#ffffff;}  
        #wpadminbar .hover .ab-label,#wpadminbar.nojq .ab-item:focus .ab-label{color:#ffffff;}  
        #wpadminbar .menupop.hover .ab-label{color:#ffffff;}  
        /* menu, on mouse over hover colors */  
        #wpadminbar .ab-top-menu>li:hover>.ab-item,#wpadminbar .ab-top-menu>li.hover>.ab-item,#wpadminbar .ab-top-menu>li>.ab-item:focus,#wpadminbar.nojq .quicklinks .ab-top-menu>li>.ab-item:focus{  
            color:#fafafa;  
            background-color:#000033;  
            background-image:-ms-linear-gradient(bottom,#003399,#000033);  
            background-image:-moz-linear-gradient(bottom,#003399,#000033);  
            background-image:-o-linear-gradient(bottom,#003399,#000033);  
            background-image:-webkit-gradient(linear,left bottom,left top,from(#003399),to(#003399));  
            background-image:-webkit-linear-gradient(bottom,#003399,#000033);  
            background-image:linear-gradient(bottom,#003399,#000033);  
        }  
        /* menu item links hover color */  
        #wpadminbar .menupop li:hover,#wpadminbar .menupop li.hover,#wpadminbar .quicklinks .menupop .ab-item:focus,#wpadminbar .quicklinks .ab-top-menu .menupop .ab-item:focus{background-color:#ccffcc;}  
        /* menu item non-link colors */  
        #wpadminbar .ab-submenu .ab-item{color:#333333;}  
        /* menu item link colors */  
        #wpadminbar .quicklinks .menupop ul li a,#wpadminbar .quicklinks .menupop ul li a strong,#wpadminbar .quicklinks .menupop.hover ul li a,#wpadminbar.nojs .quicklinks .menupop:hover ul li a{color:#0099cc;}  
        /* my sites hover color */  
        #wpadminbar .quicklinks .menupop .ab-sub-secondary>li:hover,#wpadminbar .quicklinks .menupop .ab-sub-secondary>li.hover,#wpadminbar .quicklinks .menupop .ab-sub-secondary>li .ab-item:focus{background-color:#dfdfdf;}  
        /* update menu colors */  
        #wpadminbar .quicklinks a span#ab-updates{background:#eeeeee;color:#333333;}  
        #wpadminbar .quicklinks a:hover span#ab-updates{background:#ffffff;color:#000000;}  
        /* howdy menu */  
        #wpadminbar .ab-top-secondary{  
            background-color:#003399;  
            background-image:-ms-linear-gradient(bottom,#000033,#003399 5px);  
            background-image:-moz-linear-gradient(bottom,#000033,#003399 5px);  
            background-image:-o-linear-gradient(bottom,#000033,#003399 5px);  
            background-image:-webkit-gradient(linear,left bottom,left top,from(#000033),to(#003399));  
            background-image:-webkit-linear-gradient(bottom,#000033,#003399 5px);  
            background-image:linear-gradient(bottom,#000033,#003399 5px);  
        }  
        /* Howdy menu, username text color in dropdown */  
        #wpadminbar #wp-admin-bar-user-info .display-name{color:#333333;}  
        #wpadminbar #wp-admin-bar-user-info .username{color:#999999;}  
        /* search */  
        #wpadminbar #adminbarsearch .adminbar-input{color:#ccc;text-shadow:#444 0 -1px 0;background-color:rgba(255,255,255,0);}  
        #wpadminbar #adminbarsearch .adminbar-input:focus{color:#555;text-shadow:0 1px 0 #fff;background-color:rgba(255,255,255,0.9);}  
        #wpadminbar.ie8 #adminbarsearch .adminbar-input{background-color:#003399;}  
        #wpadminbar.ie8 #adminbarsearch .adminbar-input:focus{background-color:#fff;}  
        #wpadminbar #adminbarsearch .adminbar-input::-webkit-input-placeholder{color:#ddd;}  
        #wpadminbar #adminbarsearch .adminbar-input:-moz-placeholder{color:#ddd;}  
    </style>';  
    echo $change_adminbar_colors;  
}  
/* wp-admin area */  
if ( is_admin() ) {  
    add_action( 'admin_head', 'change_adminbar_colors' );  
}  
/* websites */  
if ( !is_admin() ) {  
    add_action( 'wp_head', 'change_adminbar_colors' );  
}  
^ top
PHP Class that enables the Admin Bar for Admins Only and Removes 28px Space
Admins Only Admin Bar while removing the 28px Space when viewing the Website.

view plain
/* 
 * PHP Class that enables the Admin Bar for Admins Only and Removes 28px Space 
 */  
class admins_only_admin_bar {  
    /* 
     * Loads when class is called 
     */  
    function __construct() {  
        /* disables admin bar */  
        remove_action( 'init', '_wp_admin_bar_init' );  
        /* calls function to remove 28px space */  
        add_action( 'admin_head', array( &$this, 'remove_adminbar_margin' ) );  
        add_action( 'wp_head', array( &$this, 'remove_adminbar_margin' ) );  
    }  
    /* 
     * Removes the 28px margin for the Admin Bar 
     */  
    public function remove_adminbar_margin() {  
        $remove_adminbar_margin = '<style type="text/css">  
            html { margin-top: -28px !important; }  
            * html body { margin-top: -28px !important; }  
        </style>';  
        echo $remove_adminbar_margin;  
    }  
}  
/* Admins Only - Call Class */  
if ( current_user_can( 'manage_options' ) ) {  
    $display_admin_bar = new admins_only_admin_bar();  
}  
^ top
PHP Class that forces the Admin Bar for logged out users, adds a login link, removes the wp logo, and adds a custom link menu to the Admin Bar.
This example, removes the WordPress Logo, adds a Login Link, and creates a menu named “Our Other Sites” with two Websites within the dropdown menu.

view plain
/* 
 * Force Admin Bar for logged out users, add a login link, remove the wp logo, and add a custom link menu 
 */  
class force_admin_bar {  
    /* 
     * Loads when class is called 
     */  
    function __construct() {  
        /* logged out users only */  
        if ( is_user_logged_in() ) { return false; }  
        /* remove wp logo */  
        add_action( 'wp_before_admin_bar_render', array( &$this, 'remove_wp_logo' ) );  
        /* remove search icon [uncomment to activate] */  
        //add_action( 'wp_before_admin_bar_render', array( &$this, 'disable_bar_search' ) );  
        /* force adminbar to logged out users */  
        add_filter( 'show_admin_bar', '__return_true' );  
        /* call function to add login link to admin bar */  
        add_action( 'admin_bar_menu', array( &$this, 'logged_out_menus' ), 15 );  
    }  
    /* 
     * Menus for logged out users 
     */  
    function logged_out_menus( $meta = FALSE ) {  
        global $wp_admin_bar, $blog_id;  
        /* logout menu link */  
        $wp_admin_bar->add_menu( array(  
            'id' => 'login_menu',  
            'title' => __( 'Login' ),  
            'href' => get_home_url( $blog_id, '/wp-login.php' ) )  
        );  
        /* create menus */  
        $wp_admin_bar->add_menu( array(  
            'id' => 'custom_menu',  
            'title' => __( 'Our Other Websites' ) ) /* set the menu name */  
        );  
        /* menu link */  
        $wp_admin_bar->add_menu( array(  
            'parent' => 'custom_menu',  
            'id'     => 'techNerdia', /* unique id name */  
            'title'     => 'techNerdia', /* Set the link title */  
            'href'  => 'http://technerdia.com/', /* Set the link a href */  
            'meta'  => array( target => '_blank' ) )  
        );  
        /* menu link */  
        $wp_admin_bar->add_menu( array(  
            'parent' => 'custom_menu',  
            'id'     => 'Google', /* unique id name */  
            'title'     => 'Google', /* Set the link title */  
            'href'  => 'http://google.com/', /* Set the link a href */  
            'meta'  => array( target => '_blank' ) )  
        );  
    }  
    /* 
    * Remove the WordPress Logo from the WordPress Admin Bar 
    */  
    function remove_wp_logo() {  
        global $wp_admin_bar;  
        $wp_admin_bar->remove_menu('wp-logo');  
    }  
    /* 
    * Disable the Search Icon and Input within the Admin Bar [uncomment to activate] 
    */  
    //function disable_bar_search() {  
    //  global $wp_admin_bar;  
    //  $wp_admin_bar->remove_menu('search');  
    //}  
}  
/* Call Class */  
$force_admin_bar = new force_admin_bar();  
^ top
Move the Login Link from the left side to the right side
This tip is used with the above example. David requested this feature via the Feedback form. ~Thanks David

view plain
/* 
 * Move the Login Link from the left side to the right side within the Admin Bar for logged out users. 
 */  
function move_login_link() {  
    $move_login_link = '<style type="text/css">  
        #wpadminbar #wp-admin-bar-login_menu{float:right}  
        }  
    </style>';  
    echo $move_login_link;  
}  
    add_action( 'wp_head', 'move_login_link' );  
^ top
Add Icons Instead of Text to the Main Admin Bar [NEW]
Adds custom icons to the main Admin Bar display. Sharon requested this feature via the Feedback form. ~Thanks Sharon

The menu id name is: 'id' => 'custom_menu', which relates to the css id name: #wp-admin-bar-custom_menu
In the first function, update the url to the icon(s) and modify the id name of the each custom_menu that you use.
In the css function, duplicate the id names for each custom_menu name. The first id moves the icon over with margin, the second sets the width of the menu item Adjust the margin to set the icon in he middle.
view plain
/* 
 * Add Icons Instead of Text to the Main Admin Bar 
 */  
function custom_adminbar_menu( $meta = TRUE ) {  
    global $wp_admin_bar;  
        if ( !is_user_logged_in() ) { return; }  
        if ( !is_super_admin() || !is_admin_bar_showing() ) { return; }  
    $wp_admin_bar->add_menu( array(  
        'id' => 'custom_menu',  
        'title' => __( '<img src="http://domain.com/wp-content/themes/theme_name/images/google-icon.gif" width="25" height="25" />' ),  
        'href' => 'http://google.com/',  
        'meta'  => array( target => '_blank' ) )  
    );  
}  
add_action( 'admin_bar_menu', 'custom_adminbar_menu', 15 );  
function custom_menu_css() {  
    $custom_menu_css = '<style type="text/css">  
        #wp-admin-bar-custom_menu img { margin:0 0 0 12px; } /** moves icon over */  
        #wp-admin-bar-custom_menu { width:75px; } /** sets width of custom menu */  
    </style>';  
    echo $custom_menu_css;  
}  
 add_action( 'admin_head', 'custom_menu_css' );  