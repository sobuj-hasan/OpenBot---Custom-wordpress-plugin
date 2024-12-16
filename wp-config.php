<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress_db2');

/** Database username */
define('DB_USER', 'root');

/** Database password */
define('DB_PASSWORD', '');

/** Database hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

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
define('AUTH_KEY',         'QNExrU#j/35e7{2=M <IT;S@Ix2Pjj3zL)]KQNKR11mrWe9/t xNPe@/|Xc!S)ZW');
define('SECURE_AUTH_KEY',  'c1oEH0yAJcBfw.A4_?Ma>~q5cfPSk}}^{<qC{zZXA@2|*(YEb0fUf9otG8qT]AD3');
define('LOGGED_IN_KEY',    'K88@<g,wmaC5 R_}Kp]IuvIe8xKT-c*fyrMUj/%>&Kwv~<cAw*R8OU3{BaEr=(b<');
define('NONCE_KEY',        'AjiZ%sG>Sq*nkzK>M)A[d~}^#o5H%]6]y3_++6bY><~f,!6U-Y``!5?){es,hf`!');
define('AUTH_SALT',        'N)zR20V%ULY+~Bs%OWMG/:)76z =shv~jI%!5ROEO!e 5#LRLt|p~wn;F(5Fh/fr');
define('SECURE_AUTH_SALT', '~:W7.yJz4 XqYl$Q,F1 ;)%Y|D,UM4F*sT6=<Snj(p@&L_s{Q_y=_a#+N6}[>V=8');
define('LOGGED_IN_SALT',   'sQS=ss>C)r>~T}`XR %W-7O]%Xsc[fe^w,z^AD%iVI+So*Hjw->T1I/4wyI1mzc=');
define('NONCE_SALT',       ']Ar:8y@D.a^Pg,75qv,<!#LIWc*?.5R*Gq8VqsFaV[{q3Noy&&v_x]i4u~su:C4Q');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define('WP_DEBUG', false);

/* Add any custom values between this line and the "stop editing" line. */

define('FS_METHOD', 'direct');

@ini_set('upload_max_filesize', '64M');
@ini_set('post_max_size', '64M');
@ini_set('memory_limit', '128M');


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (! defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
