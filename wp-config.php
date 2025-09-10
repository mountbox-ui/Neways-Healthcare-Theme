<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// Load environment-specific overrides if present (not committed)
if (file_exists(__DIR__ . '/wp-config-local.php')) {
    require __DIR__ . '/wp-config-local.php';
}

// Optionally load DB settings from environment variables
if (!defined('DB_NAME') && getenv('DB_NAME'))     define('DB_NAME', getenv('DB_NAME'));
if (!defined('DB_USER') && getenv('DB_USER'))     define('DB_USER', getenv('DB_USER'));
if (!defined('DB_PASSWORD') && getenv('DB_PASSWORD')) define('DB_PASSWORD', getenv('DB_PASSWORD'));
if (!defined('DB_HOST') && getenv('DB_HOST'))     define('DB_HOST', getenv('DB_HOST'));

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
if ( ! defined( 'DB_NAME' ) ) define( 'DB_NAME', 'u387277923_neways' );

/** Database username */
if ( ! defined( 'DB_USER' ) ) define( 'DB_USER', 'u387277923_neways' );

/** Database password */
if ( ! defined( 'DB_PASSWORD' ) ) define( 'DB_PASSWORD', 'Hudaif@121' );

/** Database hostname */
if ( ! defined( 'DB_HOST' ) ) define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'yb>x[Sm?8ob^@NvI&v*kp>C2}%MiUR,h|O;w/ZcN.CAeMEw)O,cC|}2&v;Feeo)f' );
define( 'SECURE_AUTH_KEY',   'fzbYq5C?@~K#Ow(WIVnBGN{@?fwAa[S&G#n?P%#OT9.)U29aia:~3$gX2~<:Dem>' );
define( 'LOGGED_IN_KEY',     'c>jjrS)QI9hX]17DWVFW&c;>&8d+x^0.$/$&~%vphA8[AC[&3NK:[+4k6JDW+r#P' );
define( 'NONCE_KEY',         '=sfq6q&3q@kPhjzP*>ft%^jyr!.DIVPOdIY]=%+ @cH/GEA5W.;z6wHP&Z1+FB6c' );
define( 'AUTH_SALT',         'YiJ72/[A{g6+!GbKU?lygA!bN.xip2Jt6HU$q4PMj0Yn%O|Rq$:u1>4he+:+kyef' );
define( 'SECURE_AUTH_SALT',  'GQuwPVd~|D~bC=FER{2IrdYX](`4Qa#Wrsdm6&3zCgTgTa3<g-6%{YQ-__9y]gpN' );
define( 'LOGGED_IN_SALT',    'ATA&RD$z{}GY]6,4d4Jba^qGi&)%WioNaV8+}|RaGU7ch}}bDvKg^Kw#`ajQW )P' );
define( 'NONCE_SALT',        '? &Kn%C&Q~aKsgX:xJH;|%Wq35d:gYty|m77t`JRM<j[(jAv+-=bu%T~0U<`By:t' );
define( 'WP_CACHE_KEY_SALT', 'uehJH{% &dd@;*Z&{B[@jb[FQb7psh^3MABN[DIpW13<ojKvfDN5_%~|dIfvxoN7' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
