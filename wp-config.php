<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/home2/nlk/public_html/nectar7/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
/** The name of the database for WordPress */
define('DB_NAME', 'nlk_wrdp37');

/** MySQL database username */
define('DB_USER', 'nlk_wrdp37');

/** MySQL database password */
define('DB_PASSWORD', 'NYHLa2Hu1EnVSCi');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'zStF~|rXqapv~==7>VmsK>LyQF!qb2B^?=YW(ITp)C/oENAj5NkdJo0ID6/5NArJPrm)rCjP0');
define('SECURE_AUTH_KEY',  'EP_v6)oLjaR)v#HQA:=(Gqj_Sgf!e:_)xO*Ywp4#/hQc#mKTet*OevU)XfPz=j955sWVGx');
define('LOGGED_IN_KEY',    '8YybCV\`aQB>JVPa/0S!q!)aBm5#:vB/>3YtTG*GAj:P^$dxu(Pv84e~:497OS0t#Z/9:vXgpTUk#jDJui/');
define('NONCE_KEY',        'eObh9!(L;VVqoAP=cVz$)k432xfv<kxHQ0m3oG##LSNy~x!jz|DBKtZQZPFJO@JBklxaT7aq');
define('AUTH_SALT',        ';y4*_KV3=uT;W-lAwuVEa=NU()o))<FEs>/|G6H4sE_k;p):i952#s1-l9?L?Rr_K?~Dp<:w');
define('SECURE_AUTH_SALT', '5iKH1Q2>H=dylF\`O!h#R3cj>TA7WLHDYF-1<ssa^-\`bGNgGTgn;MYryhPL#PFxa/N:');
define('LOGGED_IN_SALT',   '~UesX6oUnWo6eQv@g/d(WJ!$~$PpqJRbKOOF*cLm=T#zU1>D\`s/~xHRRV^q7');
define('NONCE_SALT',       'zU/e*JRFS?OV-B<j3pHzC>?5m2ZvESQk?#j)fL#!<~lJ~K(K\`z0p;9NEok0T/4A1eUjy~5:/B|');


/**#@-*/
define('AUTOSAVE_INTERVAL', 600 );
define('WP_POST_REVISIONS', 1);
define( 'WP_CRON_LOCK_TIMEOUT', 120 );
define( 'WP_AUTO_UPDATE_CORE', true );
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
add_filter( 'auto_update_plugin', '__return_true' );
add_filter( 'auto_update_theme', '__return_true' );
