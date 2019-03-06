<?php
ob_start();
error_reporting(0);
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp_multisite');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');



/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'A;D}*A.U2kH4SP7ZRIt)Lhy<_FzhQ-PJc*;s`N/PP8u6)&1}MB]KXnjPTe3<ce];');
define('SECURE_AUTH_KEY',  'y^@MC|5Lbqo95m@NtJ)y6P)@Srjr8$d%OTYS0dqRt/dsYh(*>2ZRRUXRC$0(K!p6');
define('LOGGED_IN_KEY',    '<P9Rk*wi;.Rw(Y=>tV/k`#Or-fCt+MhU*S=EX9l;~VHLJiU.%#dZfYuq=w>:q;||');
define('NONCE_KEY',        'H_[1XYpew3x8PB#FF.)i/)v:`|{*;tkb}#z-B1MM?Qcel_qX`MVva>)z!mF3#TjD');
define('AUTH_SALT',        'L>`9.+sn)Q/,Ag[qwxSiBa;Kk0$;re a!Ug]f0l^>~w{^k4FaT`71)0AZ?!eLu7p');
define('SECURE_AUTH_SALT', 's9Q)[;>=^jb;jVJRmT1mX9!1,ES!H;rT4!C_QXNV[QE(>cl,rU@X_#B#)y?w!zn!');
define('LOGGED_IN_SALT',   '3-PgOkp6d<Wfw&A4L*Sk$So:[%Alm|:-<kcXh7IPTqBHw$I}l5^OGKM&!I?ro{6`');
define('NONCE_SALT',       'cP*a>tPAAyL;xn~P;v+G/u<MN1jEjnhvGHD51-qQWb_q)wqd4~+,F$m`oyfD?wI=');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG',false);

/* That's all, stop editing! Happy blogging. */
define( 'WP_ALLOW_MULTISITE', true );
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', true);
//define('DOMAIN_CURRENT_SITE', 'azure.yorkvilleu.test');
//define('PATH_CURRENT_SITE', '/');
//define('SITE_ID_CURRENT_SITE', 1);
//define('BLOG_ID_CURRENT_SITE', 1);
//define('NOBLOGREDIRECT', 'azure.yorkvilleu.test');

//HERE

//define('COOKIE_DOMAIN', false);
define('COOKIE_DOMAIN', $_SERVER['HTTP_HOST']);
define('COOKIE_DOMAIN', '');
define('ADMIN_COOKIE_PATH', '/');
define('COOKIE_DOMAIN', '');
define('COOKIEPATH', '');
define('SITECOOKIEPATH', ''); 

//define('ALTERNATE_WP_CRON', true);
define('DISABLE_WP_CRON', false);

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

