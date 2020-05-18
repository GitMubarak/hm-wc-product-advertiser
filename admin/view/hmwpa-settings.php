<?php
$hmwpaShowMessage = false;

if(isset($_POST['updateSettings'])){
    $hmwpaSettingsInfo = array(
                                'hmwpa_parent_border_color' => (!empty($_POST['hmwpa_parent_border_color'])) ? sanitize_text_field($_POST['hmwpa_parent_border_color']) : '#FF9700',
                                'hmwpa_background_color' => (!empty($_POST['hmwpa_background_color'])) ? sanitize_text_field($_POST['hmwpa_background_color']) : '#F2F2F2',
                                'hmwpa_post_title_color' => (!empty($_POST['hmwpa_post_title_color'])) ? sanitize_text_field($_POST['hmwpa_post_title_color']) : '#FF9700',
                                'hmwpa_post_category' => sanitize_text_field($_POST['hmwpa_post_category'])
                            );
     $hmwpaShowMessage = update_option('hmwpa_settings', serialize($hmwpaSettingsInfo));
}
$hmwpa_settings = stripslashes_deep(unserialize(get_option('hmwpa_settings')));
?>
<div id="hmwpa-wrap-all" class="wrap">
    <div class="settings-banner">
        <h2><?php esc_html_e('WP Scroll to Posts', HMWPA_TXT_DOMAIN); ?></h2>
    </div>
    <?php if($hmwpaShowMessage): $this->hmwpa_display_notification('success', 'Your information updated successfully.'); endif; ?>

    <form name="hmwpa-table" role="form" class="form-horizontal" method="post" action="" id="hmwpa-settings-form">
        <table class="form-table">
        <tr class="hmwpa_parent_border_color">
            <th scope="row">
                <label for="hmwpa_parent_border_color"><?php esc_html_e('Parent Border Color:', HMWPA_TXT_DOMAIN); ?></label>
            </th>
            <td>
                <input class="hmwpa-wp-color" type="text" name="hmwpa_parent_border_color" id="hmwpa_parent_border_color" value="<?php echo esc_attr($hmwpa_settings['hmwpa_parent_border_color']); ?>">
                <div id="colorpicker"></div>
            </td>
        </tr>
        <tr class="hmwpa_background_color">
            <th scope="row">
                <label for="hmwpa_background_color"><?php esc_html_e('Background Color:', HMWPA_TXT_DOMAIN); ?></label>
            </th>
            <td>
                <input class="hmwpa-wp-color" type="text" name="hmwpa_background_color" id="hmwpa_background_color" value="<?php echo esc_attr($hmwpa_settings['hmwpa_background_color']); ?>">
                <div id="colorpicker"></div>
            </td>
        </tr>
        <tr class="hmwpa_post_title_color">
            <th scope="row">
                <label for="hmwpa_post_title_color"><?php esc_html_e('Product Title Color:', HMWPA_TXT_DOMAIN); ?></label>
            </th>
            <td>
                <input class="hmwpa-wp-color" type="text" name="hmwpa_post_title_color" id="hmwpa_post_title_color" value="<?php echo esc_attr($hmwpa_settings['hmwpa_post_title_color']); ?>">
                <div id="colorpicker"></div>
            </td>
        </tr>
        <tr class="hmwpa_post_category">
            <th scope="row">
                <label for="hmwpa_post_category"><?php esc_html_e('Product Category:', HMWPA_TXT_DOMAIN); ?></label>
            </th>
            <td>
                <?php
                $hmwpa_args = array(
                                    'taxonomy'     => 'product_cat',
                                    'orderby'      => 'name',
                                    'show_count'   => 0,
                                    'pad_counts'   => 0,
                                    'hierarchical' => 1,
                                    'title_li'     => '',
                                    'hide_empty'   => 0
                                    );
                $hmwpa_categories = get_categories( $hmwpa_args );
                ?>
                <select class="medium-text" id="hmwpa_post_category" name="hmwpa_post_category">
                    <option value="">All Category</option>
                    <?php foreach( $hmwpa_categories as $cat ) : ?>
                        <option <?php if( $cat->cat_ID == $hmwpa_settings['hmwpa_post_category'] ) echo 'selected'; ?> value="<?php echo esc_attr($cat->cat_ID); ?>"><?php echo esc_html($cat->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        </table>
        <p class="submit"><button id="updateSettings" name="updateSettings" class="button button-primary"><?php esc_attr_e('Update Settings', HMWPA_TXT_DOMAIN); ?></button></p>
    </form>
</div>