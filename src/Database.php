<?php

/**
 * DataSource - Propel
 * 
 * @link https://github.com/IMHLabs/data-source-propel
 *
 * @uses Propel\Runtime\Propel
 * @uses Propel\Runtime\Connection\ConnectionManagerSingle
 * @uses Monolog\Logger
 * @uses Monolog\Handler\StreamHandler
 */
namespace DataSourcePropel;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Propel\Runtime\Propel;
use Propel\Runtime\Connection\ConnectionManagerSingle;

/**
 *
 * @package DataSourcePropel
 */
class Database
{
    
    /**
     * Database Connection
     *
     * @var \DataSourcePropel\Connection
     */
    protected static $connection = null;
    
    /**
     * Database Migration
     *
     * @var \DataSourcePropel\Migration
     */
    protected static $migration = null;
    
    /**
     * Enable Logging
     *
     * @var boolean
     */
    protected static $loggingEnabled = null;
    
    /**
     * Logfile
     *
     * @var string
     */
    protected static $logFile = null;

    /**
     * Set Connection Class
     *
     * @param \DataSourcePropel\Connection $connection  
     * @return void          
     */
    public static function setConnection($connection)
    {
        static::$connection = $connection;
    }

    /**
     * Get Connection Class
     *
     * @return \DataSourcePropel\Connection
     */
    public static function getConnection()
    {
        if (!static::$connection) {
            $connection = new Connection();
            static::setConnection($connection);
        }
        return static::$connection;
    }

    /**
     * Set Migration Class
     *
     * @param \DataSourcePropel\Migration $migration            
     * @return void          
     */
    public static function setMigration($migration)
    {
        static::$migration = $migration;
    }

    /**
     * Get Migration Class
     *
     * @return \DataSourcePropel\Migration
     */
    public static function getMigration()
    {
        if (!static::$migration) {
            $migration = new \DataSourcePropel\Migration();
            $migration->setConnection(static::getConnection());
            static::$migration = $migration;
        }
        return static::$migration;
    }

    /**
     * Set Database Adapter
     *
     * @param string $adapter            
     * @return void          
     */
    public static function setAdapter($adapter)
    {
        self::getConnection()->setAdapter($adapter);
    }

    /**
     * Set Database Host
     *
     * @param string $host            
     * @return void          
     */
    public static function setHost($host)
    {
        self::getConnection()->setHost($host);
    }

    /**
     * Set DBname
     *
     * @param string $dbname            
     * @return void          
     */
    public static function setDbname($dbname)
    {
        self::getConnection()->setDbname($dbname);
    }

    /**
     * Set Database User
     *
     * @param string $user            
     * @return void          
     */
    public static function setUser($user)
    {
        self::getConnection()->setUser($user);
    }

    /**
     * Set Database Password
     *
     * @param string $password            
     * @return void          
     */
    public static function setPassword($password)
    {
        self::getConnection()->setPassword($password);
    }

    /**
     * Set Dsn
     *
     * @param string $dsn            
     * @return void          
     */
    public static function setDsn($dsn)
    {
        self::getConnection()->setDsn($dsn);
    }

    /**
     * Set Charset
     *
     * @param string $charset            
     * @return void          
     */
    public static function setCharset($charset)
    {
        self::getConnection()->setCharset($charset);
    }

    /**
     * Set Queries String
     *
     * @param array $queries            
     * @return void          
     */
    public static function setQueries($queries)
    {
        self::getConnection()->setQueries($queries);
    }

    /**
     * Set Propel Connection Class name
     *
     * @param string $classname            
     * @return void          
     */
    public static function setClassname($classname)
    {
        self::getConnection()->setClassname($classname);
    }

    /**
     * Set Logging Enabled
     *
     * @param boolean $loggingEnabled            
     * @return void          
     */
    public static function setLoggingEnabled($loggingEnabled)
    {
        static::$loggingEnabled = ($loggingEnabled) ? true : false;
    }

