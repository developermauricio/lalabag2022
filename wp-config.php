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

define ( 'WP_DEBUG', false);

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
/** define( 'DB_NAME', 'lalabag' );**/
define( 'DB_NAME', 'lalabagamazon' );
/** MySQL database username */
define( 'DB_USER', 'forge' );
/** MySQL database password */
define( 'DB_PASSWORD', 'SRnJ04NcPbna2SlJsciu' );
/** MySQL hostname */
define( 'DB_HOST', 'localhost' );
/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );
/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '31vT$YOE3.*bwi61=gNb#hwEM2r.A!F:5~oA!BkI!,nsLn|F,blSPra,l]#4N@|%' );
define( 'SECURE_AUTH_KEY',   '*dU,EhmScy;a;genNX&tIm=D+NM>W/TS?lCTEL&sbPjwPK8!E7[n8nlZm c%+ Z3' );
define( 'LOGGED_IN_KEY',     'lK8-&j~v<spW_hk9xu)2f=maX%ixG|*l_P#;28~b&6Bu]|MQii6Wh{+](DO;}UaX' );
define( 'NONCE_KEY',         '5gkHlsBCOtOkK-:aK/.nb ]Lp|SGac SXQWpX,tEO@XH,N:R5t/}]<L~zWN]pG(T' );
define( 'AUTH_SALT',         'kbZQq@PS8UXyS:1]4Dm2{bP,>`(;]kqo|Pq<}_+YF/kQ?K5pK(%.r<5WMD[Cmg4B' );
define( 'SECURE_AUTH_SALT',  '^#opt%B=2I72TT&^A#QG@!inS-lC}f @b<B6T;otF@_!L]bu7d`#,Z+bzaN<1._Y' );
define( 'LOGGED_IN_SALT',    '9kO1jFhY23< ox9..y6Iz5uMP{48Zf568=QSKCBkuWz/w41/ZEp5lO!9^m/yHy5s' );
define( 'NONCE_SALT',        'Yoyjn1FRp;j9E!X=t|jN)4P:j]]}I.PVEy^l/%w3x+I2oet>Zx]n;NOO3&*<G`BV' );
define( 'WP_CACHE_KEY_SALT', 'G0d1HR/R y(gDEYM9D#zPj}xHeErg>zZaj;]h5J+Kp+yN1>U$p+py <!D(HND5i)' );
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
define('DISALLOW_FILE_EDIT', true);
define('DISALLOW_FILE_MODS', true);
/**  configuaracion del correo  **/
/*define( 'WPMS_ON', true );
define( 'WPMS_SMTP_PASS', 'your_password' );*/
