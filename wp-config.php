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
/** The name of the database for WordPress */
define('DB_NAME', '');

/** MySQL database username */
define('DB_USER', '');

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
define('AUTH_KEY',         'Xy[i]Oyz-ft<-83u9YRXkY4B%,h}BKq)u6(rQWj1s|3+-YmInM-s]-g;/bN/Z) {');
define('SECURE_AUTH_KEY',  ':1d<h+s33Dg~y`CMlP=i!V9.?yi~tVIUGs-<_PKC|;*kFr6+B2m9zh8 v|J%ZH|+');
define('LOGGED_IN_KEY',    '9`*|O{/RD-9CI#}rh-K5Zh<:+#v)7XY r $4V#.~n!>s0=2|A`pS+s:qet,H~]eb');
define('NONCE_KEY',        '?F|P{H8nWimI18|t~#QS9gljQ_P#AM:]Qfm8MNS/JCz[<d-o|-nTev.kG|+#+FZ8');
define('AUTH_SALT',        'P/_LDD-9zEW9qRodO4]l%|S%Y?>3YHY(4,QA G:fMMT~(2o>Mp`; R By}kH|*gF');
define('SECURE_AUTH_SALT', '@d1fo!n}V3sYnZ<;V2-:>Um/7oiPpSmTG$0kkrn$j-yLd5.a^=IL+g.oxMZe;#~h');
define('LOGGED_IN_SALT',   'b8r`X3w+U|n)P5T@uo8#Y3+,KU?Z$f>lG6+VX%UaaJe.(|I6DhVoYQ.ubu{=voB7');
define('NONCE_SALT',       'e SB+;0y]@ZK+F>*w #*wm,qka=>Ye#oa Ko3LT(k<Jg=dozGlb&*n &[2 H/BN|');

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
