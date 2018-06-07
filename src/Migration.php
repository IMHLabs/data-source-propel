<?php

/**
 * DataSource - Propel
 * 
 * @link https://github.com/IMHLabs/data-source-propel
 */
namespace DataSourcePropel;

/**
 *
 * @package DataSourcePropel
 */
class Migration
{
    
    /**
     * Database Connection
     *
     * @var string
     */
    protected $_connection = null;
    
    /**
     * Schema Path
     *
     * @var string
     */
    protected $_schemaPath = null;
    
    /**
     * Configuration Path
     *
     * @var string
     */
    protected $_configurationPath = null;
    
    /**
     * Sql Path
     *
     * @var string
     */
    protected $_sqlPath = null;
    
    /**
     * Migration Path
     *
     * @var string
     */
    protected $_migrationPath = null;
    
    /**
     * Class Path
     *
     * @var string
     */
    protected $_classPath = null;

    /**
     * Set Connection
     *
     * @param \DataSourcePropel\Connection $connection            
     * @return \DataSourcePropel\Database
     */
    public function setConnection($connection)
    {
        $this->_connection = $connection;
        return $this;
    }

    /**
     * Get Connection
     *
     * @return \DataSourcePropel\Connection
     */
    public function getConnection()
    {
        return $this->_connection;
    }

    /**
     * Set Schema Path
     *
     * @param string $schemaPath            
     * @return \DataSourcePropel\Connection
     */
    public function setSchemaPath($schemaPath)
    {
        $this->_schemaPath = $schemaPath;
        return $this;
    }

    /**
     * Get Schema Path
     *
     * @return string
     */
    public function getSchemaPath()
    {
        return realpath ( $this->_schemaPath );
    }

    /**
     * Set Configuration Path
     *
     * @param string $configurationPath            
     * @return \DataSourcePropel\Connection
     */
    public function setConfigurationPath($configurationPath)
    {
        $this->_configurationPath = $configurationPath;
        return $this;
    }

    /**
     * Get Configuration Path
     *
     * @return string
     */
    public function getConfigurationPath()
    {
        return realpath ( $this->_configurationPath );
    }

    /**
     * Set Sql Path
     *
     * @param string $sqlPath            
     * @return \DataSourcePropel\Connection
     */
    public function setSqlPath($sqlPath)
    {
        $this->_sqlPath = $sqlPath;
        return $this;
    }

    /**
     * Get Sql Path
     *
     * @return string
     */
    public function getSqlPath()
    {
        return realpath ( $this->_sqlPath );
    }

    /**
     * Set Migration Path
     *
     * @param string $migrationPath            
     * @return \DataSourcePropel\Connection
     */
    public function setMigrationPath($migrationPath)
    {
        $this->_migrationPath = $migrationPath;
        return $this;
    }

    /**
     * Get Migration Path
     *
     * @return string
     */
    public function getMigrationPath()
    {
        return realpath ( $this->_migrationPath );
    }

    /**
     * Set Class Path
     *
     * @param string $classPath            
     * @return \DataSourcePropel\Connection
     */
    public function setClassPath($classPath)
    {
        $this->_classPath = $classPath;
        return $this;
    }

    /**
     * Get Class Path
     *
     * @return string
     */
    public function getClassPath()
    {
        return realpath ( $this->_classPath );
    }

    /**
     * Build the model classes based on Propel XML schemas
     *
     * @return boolean
     */
    public function build()
    {
        if ((! $this->getConfigurationPath ()) || (! $this->getSchemaPath ()) || (! $this->getClassPath ())) {
            return false;
        }
        if ($this->_createConfig ()) {
            $propel_command = sprintf ( '%s model:build --config-dir="%s" --schema-dir="%s" --output-dir="%s"', realpath ( $this->_getVendorPath () . '/bin/propel' ), $this->getConfigurationPath (), $this->getSchemaPath (), $this->getClassPath () );
            exec ( $propel_command, $output );
            print implode ( "\n", $output );
            return true;
        }
        return false;
    }

