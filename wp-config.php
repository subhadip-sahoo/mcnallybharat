<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'Mcnallybharat');

/** MySQL database username */
define('DB_USER', 'Mcnallybharat');

/** MySQL database password */
define('DB_PASSWORD', 'Mcna635$!');

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
define('AUTH_KEY',         '_dK?dx=Hu5b8UXZ+!977Xc4hk}}0&^-6Uu+zoE{9GQ02S/;jX^By@RlWNB~|3it5');
define('SECURE_AUTH_KEY',  '@KuNM@<~Ni0Y:;n[AhB#GKQ+|`!Qlh~zXI)ccy^X~]*U%)%R)OkO5P=cY^#&$Nx3');
define('LOGGED_IN_KEY',    'CzyNu@TN{QT@g}D)|)%DNPt/B-|r&mVG){5e)4C}&,P4-Jq)+*0WNCuTy)n7oP?v');
define('NONCE_KEY',        'pO/NrZ8Rc- F@<P-j1+5no+,)a5dq5nv{4nSzF*>k,FgW8s#tk-^*Z-@7C*D:]{/');
define('AUTH_SALT',        'CDeCjQ>|oFR|E=CtZ&4y`#]~2V`?.jUpf-l%dH).m4-Ah?pN.!YD.Uvn{rY51JuQ');
define('SECURE_AUTH_SALT', '?_d>_5-e Con}Rw}IK7@=tE,%|AuZPI2n**G?F^+=WYXJmF6Xky-A4a_]]EFoX-d');
define('LOGGED_IN_SALT',   '%_V*zZ$8PzHph5#7-/$rWL-*q>KR#:*?vszB[v[vOkBi/L3o$99NcPj8+)gaqz=E');
define('NONCE_SALT',       'xg$}l,u66DrIb5/_GV6+z<`$[?;;3nMP)^=4g:|Dpxd]KSG]qJ=_T$`Z0}r%7]$b');

/**#@-*/

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
