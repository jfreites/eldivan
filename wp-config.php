<?php
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
define('DB_NAME', 'eldivan');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         '53In@}O8;AWCs&ly2@AoidQW4Dsfa?$z6<( +7h^}z$9TiRB_tgW6(?ZjNzX!#$I');
define('SECURE_AUTH_KEY',  '%A&_M=pe]{5(38iY$m:D-.Zm~~yI,$at]EeRHoE<`V``Xkdn(@~3*&g#Z{RooX</');
define('LOGGED_IN_KEY',    '</5LRS@uJ7Z(JN+-vwY_{ixb/B4..mOH94C3Y6!qv>2:U9#@T#O#De]:T GXREQj');
define('NONCE_KEY',        '0RvQFVNHgl;aUT%Vq_K.5&_qlw=A_eN]ZzyGF,DfhW})4(8U%T-hS#}@lU_HHT;.');
define('AUTH_SALT',        'fo@fO#rb9|8`0p^_Mui24~lQ9f{<Mhc.^Np>}?;$xt-P?kF@2*/D9s>uH=F-bEP ');
define('SECURE_AUTH_SALT', 'KY>3MaV&[t9[<{HlWaCCGaCbD!b|DWpt7nunm*ATHOQ>eTnLs>?yM=|Ld,hIQ{,.');
define('LOGGED_IN_SALT',   'cz^E6QTe80>=*mjj4oKLsB2b$KUd,alP583c=N)u?m+xN;26g8vhIbo^Ib1^kI^y');
define('NONCE_SALT',       'ZddOo9!MmLNwh^< V=XX]K8`quv)|jo,O3n62~rFK|E>_[}FmAHuYIMJY($5 ;WO');

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
