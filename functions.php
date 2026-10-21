<?php
/** MyRehat Test child theme — functions.php. Contains 3 planted PHP bugs (Part 2). */

add_action( 'wp_enqueue_scripts', 'myrehat_test_assets' );
function myrehat_test_assets() {
    wp_enqueue_style( 'myrehat-test-style', get_stylesheet_uri(), array(), '1.0.0' );
    wp_enqueue_script(
        'myrehat-test-trails',
        get_stylesheet_directory_uri() . '/trails.js',
        array(),
        '1.0.0',
        true
    );
}

// BUG P1: missing text domain — should be __( 'Book a guided hike', 'myrehat-test' ).
function myrehat_test_booking_title() {
    return __( 'Book a guided hike', 'myrehat-test' );
}

// BUG P2 fixed: nonce check, sanitized input, strict date validation, PRG.
add_action( 'template_redirect', 'myrehat_test_booking_handler' );
function myrehat_test_booking_handler() {
    if ( ! isset( $_POST['trails_booking'] ) ) {
        return;
    }

    // fetch() sends this header; a native submit gets the PRG redirect instead.
    $wants_json = isset( $_SERVER['HTTP_X_REQUESTED_WITH'] )
        && 'XMLHttpRequest' === $_SERVER['HTTP_X_REQUESTED_WITH'];

    $nonce = isset( $_POST['myrehat_booking_nonce'] )
        ? sanitize_text_field( wp_unslash( $_POST['myrehat_booking_nonce'] ) )
        : '';

    if ( ! wp_verify_nonce( $nonce, 'myrehat_booking' ) ) {
        myrehat_test_booking_reply(
            $wants_json,
            false,
            __( 'Security check failed. Please reload the page and try again.', 'myrehat-test' ),
            array(),
            403
        );
    }

    $name = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
    $date = isset( $_POST['date'] ) ? sanitize_text_field( wp_unslash( $_POST['date'] ) ) : '';

    $name = trim( $name );
    if ( '' === $name ) {
        myrehat_test_booking_reply(
            $wants_json,
            false,
            __( 'Please enter your name.', 'myrehat-test' ),
            array(),
            422
        );
    }

    // type="date" is a browser hint only — validate the value server-side.
    $parsed = DateTime::createFromFormat( '!Y-m-d', $date );
    if ( ! $parsed || $parsed->format( 'Y-m-d' ) !== $date ) {
        myrehat_test_booking_reply(
            $wants_json,
            false,
            __( 'Please choose a valid date.', 'myrehat-test' ),
            array(),
            422
        );
    }

    $booking = array(
        'name' => $name,
        'date' => $parsed->format( 'Y-m-d' ),
    );

    set_transient( 'trails_last_booking', $booking, HOUR_IN_SECONDS );

    myrehat_test_booking_reply( $wants_json, true, '', array( 'booking' => $booking ) );
}

/**
 * One exit point for both transports: JSON for fetch(), PRG redirect otherwise.
 */
function myrehat_test_booking_reply( $wants_json, $ok, $message, $data = array(), $status = 200 ) {
    if ( $wants_json ) {
        if ( $ok ) {
            wp_send_json_success( $data, $status );
        }
        wp_send_json_error( array( 'message' => $message ), $status );
    }

    $target = wp_get_referer() ? wp_get_referer() : home_url( '/' );
    wp_safe_redirect( add_query_arg( 'booking', $ok ? 'ok' : 'invalid', $target ) );
    exit;
}

// BUG P3: callback expects 2 args but only 1 accepted — $trail_id is always null.
add_action( 'myrehat_trail_viewed', 'myrehat_test_count_view', 10, 1 );
function myrehat_test_count_view( $trail_id, $count = 1 ) {
    $key = 'trail_views_' . $trail_id;
    $total = (int) get_option( $key, 0 );
    update_option( $key, $total + $count );
}
