<?php
/**
 * The template for displaying trips according to trip_types .
 *
 * @package Wp_Travel_Engine
 * @subpackage Wp_Travel_Engine/includes/templates
 * @since 1.0.0
 */
?>
<div id="wte-crumbs">
	<?php do_action( 'wp_travel_engine_breadcrumb_holder' ); ?>
</div>
<div
	id="wp-travel-trip-wrapper"
	class="trip-content-area"
	itemscope
	itemtype="http://schema.org/LocalBusiness">
	<div class="wp-travel-inner-wrapper">
		<div class="wp-travel-engine-archive-outer-wrap">
			<?php
            global $post;
            $selected_order = ! empty( $_GET['wte_orderby'] ) ? sanitize_text_field( wp_unslash( $_GET['wte_orderby'] ) ) : 'ASC';
            $termchildren   = get_terms(
                $taxonomy,
                array(
                    'orderby' => apply_filters( "wpte_{$taxonomy}_terms_order_by", 'name' ),
                    'order'   => apply_filters( "wpte_{$taxonomy}_terms_order", $selected_order ),
                )
            );
            $terms_by_ids = array();

            if ( is_array( $termchildren ) ) {
                foreach ( $termchildren as $term_object ) {
                    $term_object->children  = array();
                    $term_object->link      = get_term_link( $term_object->term_id );
                    $term_object->thumbnail = (int) get_term_meta( $term_object->term_id, 'category-image-id', true );
                    if ( isset( $terms_by_ids[ $term_object->term_id ] ) ) {
                        foreach ( (array) $terms_by_ids[ $term_object->term_id ] as $prop_name => $prop_value ) {
                            $term_object->{$prop_name} = $prop_value;
                        }
                    }
                    if ( $term_object->parent ) {
                        if ( ! isset( $terms_by_ids[ $term_object->parent ] ) ) {
                            $terms_by_ids[ $term_object->parent ] = new \stdClass();
                        }
                        $terms_by_ids[ $term_object->parent ]->children[] = $term_object->term_id;
                    }

                    $terms_by_ids[ $term_object->term_id ] = $term_object;
                }
            }
            if ( ! empty( $terms_by_ids ) ) {
                ?>
                <div class="page-header">
                    <div class="page-content">
                        <?php
                                $content = apply_filters( 'the_content', $post->post_content );
                                echo $content;
                        ?>
                    </div>
                </div>
                <div class="wp-travel-toolbar clearfix">
                    <div class="wte-filter-foundposts"></div>
                    <div class="wp-travel-engine-toolbar wte-filterby-dropdown">
                        <form class="wte-ordering" method="get">
                            <span><?php esc_html_e( 'Sort:', 'travel-monster' ); ?></span>
                            <div class="wpte-trip__adv-field wpte__select-field">
                                <?php
                                $selected_label = $selected_order === 'ASC' ?
                                                __( 'a - z', 'travel-monster' ) :
                                                __( 'z - a', 'travel-monster' );
                                ?>
                                <span class="wpte__input"><?php echo esc_html( $selected_label ); ?></span>
                                <input type="hidden" class="wpte__input-value" name="wte_orderby" value="<?php echo esc_attr( $selected_order ); ?>">
                                <div id="sort-options" class="wpte__select-options">
                                    <ul>
                                        <li class="wpte__select-options__label"><?php esc_html_e( 'Name', 'travel-monster' ); ?></li>
                                        <li data-value="ASC" 
                                            data-label="<?php esc_attr_e( 'a - z', 'travel-monster' ); ?>"
                                            <?php
                                            if ( $selected_order === 'ASC' ) {
                                                echo 'class="selected"';}
                                            ?>
                                            >
                                            <span><?php esc_html_e( 'a - z', 'travel-monster' ); ?></span>
                                        </li>
                                        <li data-value="DESC"
                                            data-label="<?php esc_attr_e( 'z - a', 'travel-monster' ); ?>"
                                            <?php
                                            if ( $selected_order === 'DESC' ) {
                                                echo 'class="selected"';}
                                            ?>
                                            >
                                            <span><?php esc_html_e( 'z - a', 'travel-monster' ); ?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="<?php echo esc_attr( $taxonomy ); ?>-holder wpte-trip-list-wrapper">
                        <?php
                            $show_taxonomy_children = wte_array_get( get_option( 'wp_travel_engine_settings', array() ), 'show_taxonomy_children', 'no' ) === 'yes';

                    foreach ( $terms_by_ids as $term_id => $term_object ) {
                        if ( $term_object->parent && ! $show_taxonomy_children ) {
                            continue;
                        }
                        ?>
                        <div class="item wpte-trip-category">
                            <div class="wpte-trip-category-img-wrap">
                                <figure class="thumbnail">
                                    <a href="<?php echo esc_url( $term_object->link ); ?>">
                                        <?php
                                            $term_object->thumbnail && print( \wp_get_attachment_image(
                                                $term_object->thumbnail,
                                                apply_filters( 'wp_travel_engine_activities_img_size', 'activities-thumb-size' ),
                                                false,
                                                array( 'itemprop' => 'image' )
                                            ) );
                                        ?>
                                    </a>
                                </figure>
                                <div class="wpte-trip-category-overlay">
                                    <div class="wpte-trip-subcat-wrap">
                                        <?php
                                        if ( count( $term_object->children ) > 0 ) :
                                            foreach ( $term_object->children as $index => $child_term_id ) {
                                                if ( ! isset( $terms_by_ids[ $child_term_id ] ) ) {
                                                    continue;
                                                }
                                                printf( '<a href="%1$s">%2$s</a>', esc_url( $terms_by_ids[ $child_term_id ]->link ), esc_html( $terms_by_ids[ $child_term_id ]->name ) );
                                            }
                                        endif;
                                        ?>
                                    </div>
                                    <div class="wpte-trip-category-btn">
                                        <?php printf( '<a href="%1$s" class="wpte-trip-cat-btn">%2$s</a>', esc_url( $term_object->link ), __( 'View All', 'travel-monster' ) ); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="wpte-trip-category-text-wrap">
                                <h2 class="wpte-trip-category-title" itemprop="name">
                                    <a href="<?php echo esc_url( $term_object->link ); ?>">
                                        <?php echo esc_html( $term_object->name ); ?></a><span class="trip-count"><?php printf( _n( '(%d Trip)', '(%d Trips)', (int) $term_object->count, 'travel-monster' ), (int) $term_object->count ); ?></span>
                                </h2>
                            </div>
                        </div>
                    <?php } ?>
                </div>
			<?php } else { ?>
                <div class="page-header">
                    <div class="page-content">
                        <?php
                            $content = apply_filters( 'the_content', $post->post_content );
                            echo $content;
                        ?>
                    </div>
				</div>
            <?php } ?>
		</div>
	</div>
</div>