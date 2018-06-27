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
class Connection
{
    
    /**
     * Data Source Name
     *
     * @var string
     */
    protected $name = null;
    
    /**
     * Data Source Adapter
     *
     * @var string
     */
    protected $adapter = 'mysql';
    
    /**
     * Data Source Hostname
     *
     * @var string
     */
    protected $host = 'localhost';
    
    /**
     * Data Source Dbname
     *
     * @var string
     */
    protected $dbname = null;
    
    /**
     * Data Source User
     *
     * @var string
     */
    protected $user = null;
    
    /**
     * Data Source Password
     *
     * @var string
     */
    protected $password = '';
    
    /**
     * Data Source Dsn
     *
     * @var string
     */
    protected $dsn = null;
    
    /**
     * Charset
     *
     * @var string
     */
    protected $charset = 'utf8';
    
    /**
     * Queries
     *
     * @var array
     */
    protected $_queries = [
        'utf8' => 'SET NAMES utf8 COLLATE utf8_unicode_ci, COLLATION_CONNECTION = utf8_unicode_ci, COLLATION_DATABASE = utf8_unicode_ci, COLLATION_SERVER = utf8_unicode_ci' 
    ];
    
    /**
     * Connection Class Name
     *
     * @var string
     */
    protected $classname = '\\Propel\\Runtime\\Connection\\ConnectionWrapper';

    /**
     * Set Name
     *
     * @param string $name            
     * @return \DataSourcePropel\Connection
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Adapter
     *
     * @param string $adapter            
     * @return \DataSourcePropel\Connection
     */
    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;
        return $this->setDsn(null);
    }

    /**
     * Get Adapter
     *
     * @return string
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Set Host
     *
     * @param string $host            
     * @return \DataSourcePropel\Connection
     */
    public function setHost($host)
    {
        $this->host = $host;
        return $this->setDsn(null);
    }

    /**
     * Get Host
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set Dbname
     *
     * @param string $dbname            
     * @return \DataSourcePropel\Connection
     */
    public function setDbname($dbname)
    {
        $this->dbname = $dbname;
        return $this->setDsn(null);
    }

    /**
     * Get Dbname
     *
     * @return string
     */
    public function getDbname()
    {
        return $this->dbname;
    }

    /**
     * Set User
     *
     * @param string $user            
     * @return \DataSourcePropel\Connection
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this->setDsn(null);
    }

    /**
     * Get User
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set Password
     *
     * @param string $password            
     * @return \DataSourcePropel\Connection
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this->setDsn(null);
    }

    /**
     * Get Password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set Dsn
     *
     * @param string $dsn            
     * @return \DataSourcePropel\Connection
     */
    public function setDsn($dsn)
    {
        $this->dsn = $dsn;
        return $this;
    }

    /**
     * Get Dsn
     *
     * @return string
     */
    public function getDsn()
    {
        if (!$this->dsn) {
            switch ($this->getAdapter()) {
                case 'mysql':
                    $dsn = sprintf("mysql:host=%s;dbname=%s", $this->getHost(), $this->getDbname());
                    $this->setDsn($dsn);
                    break;
                case 'oci' :
                    $dsn = sprintf("oci:dbname=//%s/%s", $this->getHost(), $this->getDbname());
                    $this->setDsn($dsn);
                    break;
                case 'sqlite' :
                    $dsn = sprintf("sqlite:%s/%s", $this->getHost(), $this->getDbname());
                    $this->setDsn($dsn);
                    break;
                case 'pgsql' :
                    $dsn = sprintf("pgsql:host=%s;port=5432;dbname=%s;user=%s;password=%s", $this->getHost(), $this->getDbname(), $this->getUser(), $this->getPassword());
                    $this->setDsn($dsn);
                    break;
            }
        }
        return $this->dsn;
    }

    /**
     * Set Charset
     *
     * @param string $charset            
     * @return \DataSourcePropel\Connection
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
        return $this;
    }

    /**
     * Get Charset
     *
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * Set Queries
     *
     * @param array $queries            
     * @return \DataSourcePropel\Connection
     */
    public function setQueries($queries)
    {
        $this->queries = $queries;
        return $this;
    }

    /**
     * Get Queries
     *
     * @return string
     */
    public function getQueries()
    {
        return $this->queries;
    }

    /**
     * Set Classname
     *
     * @param string $classname            
     * @return \DataSourcePropel\Connection
     */
    public function setClassname($classname)
    {
        $this->classname = $classname;
        return $this;
    }

    /**
     * Get Classname
     *
     * @return string
     */
    public function getClassname()
    {
        return $this->classname;
    }

    /**
     * Get Configuration JSON, used for migrations
     *
     * @return string`
     */
    public function getJsonConfiguration()
    {
        $connection['propel']['database']['connections'][$this->getName()] = [
            'adapter'   => $this->getAdapter(),
            'classname' => $this->getClassname(),
            'user'      => $this->getUser(),
            'password'  => $this->getPassword(),
            'dsn'       => $this->getDsn() 
        ];
        if ($this->getCharset()) {
            $connection['propel']['database']['connections'][$this->getName()]['settings']['charset'] = $this->getCharset();
        }
        if ($this->getQueries()) {
            $connection['propel']['database']['connections'][$this->getName()]['settings']['queries'] = $this->getQueries();
        }
        $connection['propel']['runtime'] = [
            'defaultConnection' => $this->getName(),
            "connections"       => [
                $this->getName () 
            ] 
        ];
        $connection['propel']['generator'] = [
            "defaultConnection" => $this->getName(),
            "connections" => [
                $this->getName() 
            ] 
        ];
        return json_encode($connection);
    }
}
