<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => env('DB_PREFIX', ''),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', 3306),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_PREFIX', ''),
            'strict' => env('DB_STRICT_MODE', true),
            'engine' => env('DB_ENGINE', null),
            'timezone' => env('DB_TIMEZONE', '+00:00'),
        ],

        'rms' => [
            'driver' => 'mysql',
            'host' => env('DB_RMS_HOST', ''),
            'port' => env('DB_RMS_PORT', ''),
            'database' => env('DB_RMS_DATABASE', ''),
            'username' => env('DB_RMS_USERNAME', ''),
            'password' => env('DB_RMS_PASSWORD', ''),
            'unix_socket' => env('DB_RMS_SOCKET', ''),
            'charset' => env('DB_RMS_CHARSET', 'utf8mb4'),
            'collation' => env('DB_RMS_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_RMS_PREFIX', ''),
            'strict' => env('DB_RMS_STRICT_MODE', true),
            'engine' => env('DB_RMS_ENGINE', null),
            'timezone' => env('DB_RMS_TIMEZONE', '+00:00'),
        ],

        'intl' => [
            'driver' => 'mysql',
            'host' => env('DB_INTL_HOST', ''),
            'port' => env('DB_INTL_PORT', ''),
            'database' => env('DB_INTL_DATABASE', ''),
            'username' => env('DB_INTL_USERNAME', ''),
            'password' => env('DB_INTL_PASSWORD', ''),
            'unix_socket' => env('DB_INTL_SOCKET', ''),
            'charset' => env('DB_INTL_CHARSET', 'utf8mb4'),
            'collation' => env('DB_INTL_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_INTL_PREFIX', ''),
            'strict' => env('DB_INTL_STRICT_MODE', true),
            'engine' => env('DB_INTL_ENGINE', null),
            'timezone' => env('DB_INTL_TIMEZONE', '+00:00'),
        ],