    /**
     * Get Logging Enabled
     *
     * @return boolean
     */
    public static function getLoggingEnabled()
    {
        return static::$loggingEnabled;
    }

    /**
     * Set Log Directory
     *
     * @param string $logDir            
     * @return void          
     */
    public static function setLogDir($logDir)
    {
        static::$logDir = $logDir;
    }

    /**
     * Get Log Directory
     *
     * @return string
     */
    public static function getLogDir()
    {
        return static::$logDir;
    }

    /**
     * Set Log File
     *
     * @param string $logFile            
     * @return void          
     */
    public static function setLogFile($logFile)
    {
        static::$logFile = $logFile;
    }

    /**
     * Get Log File
     *
     * @return string
     */
    public static function getLogFile()
    {
        return static::$logFile;
    }

    /**
     * Build the model classes based on Propel XML schemas
     *
     * @return void          
     */
    public static function build()
    {
        self::getMigration()->build();
    }

    /**
     * Generate Sql
     *
     * @return void          
     */
    public static function buildSql()
    {
        self::getMigration()->buildSql();
    }

    /**
     * Generate Migration Class
     *
     * @return void          
     */
    public static function diff()
    {
        self::getMigration()->diff();
    }

    /**
     * Execute Migration Down
     *
     * @return void          
     */
    public static function down()
    {
        self::getMigration()->down();
    }

    /**
     * Execute all pending Migrations
     *
     * @return void          
     */
    public static function migrate()
    {
        self::getMigration()->migrate();
    }

    /**
     * Display Migration Status
     *
     * @return void          
     */
    public static function status()
    {
        self::getMigration()->status();
    }

    /**
     * Execute next pending Migration
     *
     * @return void          
     */
    public static function up()
    {
        self::getMigration()->up();
    }

    /**
     * Initialize Database Connection
     *
     * @param \DataSourcePropel\Connection|array $con            
     * @return void
     */
    public static function init($con = null)
    {
        if (is_array($con)) {
            $connection = \DataSourcePropel\Database::getConnection();
            $connection->setAdapter($con['adapter'])
                ->setHost($con['host'])
                ->setDbname($con['dbname'])
                ->setUser($con['user'])
                ->setPassword($con['password']);
            if ((array_key_exists('charset', $con)) && ($con['charset'])) {
                $connection->setCharset($con['charset']);
            }
            if ((array_key_exists('queries', $con)) && ($con['queries'])) {
                $connection->setQueries($con['queries']);
            }
            if ((array_key_exists('classname', $con)) && ($con['classname'])) {
                $connection->setClassname($con['classname']);
            }
            if (@$con['logfile']) {
                $connection->setLogFile($con['logfile']);
                $connection->setLoggingEnabled(true);
            }
            $connection->setName($con['name']);
            self::setConnection($connection);
        } elseif ($con) {
            self::setConnection($con);
        }
        $serviceContainer = Propel::getServiceContainer();
        $connection = self::getConnection();
        if ($dsn = $connection->getDsn()) {
            $serviceContainer->setAdapterClass($connection->getName(), $connection->getAdapter());
            $manager = new ConnectionManagerSingle();
            $manager->setConfiguration([
                'dsn'      => $dsn,
                'user'     => $connection->getUser(),
                'password' => $connection->getPassword() 
            ]);
            $serviceContainer->setConnectionManager($connection->getName(), $manager);
            if (self::getLoggingEnabled()) {
                $logger = new Logger($connection->getName());
                $logger->pushHandler(new StreamHandler(self::getLogFile(), Logger::DEBUG));
                $serviceContainer->setLogger($connection->getName(), $logger);
                $con = $serviceContainer->getConnectionManager($connection->getName())
                    ->getWriteConnection($serviceContainer->getAdapter($connection->getName()));
                $con->useDebug(true);
            }
        }
    }
}
