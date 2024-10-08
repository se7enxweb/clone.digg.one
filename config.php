<?php
/*
   WHAT THIS FILE IS ABOUT - READ CAREFULLY
   ----------------------------------------
   This file contains a documented list of the few configuration points
   available from config.php. The proposed default values below are meant
   to be the most optimized ones, or meaningful examples of what can be achieved.

   In order to have the present settings taken into account, you will need to
   rename this file into config.php, and keep it placed at the root of eZ Publish,
   where config.php-RECOMMENDED is currently placed. Plus, you will need to
   *uncomment* the proposed settings.
*/

/*
   TIMEZONES
   ---------
   The recommended way of setting timezones is via php.ini.
   However you can set the default timezone for your eZ Publish application as shown below.
   More on supported timezones : http://www.php.net/manual/en/timezones.php
*/
date_default_timezone_set( 'America/Los_Angeles' );

/*
    INI FILES OPTIMIZATIONS
    -----------------------
    This new setting controls whether eZINI should check if the settings have
    been updated in the *.ini-files*. If this check is disabled eZ Publish
    will always used the cached values, lowering the amount of stat-calls to
    the file system, and thus increasing performance.

    Set EZP_INI_FILEMTIME_CHECK constant to false to improve performance by
    not checking modified time on ini files.
    You can also set it to the name of an ini file you still want to check
    modified time for. For example, set it to 'site.ini' to make the system
    still check if that file has been modified, while ignoring changes for
    any other file.

    Note that independently of this setting, new INI override files will NEVER
    be found automatically. You will need to clear at least the INI cache
    when a new INI file override is added to the structure. Note that new files
    are not affected, but this is an edge situation.
*/
//define( 'EZP_INI_FILEMTIME_CHECK', false );


/*
    KERNEL OVERRIDES
    ----------------
    This setting controls if eZ Publish's autoload system should allow, and
    load classes, which override kernel classes from extensions.
    NB1: Not all classes can be overridden because of existing includes for eg handlers.
    NB2: This feature is not covered by support and any kind of kernel overrides
         needs to be explicitly informed to eZ Systems on support requests.
*/
//define( 'EZP_AUTOLOAD_ALLOW_KERNEL_OVERRIDE', false );
define( 'EZP_AUTOLOAD_ALLOW_KERNEL_OVERRIDE', true );


/*
    Set EZP_INI_FILE_PERMISSION constant to the permissions you want saved
    ini and cache files to have. This setting also applies to generated autoload files.
    Do keep an octal number as value here ( meaning it starts by a 0 ).
*/
//define( 'EZP_INI_FILE_PERMISSION', 0666 );



/*
   CUSTOM AUTOLOAD MECHANISM
   -------------------------
   It is also possible to push a custom autoload method to the autoload
   function stack. Remember to check for class prefixes in such a method, if it
   will not serve classes from eZ Publish and eZ Components.
   Here is an example code snippet to be placed right in this file, in the case
   you would be using your custom Foo framework, in which all PHP classes would be
   prefixed by 'Foo' :

   <code>
       ini_set( 'include_path', ini_get( 'include_path' ). ':/usr/lib/FooFramework/' );
       require 'Foo/ClassLoader.php';

       function fooAutoload( $className )
       {
          if ( 'Foo' == substr( $className, 0, 3 ) )
          {
              FooClassLoader::loadClass( $className );
          }
       }
       spl_autoload_register( 'fooAutoload' );
   </code>
*/



/*
   CLUSTERING
   ----------

   In order to serve binary files over HTTP, eZ Publish needs informations about your cluster backend.
   Most of these settings will duplicate those found in your file.ini.append.php.
   You can optionnaly define those constants in config.cluster.php
*/

/**
 * Storage backend. Possible values:
 * - dfsmysqli (DFS cluster, mysqli based)
 * - dfspostgres (DFS cluster, postgresql based)
 * - dfsoracle (with appropriate extension)
 */
// define( 'CLUSTER_STORAGE_BACKEND', 'dfsmysqli'  );

/**
 * Custom cluster storage backend
 * Root relative path to the custom clustering backend. When provided, the gateway filename won't be built based
 * on the default path + CLUSTER_STORAGE_BACKEND.
 *
 * Example: define( 'CLUSTER_STORAGE_GATEWAY_PATH', 'extension/ezoracle/clusterfilehandlers/gateway/dfs.php' );
 */
// define( 'CLUSTER_STORAGE_GATEWAY_PATH', 'extension/name/path/to/gateway.php' );

/**
 * Cluster storage host.
 * Required.
 */
