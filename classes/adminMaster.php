<?php

/**
 * Main class file for admin_master table.
 * 
 * @author Anoop Santhanam <anoop.santhanam@gmail.com>
 */
class AdminMaster extends MessageManager
{
    public $app = null;
    private $_admin_id = null;
    public $adminValid = false;

    /**
     * Constructor for admin object.
     * 
     * @param int $adminID (optional)
     */
    public function __construct(int $adminID = null)
    {
        $this->app = $GLOBALS['app'];
        if ($adminID != null) {
            $this->_admin_id = addslashes(htmlentities($adminID));
            $this->adminValid = $this->verifyAdmin();
        }
    }

    /**
     * Verifies the current _admin_id in place.
     * 
     * @return bool 
     */
    public function verifyAdmin(): bool
    {
        if ($this->_admin_id != null) {
            $app = $this->app;
            $am = "SELECT idadmin_master FROM admin_master WHERE stat = '1' AND idadmin_master = '$adminID'";
            $am = $app['db']->fetchAssoc($am);
            if (!empty($am)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Gets an admin object
     * 
     * @return array The admin array or a failure message
     */
    public function getAdmin(): array
    {
        if ($this->adminValid) {
            $app = $this->app;
            $adminID = $this->_admin_id;
            $am = "SELECT * FROM admin_master WHERE stat = '1' AND idadmin_master = '$adminID'";
            $am = $app['db']->fetchAssoc($am);
            if (!empty($admin)) {
                return $admin;
            }
        }

        return MessageManager::error("INVALID__admin_id");
    }

    /**
     * Gets all admin objects.
     * 
     * @return array The resultant admin objects.
     */
    public function getAdmins(): array
    {
        $app = $this->app;
        $am = "SELECT idadmin_master FROM admin_master WHERE stat = '1' ORDER BY idadmin_master ASC";
        $am = $app['db']->fetchAll($am);
        $admins = array();
        foreach ($am as $admin) {
            $adminID = $admin['idadmin_master'];
            $this->__construct($adminID);
            $adminData = $this->getAdmin();
            if (is_array($admin)) {
                array_push($admins, $adminData);
            }
        }

        if (empty($admins)) {
            return MessageManager::error("NO_ADMIN_TYPES_FOUND");
        }

        return $admins;
    }
}