//        'ILNK' => [
//            'driver' => 'mysql',
//            'host' => env('DB_ILNK_HOST', ''),
//            'port' => env('DB_ILNK_PORT', ''),
//            'database' => env('DB_ILNK_DATABASE', ''),
//            'username' => env('DB_ILNK_USERNAME', ''),
//            'password' => env('DB_ILNK_PASSWORD', ''),
//            'unix_socket' => env('DB_ILNK_SOCKET', ''),
//            'charset' => env('DB_ILNK_CHARSET', 'utf8mb4'),
//            'collation' => env('DB_ILNK_COLLATION', 'utf8mb4_unicode_ci'),
//            'prefix' => env('DB_ILNK_PREFIX', ''),
//            'strict' => env('DB_ILNK_STRICT_MODE', true),
//            'engine' => env('DB_ILNK_ENGINE', null),
//            'timezone' => env('DB_ILNK_TIMEZONE', '+08:00'),
//        ],

        'pbx' => [
            'driver' => 'mysql',
            'host' => env('DB_PBX_HOST', ''),
            'port' => env('DB_PBX_PORT', ''),
            'database' => env('DB_PBX_DATABASE', ''),
            'username' => env('DB_PBX_USERNAME', ''),
            'password' => env('DB_PBX_PASSWORD', ''),
            'unix_socket' => env('DB_PBX_SOCKET', ''),
            'charset' => env('DB_PBX_CHARSET', 'utf8mb4'),
            'collation' => env('DB_PBX_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_PBX_PREFIX', ''),
            'strict' => env('DB_PBX_STRICT_MODE', true),
            'engine' => env('DB_PBX_ENGINE', null),
            'timezone' => env('DB_PBX_TIMEZONE', '+00:00'),
        ],

        'pbxsms' => [
            'driver' => 'mysql',
            'host' => env('DB_PBXSMS_HOST', ''),
            'port' => env('DB_PBXSMS_PORT', ''),
            'database' => env('DB_PBXSMS_DATABASE', ''),
            'username' => env('DB_PBXSMS_USERNAME', ''),
            'password' => env('DB_PBXSMS_PASSWORD', ''),
            'unix_socket' => env('DB_PBXSMS_SOCKET', ''),
            'charset' => env('DB_PBXSMS_CHARSET', 'utf8mb4'),
            'collation' => env('DB_PBXSMS_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_PBXSMS_PREFIX', ''),
            'strict' => env('DB_PBXSMS_STRICT_MODE', true),
            'engine' => env('DB_PBXSMS_ENGINE', null),
            'timezone' => env('DB_PBXSMS_TIMEZONE', '+00:00'),
        ],

        'std' => [
            'driver' => 'mysql',
            'host' => env('DB_STD_HOST', ''),
            'port' => env('DB_STD_PORT', ''),
            'database' => env('DB_STD_DATABASE', ''),
            'username' => env('DB_STD_USERNAME', ''),
            'password' => env('DB_STD_PASSWORD', ''),
            'unix_socket' => env('DB_STD_SOCKET', ''),
            'charset' => env('DB_STD_CHARSET', 'utf8mb4'),
            'collation' => env('DB_STD_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_STD_PREFIX', ''),
            'strict' => env('DB_STD_STRICT_MODE', true),
            'engine' => env('DB_STD_ENGINE', null),
            'timezone' => env('DB_STD_TIMEZONE', '+00:00'),
        ],

        'attendance' => [
            'driver' => 'mysql',
            'host' => env('DB_ATT_HOST', ''),
            'port' => env('DB_ATT_PORT', ''),
            'database' => env('DB_ATT_DATABASE', ''),
            'username' => env('DB_ATT_USERNAME', ''),
            'password' => env('DB_ATT_PASSWORD', ''),
            'unix_socket' => env('DB_ATT_SOCKET', ''),
            'charset' => env('DB_ATT_CHARSET', 'utf8mb4'),
            'collation' => env('DB_ATT_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_ATT_PREFIX', ''),
            'strict' => env('DB_ATT_STRICT_MODE', true),
            'engine' => env('DB_ATT_ENGINE', null),
            'timezone' => env('DB_ATT_TIMEZONE', '+00:00'),
        ],

        'pfsense' => [
            'driver' => 'mysql',
            'host' => env('DB_RADIUS_HOST', ''),
            'port' => env('DB_RADIUS_PORT', ''),
            'database' => env('DB_RADIUS_DATABASE', ''),
            'username' => env('DB_RADIUS_USERNAME', ''),
            'password' => env('DB_RADIUS_PASSWORD', ''),
            'unix_socket' => env('DB_RADIUS_SOCKET', ''),
            'charset' => env('DB_RADIUS_CHARSET', 'utf8mb4'),
            'collation' => env('DB_RADIUS_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_RADIUS_PREFIX', ''),
            'strict' => env('DB_RADIUS_STRICT_MODE', true),
            'engine' => env('DB_RADIUS_ENGINE', null),
            'timezone' => env('DB_RADIUS_TIMEZONE', '+00:00'),
        ],

        'koha' => [
            'driver' => 'mysql',
            'host' => env('DB_KOHA_HOST', ''),
            'port' => env('DB_KOHA_PORT', ''),
            'database' => env('DB_KOHA_DATABASE', ''),
            'username' => env('DB_KOHA_USERNAME', ''),
            'password' => env('DB_KOHA_PASSWORD', ''),
            'unix_socket' => env('DB_KOHA_SOCKET', ''),
            'charset' => env('DB_KOHA_CHARSET', 'utf8mb4'),
            'collation' => env('DB_KOHA_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_KOHA_PREFIX', ''),
            'strict' => env('DB_KOHA_STRICT_MODE', true),
            'engine' => env('DB_KOHA_ENGINE', null),
            'timezone' => env('DB_KOHA_TIMEZONE', '+00:00'),
        ],

        'tcrc' => [
            'driver' => 'mysql',
            'host' => env('DB_TCRC_HOST', ''),
            'port' => env('DB_TCRC_PORT', ''),
            'database' => env('DB_TCRC_DATABASE', ''),
            'username' => env('DB_TCRC_USERNAME', ''),
            'password' => env('DB_TCRC_PASSWORD', ''),
            'unix_socket' => env('DB_TCRC_SOCKET', ''),
            'charset' => env('DB_TCRC_CHARSET', 'utf8mb4'),
            'collation' => env('DB_TCRC_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_TCRC_PREFIX', ''),
            'strict' => env('DB_TCRC_STRICT_MODE', true),
            'engine' => env('DB_TCRC_ENGINE', null),
            'timezone' => env('DB_TCRC_TIMEZONE', '+00:00'),
        ],

        'iqac' => [
            'driver' => 'mysql',
            'host' => env('DB_IQAC_HOST', ''),
            'port' => env('DB_IQAC_PORT', ''),
            'database' => env('DB_IQAC_DATABASE', ''),
            'username' => env('DB_IQAC_USERNAME', ''),
            'password' => env('DB_IQAC_PASSWORD', ''),
            'unix_socket' => env('DB_IQAC_SOCKET', ''),
            'charset' => env('DB_IQAC_CHARSET', 'utf8mb4'),
            'collation' => env('DB_IQAC_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_IQAC_PREFIX', ''),
            'strict' => env('DB_IQAC_STRICT_MODE', true),
            'engine' => env('DB_IQAC_ENGINE', null),
            'timezone' => env('DB_IQAC_TIMEZONE', '+00:00'),
        ],
        
        

        'hostel' => [
            'driver' => 'mysql',
            'host' => env('DB_HMS_HOST', ''),
            'port' => env('DB_HMS_PORT', ''),
            'database' => env('DB_HMS_DATABASE', ''),
            'username' => env('DB_HMS_USERNAME', ''),
            'password' => env('DB_HMS_PASSWORD', ''),
            'unix_socket' => env('DB_HMS_SOCKET', ''),
            'charset' => env('DB_HMS_CHARSET', 'utf8mb4'),
            'collation' => env('DB_HMS_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_HMS_PREFIX', ''),
            'strict' => env('DB_HMS_STRICT_MODE', true),
            'engine' => env('DB_HMS_ENGINE', null),
            'timezone' => env('DB_HMS_TIMEZONE', '+00:00'),
        ],



        'students' => [
            'driver' => 'mysql',
            'host' => env('DB_BSTD_HOST', ''),
            'port' => env('DB_BSTD_PORT', ''),
            'database' => env('DB_BSTD_DATABASE', ''),
            'username' => env('DB_BSTD_USERNAME', ''),
            'password' => env('DB_BSTD_PASSWORD', ''),
            'unix_socket' => env('DB_BSTD_SOCKET', ''),
            'charset' => env('DB_BSTD_CHARSET', 'utf8mb4'),
            'collation' => env('DB_BSTD_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_BSTD_PREFIX', ''),
            'strict' => env('DB_BSTD_STRICT_MODE', true),
            'engine' => env('DB_BSTD_ENGINE', null),
            'timezone' => env('DB_BSTD_TIMEZONE', '+00:00'),
        ],



        'test' => [
            'driver' => 'mysql',
            'host' => env('DB_TEST_HOST', ''),
            'port' => env('DB_TEST_PORT', ''),
            'database' => env('DB_TEST_DATABASE', ''),
            'username' => env('DB_TEST_USERNAME', ''),
            'password' => env('DB_TEST_PASSWORD', ''),
            'unix_socket' => env('DB_TEST_SOCKET', ''),
            'charset' => env('DB_TEST_CHARSET', 'utf8mb4'),
            'collation' => env('DB_TEST_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_TEST_PREFIX', ''),
            'strict' => env('DB_TEST_STRICT_MODE', true),
            'engine' => env('DB_TEST_ENGINE', null),
            'timezone' => env('DB_TEST_TIMEZONE', '+00:00'),
        ],


        'adm' => [
            'driver' => 'mysql',
            'host' => env('DB_ADSN_HOST', ''),
            'port' => env('DB_ADSN_PORT', ''),
            'database' => env('DB_ADSN_DATABASE', ''),
            'username' => env('DB_ADSN_USERNAME', ''),
            'password' => env('DB_ADSN_PASSWORD', ''),
            'unix_socket' => env('DB_ADSN_SOCKET', ''),
            'charset' => env('DB_ADSN_CHARSET', 'utf8mb4'),
            'collation' => env('DB_ADSN_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_ADSN_PREFIX', ''),
            'strict' => env('DB_ADSN_STRICT_MODE', true),
            'engine' => env('DB_ADSN_ENGINE', null),
            'timezone' => env('DB_ADSN_TIMEZONE', '+00:00'),
        ],

        'tolet' => [
            'driver' => 'mysql',
            'host' => env('DB_TOLET_HOST', ''),
            'port' => env('DB_TOLET_PORT', ''),
            'database' => env('DB_TOLET_DATABASE', ''),
            'username' => env('DB_TOLET_USERNAME', ''),
            'password' => env('DB_TOLET_PASSWORD', ''),
            'unix_socket' => env('DB_TOLET_SOCKET', ''),
            'charset' => env('DB_TOLET_CHARSET', 'utf8mb4'),
            'collation' => env('DB_TOLET_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_TOLET_PREFIX', ''),
            'strict' => env('DB_TOLET_STRICT_MODE', true),
            'engine' => env('DB_TOLET_ENGINE', null),
            'timezone' => env('DB_TOLET_TIMEZONE', '+00:00'),
        ],


        'indlkg' => [
            'driver' => 'mysql',
            'host' => env('DB_INDLKG_HOST', ''),
            'port' => env('DB_INDLKG_PORT', ''),
            'database' => env('DB_INDLKG_DATABASE', ''),
            'username' => env('DB_INDLKG_USERNAME', ''),
            'password' => env('DB_INDLKG_PASSWORD', ''),
            'unix_socket' => env('DB_INDLKG_SOCKET', ''),
            'charset' => env('DB_INDLKG_CHARSET', 'utf8mb4'),
            'collation' => env('DB_INDLKG_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_INDLKG_PREFIX', ''),
            'strict' => env('DB_INDLKG_STRICT_MODE', true),
            'engine' => env('DB_INDLKG_ENGINE', null),
            'timezone' => env('DB_INDLKG_TIMEZONE', '+08:00'),
        ],


        'almni' => [
            'driver' => 'mysql',
            'host' => env('DB_ALMNI_HOST', ''),
            'port' => env('DB_ALMNI_PORT', ''),
            'database' => env('DB_ALMNI_DATABASE', ''),
            'username' => env('DB_ALMNI_USERNAME', ''),
            'password' => env('DB_ALMNI_PASSWORD', ''),
            'unix_socket' => env('DB_ALMNI_SOCKET', ''),
            'charset' => env('DB_ALMNI_CHARSET', 'utf8mb4'),
            'collation' => env('DB_ALMNI_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_ALMNI_PREFIX', ''),
            'strict' => env('DB_ALMNI_STRICT_MODE', true),
            'engine' => env('DB_ALMNI_ENGINE', null),
            'timezone' => env('DB_ALMNI_TIMEZONE', '+08:00'),
        ],


        'convocation' => [
            'driver' => 'mysql',
            'host' => env('DB_CON_HOST', ''),
            'port' => env('DB_CON_PORT', ''),
            'database' => env('DB_CON_DATABASE', ''),
            'username' => env('DB_CON_USERNAME', ''),
            'password' => env('DB_CON_PASSWORD', ''),
            'unix_socket' => env('DB_CON_SOCKET', ''),
            'charset' => env('DB_CON_CHARSET', 'utf8mb4'),
            'collation' => env('DB_CON_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_CON_PREFIX', ''),
            'strict' => env('DB_CON_STRICT_MODE', true),
            'engine' => env('DB_CON_ENGINE', null),
            'timezone' => env('DB_CON_TIMEZONE', '+00:00'),
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', 5432),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => env('DB_PREFIX', ''),
            'schema' => env('DB_SCHEMA', 'public'),
            'sslmode' => env('DB_SSL_MODE', 'prefer'),
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', 1433),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => env('DB_PREFIX', ''),
        ],

        'whats_app' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_WAPP_HOST', '127.0.0.1'),
            'port' => env('DB_WAPP_PORT', '3306'),
            'database' => env('DB_WAPP_DATABASE', 'forge'),
            'username' => env('DB_WAPP_USERNAME', 'forge'),
            'password' => env('DB_WAPP_PASSWORD', ''),
            'unix_socket' => env('DB_WAPP_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => 'predis',

        'cluster' => env('REDIS_CLUSTER', false),

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DB', 0),
        ],

        'cache' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_CACHE_DB', 1),
        ],

    ],

];
