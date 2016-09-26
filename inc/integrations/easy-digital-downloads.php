<?php
/**
 * Easy Digital Downloads
 *
 * Functions for integrating with EDD.
 *
 * @package   infopreneur
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 */

/**
 * Get EDD Product Price
 *
 * Returns the formatted price of a given product. Trailing .00 is removed
 * from the price.
 *
 * @param int    $post_id Download ID to get the price from.
 * @param string $prepend Text/HTML to add before the price.
 *
 * @since 1.0.0
 * @return string
 */
function infopreneur_get_edd_price( $post_id, $prepend = '' ) {
	if ( edd_has_variable_prices( $post_id ) ) {
		return '';
	}

	$item_props = edd_add_schema_microdata() ? ' itemprop="offers" itemscope itemtype="http://schema.org/Offer"' : '';
	$price      = str_replace( '.00', '', edd_price( $post_id, false ) );

	$output = '<span' . $item_props . '>';
	$output .= '<span itemprop="price" class="edd_price">' . $price . '</span>';
	$output .= '</span>';

	return apply_filters( 'infopreneur/integrations/edd/get-price', $prepend . $output, $post_id );
}