<?php
/*
Plugin Name: Fluid Accessible Sorting Grid
Plugin URI: http://wordpress.org/extend/plugins/fluid-accessible-sorting-grid/
Description: WAI-ARIA Enabled Sorting Grid Plugin for Wordpress
Author: Theofanis Oikonomou, Kontotasiou Dionysia
Version: 2.0
Author URI: http://www.iti.gr/iti/people/ThOikon.html, http://www.iti.gr/iti/people/Dionisia_Kontotasiou.html
*/
include_once 'getRecentPosts.php';
include_once 'getRecentComments.php';
include_once 'getCategories.php';
include_once 'getMeta.php';

add_action("plugins_loaded", "FluidAccessibleSortingGrid_init");
function FluidAccessibleSortingGrid_init() {
    register_sidebar_widget(__('Fluid Accessible Sorting Grid'), 'widget_FluidAccessibleSortingGrid');
    register_widget_control(   'Fluid Accessible Sorting Grid', 'FluidAccessibleSortingGrid_control', 200, 200 );
    if ( !is_admin() && is_active_widget('widget_FluidAccessibleSortingGrid') ) {
        wp_register_script('InfusionAll', ( get_bloginfo('wpurl') . '/wp-content/plugins/fluid-accessible-sorting-grid/lib/InfusionAll.js'));
        wp_enqueue_script('InfusionAll');

        wp_register_script('FluidAccessibleSortingGrid', ( get_bloginfo('wpurl') . '/wp-content/plugins/fluid-accessible-sorting-grid/lib/FluidAccessibleSortingGrid.js'));
        wp_enqueue_script('FluidAccessibleSortingGrid');

        wp_register_style('FluidAccessibleSortingGrid_css', ( get_bloginfo('wpurl') . '/wp-content/plugins/fluid-accessible-sorting-grid/lib/FluidAccessibleSortingGrid.css'));
        wp_enqueue_style('FluidAccessibleSortingGrid_css');
    }
}

function widget_FluidAccessibleSortingGrid($args) {
    extract($args);

    $options = get_option("widget_FluidAccessibleSortingGrid");
    if (!is_array( $options )) {
        $options = array(
                'title' => 'Fluid Accessible Sorting Grid',
            'categories' => 'Categories',
            'meta' => 'Meta',
            'recentPosts' => 'Recent Posts',
            'recentComments' => 'Recent Comments'
        );
    }

    echo $before_widget;
    echo $before_title;
    echo $options['title'];
    echo $after_title;

    //Our Widget Content
    FluidAccessibleSortingGridContent();
    echo $after_widget;
}

function FluidAccessibleSortingGridContent() {
    $recentPosts = get_recent_posts();
    $recentComments = get_recent_comments();
    $categories = get_my_categories();
    $meta = get_my_meta();

    $options = get_option("widget_FluidAccessibleSortingGrid");
    if (!is_array($options)) {
        $options = array(
            'title' => 'Fluid Accessible Sorting Grid',
            'categories' => 'Categories',
            'meta' => 'Meta',
            'recentPosts' => 'Recent Posts',
            'recentComments' => 'Recent Comments'
        );
    }

echo '<div class="reorderer_container">    
  <div class="flc-reorderer-movable" id="box0">
    <div class="caption">' . $options['recentPosts'] . '
      <ul>
        ' . $recentPosts . '
      </ul>
    </div>
  </div>
  <div class="flc-reorderer-movable" id="box1">
    <div class="caption">' . $options['recentComments'] . '
      <ul>
        ' . $recentComments . '
      </ul>
    </div>
  </div>
  <div class="flc-reorderer-movable" id="box2">
    <div class="caption">' . $options['categories'] . '
      <ul>
        ' . $categories . '
      </ul>
    </div>
  </div>
  <div class="flc-reorderer-movable" id="box4">
    <div class="caption">' . $options['meta'] . '
      <ul>
        ' . $meta . '
      </ul>
    </div>
  </div>
</div>


        <script type="text/javascript">
            demo.initGridReorderer();
        </script>';

}

