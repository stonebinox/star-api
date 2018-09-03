<?php

/**
 * Main class file for admin_master table.
 * @author Anoop Santhanam
 */
class adminMaster extends messageManager
{
    public $app = NULL;
    private $admin_id = NULL;
    public $adminValid = FALSE;

    /**
     * Constructor for admin object.
     * @param int $adminID (optional)
     */
    public function __construct(int $adminID = NULL)
    {
        $this->app = $GLOBALS['app'];
        if ($adminID != NULL) {
            $this->admin_id = addslashes(htmlentities($adminID));
            $this->adminValid = $this->verifyAdmin();
        }
    }

    /**
     * Verifies the current admin_id in place.
     * @return bool 
     */
    public function verifyAdmin(): bool
    {
        if ($this->admin_id != NULL) {
            $app = $this->app;
            $am = "SELECT idadmin_master FROM admin_master WHERE stat = '1' AND idadmin_master = '$adminID'";
            $am = $app['db']->fetchAssoc($am);
            if (!empty($am)) {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Gets an admin object
     * @return array The admin array or a failure message
     */
    public function getAdmin(): array
    {
        if ($this->adminValid) {
            $app = $this->app;
            $adminID = $this->admin_id;
            $am = "SELECT * FROM admin_master WHERE stat = '1' AND idadmin_master = '$adminID'";
            $am = $app['db']->fetchAssoc($am);
            if (!empty($admin)) {
                return $admin;
            }
        }

        return messageManager::error("INVALID_ADMIN_ID");
    }

    /**
     * Gets all admin objects.
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
            return messageManager::error("NO_ADMIN_TYPES_FOUND");
        }

        return $admins;
    }
}