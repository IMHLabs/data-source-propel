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

/**
 *
 * @package DataSourcePropel
 */
class Propel
{

    /**
     * Initialize Propel Connectiona
     *
     * @param array $config            
     * @param mixed $dataSources            
     * @return void
     */
    public static function init(array $config, $dataSources = [])
    {
        $dataSources     = (is_array($dataSources)) ? $dataSources : [ 
            $dataSources 
        ];
        $config          = @$config['propel'];
        $connections     = @$config['database'] ['connections'];
        $defaultSettings = (@$connections['default']) ? $connections['default'] : [];
		$dataSources     = ($dataSources) ?: array_keys($connections);
        foreach ($dataSources as $dataSource) {
			if ($dataSource == 'default') {
				continue;
			}
            $dataSourceName     = null;
            $dataSourceSettings = [];
            if (class_exists($dataSource)) {
                if (defined($dataSource . '::NAME'))
                    $dataSourceName = $dataSource::NAME;
                if (defined($dataSource . '::ADAPTER'))
                    $dataSourceSettings['adapter'] = $dataSource::ADAPTER;
                if (defined($dataSource . '::HOST'))
                    $dataSourceSettings['host'] = $dataSource::HOST;
                if (defined($dataSource . '::DBNAME'))
                    $dataSourceSettings['dbname'] = $dataSource::DBNAME;
                if (defined($dataSource . '::USER'))
                    $dataSourceSettings['user'] = $dataSource::USER;
                if (defined($dataSource . '::PASSWORD'))
                    $dataSourceSettings['password'] = $dataSource::PASSWORD;
                if (defined($dataSource . '::CHARSET'))
                    $dataSourceSettings['charset'] = $dataSource::CHARSET;
                if (defined($dataSource . '::QUERIES'))
                    $dataSourceSettings['queries'] = $dataSource::QUERIES;
                if (defined($dataSource . '::CLASSNAME'))
                    $dataSourceSettings['classname'] = $dataSource::CLASSNAME;
                $defaultSettings = array_merge($defaultSettings, $dataSourceSettings);
            } else {
                $dataSourceName = $dataSource;
            }
            $configSettings     = (@$connections[$dataSource]) ?: [];
            $settings           = array_merge($defaultSettings, $configSettings);
            $connectionSettings = [ 
                'name'      => $dataSourceName,
                'adapter'   => (@$settings['adapter'])   ?: null,
                'host'      => (@$settings['host'])      ?: null,
                'dbname'    => (@$settings['dbname'])    ?: null,
                'user'      => (@$settings['user'])      ?: null,
                'password'  => (@$settings['password'])  ?: null,
                'charset'   => (@$settings['charset'])   ?: null,
                'queries'   => (@$settings['queries'])   ?: null,
                'classname' => (@$settings['classname']) ?: null 
            ];
            if (@$settings['logging_enabled']) {
                $connectionSettings['logfile'] = (@$settings['logfile']) ?: null;
            }
            \DataSourcePropel\Database::init($connectionSettings);
        }
    }

    /**
     * Initialize Propel Migration
     *
     * @param array $config            
     * @param string $dataSource            
     * @return \DataSourcePropel\Migration
     */
    public static function migration(array $config, $dataSource)
    {
        $config                   = @$config['propel'];
        $connections              = @$config['database']['connections'];
        $migrationSettings        = @$config['database']['migration'];
        $defaultSettings          = (@$connections['default']) ?: [];
        $defaultMigrationSettings = (@$migrationSettings['default']) ?: [];
        $dataSourceName           = null;
        $dataSourceSettings       = $dataSourceMigrationSettings = [];
        if (class_exists($dataSource)) {
            if (defined($dataSource . '::NAME'))
                $dataSourceName = $dataSource::NAME;
            if (defined($dataSource . '::ADAPTER'))
                $dataSourceSettings['adapter'] = $dataSource::ADAPTER;
            if (defined($dataSource . '::HOST'))
                $dataSourceSettings ['host'] = $dataSource::HOST;
            if (defined($dataSource . '::DBNAME'))
                $dataSourceSettings ['dbname'] = $dataSource::DBNAME;
            if (defined($dataSource . '::USER'))
                $dataSourceSettings ['user'] = $dataSource::USER;
            if (defined($dataSource . '::PASSWORD'))
                $dataSourceSettings ['password'] = $dataSource::PASSWORD;
            if (defined($dataSource . '::CHARSET'))
                $dataSourceSettings ['charset'] = $dataSource::CHARSET;
            if (defined($dataSource . '::QUERIES'))
                $dataSourceSettings ['queries'] = $dataSource::QUERIES;
            if (defined($dataSource . '::CLASSNAME'))
                $dataSourceSettings ['classname'] = $dataSource::CLASSNAME;
            if (defined($dataSource . '::SCHEMA_PATH'))
                $dataSourceMigrationSettings['schema_path'] = $dataSource::SCHEMA_PATH;
            if (defined($dataSource . '::CONFIG_PATH'))
                $dataSourceMigrationSettings['config_path'] = $dataSource::CONFIG_PATH;
            if (defined($dataSource . '::SQL_PATH'))
                $dataSourceMigrationSettings['sql_path'] = $dataSource::SQL_PATH;
            if (defined($dataSource . '::MIGRATION_PATH'))
                $dataSourceMigrationSettings['migration_path'] = $dataSource::MIGRATION_PATH;
            if (defined ($dataSource . '::CLASS_PATH'))
                $dataSourceMigrationSettings['class_path'] = $dataSource::CLASS_PATH;
            $defaultSettings = array_merge($defaultSettings, $dataSourceSettings);
            $defaultMigrationSettings = array_merge($defaultMigrationSettings, $dataSourceMigrationSettings);
        } else {
            $dataSourceName = $dataSource;
        }
        $configSettings     = (@$connections[$dataSource]) ?: [];
        $settings           = array_merge($defaultSettings, $configSettings);
        $migrationSettings  = (@$migrationSettings[$dataSource]) ?: [];
        $migrationSettings  = array_merge($defaultMigrationSettings, $migrationSettings);
        $connectionSettings = [ 
            'name' => $dataSourceName,
            'adapter'   => (@$settings['adapter'])   ?: null,
            'host'      => (@$settings['host'])      ?: null,
            'dbname'    => (@$settings['dbname'])    ?: null,
            'user'      => (@$settings['user'])      ?: null,
            'password'  => (@$settings['password'])  ?: null,
            'charset'   => (@$settings['charset'])   ?: null,
            'queries'   => (@$settings['queries'])   ?: null,
            'classname' => (@$settings['classname']) ?: null 
        ];
        if (@$settings['logging_enabled']) {
            $connectionSettings['logfile'] = (@$settings['logfile']) ?: null;
        }
        \DataSourcePropel\Database::init($connectionSettings);
        $migrationClass = \DataSourcePropel\Database::getMigration();
        $migrationClass->setSchemaPath(@$migrationSettings['schema_path'])
            ->setConfigurationPath(@$migrationSettings['config_path'])
            ->setSqlPath(@$migrationSettings['sql_path'])
            ->setMigrationPath(@$migrationSettings['migration_path'])
            ->setClassPath(@$migrationSettings['class_path']);
        return $migrationClass;
    }
}