    /**
     * Generate SQL files
     *
     * @return boolean
     */
    public function buildSql()
    {
        if ((! $this->getConfigurationPath ()) || (! $this->getSchemaPath ()) || (! $this->getSqlPath ())) {
            return false;
        }
        if ($this->_createConfig ()) {
            $propel_command = sprintf ( '%s sql:build --config-dir="%s" --schema-dir="%s" --output-dir="%s" --overwrite', realpath ( $this->_getVendorPath () . '/bin/propel' ), $this->getConfigurationPath (), $this->getSchemaPath (), $this->getSqlPath () );
            exec ( $propel_command, $output );
            print implode ( "\n", $output );
            return true;
        }
        return false;
    }

    /**
     * Generate migration classes
     *
     * @return boolean
     */
    public function diff()
    {
        if ((! $this->getConfigurationPath ()) || (! $this->getSchemaPath ()) || (! $this->getMigrationPath ())) {
            return false;
        }
        if ($this->_createConfig ()) {
            $propel_command = sprintf ( '%s migration:diff --config-dir="%s" --schema-dir="%s" --output-dir="%s"', realpath ( $this->_getVendorPath () . '/bin/propel' ), $this->getConfigurationPath (), $this->getSchemaPath (), $this->getMigrationPath () );
            $results = exec ( $propel_command, $output );
            print implode ( "\n", $output );
            return true;
        }
        return false;
    }

    /**
     * Execute migration down
     *
     * @return boolean
     */
    public function down()
    {
        if ((! $this->getConfigurationPath ()) || (! $this->getSchemaPath ()) || (! $this->getMigrationPath ())) {
            return false;
        }
        if ($this->_createConfig ()) {
            $propel_command = sprintf ( '%s migration:down --config-dir="%s" --output-dir="%s"', realpath ( $this->_getVendorPath () . '/bin/propel' ), $this->getConfigurationPath (), $this->getMigrationPath () );
            $results = exec ( $propel_command, $output );
            print implode ( "\n", $output );
            return true;
        }
        return false;
    }

    /**
     * Execute all pending migrations
     *
     * @return boolean
     */
    public function migrate()
    {
        if ((! $this->getConfigurationPath ()) || (! $this->getSchemaPath ()) || (! $this->getMigrationPath ())) {
            return false;
        }
        if ($this->_createConfig ()) {
            $propel_command = sprintf ( '%s migrate --config-dir="%s" --output-dir="%s"', realpath ( $this->_getVendorPath () . '/bin/propel' ), $this->getConfigurationPath (), $this->getMigrationPath () );
            $results = exec ( $propel_command, $output );
            print implode ( "\n", $output );
            return true;
        }
        return false;
    }

    /**
     * Display migration status
     *
     * @return boolean
     */
    public function status()
    {
        if ((! $this->getConfigurationPath ()) || (! $this->getSchemaPath ()) || (! $this->getMigrationPath ())) {
            return false;
        }
        if ($this->_createConfig ()) {
            $propel_command = sprintf ( '%s migration:status --verbose --config-dir="%s" --output-dir="%s"', realpath ( $this->_getVendorPath () . '/bin/propel' ), $this->getConfigurationPath (), $this->getMigrationPath () );
            $results = exec ( $propel_command, $output );
            print implode ( "\n", $output );
            return true;
        }
        return false;
    }

    /**
     * Execute next pending Migration
     *
     * @return boolean
     */
    public function up()
    {
        if ((! $this->getConfigurationPath ()) || (! $this->getSchemaPath ()) || (! $this->getMigrationPath ())) {
            return false;
        }
        if ($this->_createConfig ()) {
            $propel_command = sprintf ( '%s migration:up --config-dir="%s" --output-dir="%s"', realpath ( $this->_getVendorPath () . '/bin/propel' ), $this->getConfigurationPath (), $this->getMigrationPath () );
            $results = exec ( $propel_command, $output );
            print implode ( "\n", $output );
            return true;
        }
        return false;
    }

    /**
     * Create Configuration file for module
     *
     * @return boolean
     */
    public function _createConfig()
    {
        $connection = self::getConnection ();
        $config = $connection->getJsonConfiguration ();
        if ($config) {
            $config_path = $this->getConfigurationPath () . '/propel.json';
            file_put_contents ( $config_path, $config );
            return true;
        }
        return false;
    }

    /**
     * Get vendor path
     *
     * @return string
     */
    public function _getVendorPath()
    {
        return realpath ( __DIR__ . '/../../../' );
    }
}

