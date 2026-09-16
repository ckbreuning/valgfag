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

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',          '=J-!`I1s0wv(+JR&|MZ<W+Q;!<~{i4PbZB@Qk]eed C9*SXhYA*6u~SU${SWDy:,' );
define( 'SECURE_AUTH_KEY',   '6j[2M!tV)B!ZT8xPA}1VQ1=xhv:$ySnA8hoh-E Z|fD^i5EVy4 Sr.7s&?a$$n <' );
define( 'LOGGED_IN_KEY',     '8>32,|-%39%cMb,Xj|kc[|Khd%}mC9MU.2`MZt}cc1V74_v($cOO3h.#*$86`#>E' );
define( 'NONCE_KEY',         '4&eDQS7f&ng3sCb qG^yc0s&ntLAx$f2XGF^!,Ixbc,c)Mi[ar?H)Lx9bH<vcr #' );
define( 'AUTH_SALT',         'yI_]n%qC0/_@uFH|CPaU-6vKT1Zjd*>bXd446n[Gh{WM,AdoeN]&?<-[_&dxk/!s' );
define( 'SECURE_AUTH_SALT',  'uE2BUO25pEp{KfmU6#}5D8=VH`q* BnB| OYbZo(ZndBfka96JX<XAObBO,lP)N#' );
define( 'LOGGED_IN_SALT',    '+lL>kjM<?s6y+M>PlK&34[.$o&h)m]ZbXxFlF6F1#_4|>SD1KZr/_BodAFPz4)~K' );
define( 'NONCE_SALT',        'na9;QL[hTRFR-vnW|Pug4{e[&&)bL<m*WSX0xq(XDD!n,Ck]GA;au]#F#>i{kO3 ' );
define( 'WP_CACHE_KEY_SALT', '_,Xe5~9@lD6IW;*1u|~H.e)UAyT[xf H_(6D.da?ONua=}B>k[QL:J[4wl+v:=o ' );


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
