<?php
/**
 * The base configuration for WordPress
 * Munar Luxury E-Commerce
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'munar_ecommerce' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 */
define( 'AUTH_KEY',         'munar_luxury_auth_key_8f3d8a91b2c4e5f6a7b8c9d0e1f2a3b4' );
define( 'SECURE_AUTH_KEY',  'munar_luxury_sec_key_1a2b3c4d5e6f7a8b9c0d1e2f3a4b5c6d' );
define( 'LOGGED_IN_KEY',    'munar_luxury_log_key_9f8e7d6c5b4a3f2e1d0c9b8a7f6e5d4c' );
define( 'NONCE_KEY',        'munar_luxury_nonce_key_3c4d5e6f7a8b9c0d1e2f3a4b5c6d7e8f' );
define( 'AUTH_SALT',        'munar_luxury_auth_salt_5b6c7d8e9f0a1b2c3d4e5f6a7b8c9d0e' );
define( 'SECURE_AUTH_SALT', 'munar_luxury_sec_salt_7a8b9c0d1e2f3a4b5c6d7e8f9a0b1c2d' );
define( 'LOGGED_IN_SALT',   'munar_luxury_log_salt_2c3d4e5f6a7b8c9d0e1f2a3b4c5d6e7f' );
define( 'NONCE_SALT',       'munar_luxury_nonce_salt_4e5f6a7b8c9d0e1f2a3b4c5d6e7f8a9b' );

/**#@-*/

/**
 * WordPress database table prefix.
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

/** Enable direct filesystem method for local development */
define( 'FS_METHOD', 'direct' );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