function FluidAccessibleSortingGrid_control() {
    $options = get_option("widget_FluidAccessibleSortingGrid");
    if (!is_array( $options )) {
        $options = array(
                'title' => 'Fluid Accessible Sorting Grid',
            'categories' => 'Categories',
            'meta' => 'Meta',
            'recentPosts' => 'Recent Posts',
            'recentComments' => 'Recent Comments'
        );
    }

    if ($_POST['FluidAccessibleSortingGrid-SubmitTitle']) {
        $options['title'] = htmlspecialchars($_POST['FluidAccessibleSortingGrid-WidgetTitle']);
        update_option("widget_FluidAccessibleSortingGrid", $options);
    }
    if ($_POST['FluidAccessibleSortingGrid-SubmitCategories']) {
        $options['categories'] = htmlspecialchars($_POST['FluidAccessibleSortingGrid-WidgetCategories']);
        update_option("widget_FluidAccessibleSortingGrid", $options);
    }
    if ($_POST['FluidAccessibleSortingGrid-SubmitMeta']) {
        $options['meta'] = htmlspecialchars($_POST['FluidAccessibleSortingGrid-WidgetMeta']);
        update_option("widget_FluidAccessibleSortingGrid", $options);
    }
    if ($_POST['FluidAccessibleSortingGrid-SubmitRecentPosts']) {
        $options['recentPosts'] = htmlspecialchars($_POST['FluidAccessibleSortingGrid-WidgetRecentPosts']);
        update_option("widget_FluidAccessibleSortingGrid", $options);
    }
    if ($_POST['FluidAccessibleSortingGrid-SubmitRecentComments']) {
        $options['recentComments'] = htmlspecialchars($_POST['FluidAccessibleSortingGrid-WidgetRecentComments']);
        update_option("widget_FluidAccessibleSortingGrid", $options);
    }
    ?>
    <p>
        <label for="FluidAccessibleSortingGrid-WidgetTitle">Widget Title: </label>
        <input type="text" id="FluidAccessibleSortingGrid-WidgetTitle" name="FluidAccessibleSortingGrid-WidgetTitle" value="<?php echo $options['title'];?>" />
        <input type="hidden" id="FluidAccessibleSortingGrid-SubmitTitle" name="FluidAccessibleSortingGrid-SubmitTitle" value="1" />
    </p>
    <p>
        <label for="FluidAccessibleSortingGrid-WidgetCategories">Translation for "Categories": </label>
        <input type="text" id="FluidAccessibleSortingGrid-WidgetCategories" name="FluidAccessibleSortingGrid-WidgetCategories" value="<?php echo $options['categories'];?>" />
        <input type="hidden" id="FluidAccessibleSortingGrid-SubmitCategories" name="FluidAccessibleSortingGrid-SubmitCategories" value="1" />
    </p>
    <p>
        <label for="FluidAccessibleSortingGrid-WidgetMeta">Translation for "Meta": </label>
        <input type="text" id="FluidAccessibleSortingGrid-WidgetMeta" name="FluidAccessibleSortingGrid-WidgetMeta" value="<?php echo $options['meta'];?>" />
        <input type="hidden" id="FluidAccessibleSortingGrid-SubmitMeta" name="FluidAccessibleSortingGrid-SubmitMeta" value="1" />
    </p>
    <p>
        <label for="FluidAccessibleSortingGrid-WidgetRecentPosts">Translation for "Recent Posts": </label>
        <input type="text" id="FluidAccessibleSortingGrid-WidgetRecentPosts" name="FluidAccessibleSortingGrid-WidgetRecentPosts" value="<?php echo $options['recentPosts'];?>" />
        <input type="hidden" id="FluidAccessibleSortingGrid-SubmitRecentPosts" name="FluidAccessibleSortingGrid-SubmitRecentPosts" value="1" />
    </p>
    <p>
        <label for="FluidAccessibleSortingGrid-WidgetRecentComments">Translation for "Recent Comments": </label>
        <input type="text" id="FluidAccessibleSortingGrid-WidgetRecentComments" name="FluidAccessibleSortingGrid-WidgetRecentComments" value="<?php echo $options['recentComments'];?>" />
        <input type="hidden" id="FluidAccessibleSortingGrid-SubmitRecentComments" name="FluidAccessibleSortingGrid-SubmitRecentComments" value="1" />
    </p>
    
    <?php
}

?>