// define( 'CLUSTER_STORAGE_HOST', 'localhost' );

/**
 * Cluster storage port.
 * Optional: the default RDBMS port will be used if set to false
 */
// define( 'CLUSTER_STORAGE_PORT', 3306 );

/**
 * Cluster storage user
 * Required
 */
// define( 'CLUSTER_STORAGE_USER', 'dbuser' );

/**
 * Cluster storage password
 * Required
 */
// define( 'CLUSTER_STORAGE_PASS', 'dbpassword' );

/**
 * Database name
 * Required for most RDBMS
 */
// define( 'CLUSTER_STORAGE_DB', 'ezpcluster' );

/**
 * Charset to use when communicating with the database.
 * Must match the value in file.ini
 */
// define( 'CLUSTER_STORAGE_CHARSET', 'utf8' );

/**
 * NFS share path.
 * Required ONLY for DFS based clusters
 */
// define( 'CLUSTER_MOUNT_POINT_PATH', '/media/nfs' );

/**
 * Enable persistent database connections, for backends with support (currently: Oracle, with appropriate extension)
 * Optional. Defaults to false.
 */
// define( 'CLUSTER_PERSISTENT_CONNECTION', false );

/**
 * Allow cluster index debugging.
 * This MAY reveal internal details, and should not be used in a production environnement.
 * Optional. Defaults to false.
 */
// define( 'CLUSTER_ENABLE_DEBUG', true );

/**
 * Enable HTTP cache features: if-modified-since & eTags
 * Optional. Defaults to true.
 */
// define( 'CLUSTER_ENABLE_HTTP_CACHE', false );

/**
 * Enable HTTP range support (partial HTTP downloads)
 * Optional. Defaults to true.
 * NOTE: This feature is ONLY available for DFS based cluster handlers.
 */
// define( 'CLUSTER_ENABLE_HTTP_RANGE', true );

/**
 * Enable usage of "Expires" headers.
 * Optional. Defaults to 86400 (one day).
 * Possible values: false (disable), or a TTL in seconds.
 * Can be set to a VERY high value (315569260 for 10 years) as long as you enable
 * ezjscore.ini/[Packer]/AppendLastModifiedTime so that the generation timestamp is appended
 * to ezjscore pack files
 */
// define( 'CLUSTER_EXPIRY_TIMEOUT', 86400 );

/**
 * Enable usage of "X-Powered-By" headers.
 * Optional. Defaults: eZ Publish.
 * Setting it to false will disable the custom header, but you still need to set expose_php to off
 * in the php configuration to get rid of the X-Powered-By header completely.
 */
// define( 'CLUSTER_HEADER_X_POWERED_BY', 'eZ Publish' );

/**
 * DFS/MySQLi only: custom table name for cache files metadata
 * Optional. Defaults: "ezdfsfile_cache"
 * If set to an existing mysql table, this table will be used for cache files.
 * Storage files will always remain inside ezdfsfile.
 */
// define( 'CLUSTER_METADATA_TABLE_CACHE', 'ezdfsfile_cache' );

/**
 * DFS/MySQLi only: search string to distinguish cache files and storage files
 * Optional. Defaults: "/cache/", "/storage/"
 *
 * This is an advanced setting.
 * Changing it only makes sense if FileSettings.CacheDir or FileSettings.StorageDir have been modified.
 */
// define( 'CLUSTER_METADATA_CACHE_PATH', '/cache/' );
// define( 'CLUSTER_METADATA_STORAGE_PATH', '/storage/' );

/*
   LOG HANDLING
   ------------

   Those constants allow to change the max log file size and the number of files
   to keep while the logs are rotated for files generated by eZ Publish
   (eZDebug) and custom log files (eZLog)
*/

/**
 * Maximum file size in bytes of eZ Publish generated log, ie
 * error.log, warning.log, notice.log and strict.log files
 * Default is 200Kb
 */
// define( 'EZPUBLISH_LOG_MAX_FILE_SIZE', 204800 );

/**
 * Number of files to keep while rotating eZ Publish generated log.
 * Set this constant to 0 to disable the built-in log rotation.
 */
// define( 'EZPUBLISH_LOG_ROTATE_FILES', 3 );

/**
 * Maximum file size in bytes of custom log file generated with eZLog class
 */
// define( 'CUSTOM_LOG_MAX_FILE_SIZE', 204800 );

/**
 * Number of files to keep while rotating custom log file.
 * Set this constant to 0 to disable the built-in log rotation.
 */
// define( 'CUSTOM_LOG_ROTATE_FILES', 3 );


?>
