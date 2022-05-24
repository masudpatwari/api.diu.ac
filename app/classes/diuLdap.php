<?php

namespace App\classes;
/**
 * diuLdap
 *
 * An abstraction layer for LDAP server communication using PHP
 *
 * @author Klaus Silveira <contact@klaussilveira.com>
 * @package simpleldap
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version 0.1
 * @link http://github.com/klaussilveira/SimpleLDAP
 */
class diuLdap
{

    private $connection = null;
    private $resource = null;
    private $host = null;
    private $port = null;
    private $username = null;
    private $password = null;

    /**
     * Ldap constructor.
     */
    public function __construct($host = 'hotspot.diu.ac', $port = '389', $username = 'Manager', $password = 'diu2009*')
    {

        $this->host     = $host;
        $this->port     = $port;
        $this->username = $username;
        $this->password = $password;

    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        //ldap_close($this->connection);
    }


    protected function connect()
    {
        $this->connection = ldap_connect($this->host, $this->port);
        if ($this->connection) {
            $this->resource = ldap_bind($this->connection, 'cn=' . $this->username . ',dc=diu,dc=ac', $this->password);
            if ($this->resource) {
                return $this;
            } else {
                throw new Exception('Username or Password id wrong');
            }
        } else {
            throw new Exception('Could not connect to server using host ' . $this->host . ' and port ' . $this->port);
        }
    }


    public function addUser($userName, $userPassword)
    {
        $this->connect();

        $dn                     = "cn=" . $userName . ',ou=Radius,DC=diu,DC=ac';
        $info                   = [];
        $info['cn']             = $userName;
        $info["sn"]             = $userPassword;
        $info["dialupAccess"]   = 'yes';
        $info["objectclass"][0] = "organizationalPerson";
        $info["objectclass"][1] = "top";
        $info["objectclass"][2] = "radiusprofile";
        $info["objectclass"][3] = "radiusExtension";
		try {
			 ldap_add($this->connection, $dn, $info);
		} catch ( ErrorException $e) {
			return $e;
		}


    }

    public function users()
    {
        $this->connect();
        $base_dn = 'ou=Radius,DC=diu,DC=ac';
        $filter  = "(cn=*)";
        $search  = ldap_search($this->connection, $base_dn, $filter);
        return ldap_get_entries($this->connection, $search);
    }

    public function users_count()
    {

        $this->connect();
        $dn     = 'ou=Radius,DC=diu,DC=ac';
        $filter = "(cn=*)";
        $search = ldap_search($this->connection, $dn, $filter);
        return ldap_count_entries($this->connection, $search);
    }

    public function delete($userName)
    {
        $this->connect();
        $dn = "cn=" . $userName . ',ou=Radius,DC=diu,DC=ac';
        return ldap_delete($this->connection, $dn);
    }

    public function change_password($userName, $userPassword )
    {
        $this->connect();
        $dn         = 'ou=Radius,DC=diu,DC=ac';
        $filter     = "(cn=" . $userName . ")";
        $search     = ldap_search($this->connection, $dn, $filter);
        $user_get   = ldap_get_entries($this->connection, $search);
        $user_entry = ldap_first_entry($this->connection, $search);
        $user_dn    = ldap_get_dn($this->connection, $user_entry);

        $entry["sn"] = $userPassword;
        // var_dump($search,$user_get, $user_entry,$user_dn);
        return ldap_modify($this->connection, $user_dn, $entry);

    }

    public function search_user( $userName )
    {
        $this->connect();
        $dn     = 'ou=Radius,DC=diu,DC=ac';
        $filter = "(cn=" . $userName  . ")";
        $search = ldap_search($this->connection, $dn, $filter);
        return ldap_get_entries($this->connection, $search);
    }

	/***
    public function modify_user($username, $data)
    {
		//$data['sn'][] = 'Bonded';

		if ( ! is_array($data)) {
			throw new Exception('$data must be an array');
		}

        $modify = ldap_modify($this->connection, "uid=$username," . $dn, $data);
        if (!$modify) {
            $error = ldap_errno($this->connection) . ": " . ldap_error($this->connection);
            throw new Exception($error);
            return false;
        } else {
            return true;
        }
    }
	//*/

}
