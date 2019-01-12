<?php

/**
 * Main class file for user_master table.
 * 
 * @author Anoop Santhanam <anoop.santhanam@gmail.com>
 */
class UserMaster extends AdminMaster
{
    
    public $app = null;
    private $_user_id = null;
    public $userValid = false;

    /**
     * Constructs a user object.
     * 
     * @param int $userID the user id for the user object to be built.
     */
    public function __construct(int $userID = null)
    {
        $this->app = $GLOBALS['app'];
        if ($userID != null) {
            $this->_user_id = addslashes(htmlentities($userID));
            $this->userValid = $this->verifyUser();
        }
    }

    /**
     * Method to verify the current object.
     * 
     * @return bool 
     */
    public function verifyUser(): bool
    {
        if ($this->user_id != null) {
            $userID = $this->_user_id;
            $app = $this->app;
            $um = "SELECT admin_master_idadmin_master FROM user_master WHERE stat = '1' AND iduser_master = '$userID'";
            $um = $app['db']->fetchAssoc($um);
            if (!empty($um)) {
                $adminId = $um['admin_master_idadmin_master'];
                AdminMaster::__construct($adminID);
                if ($this->adminValid) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * To get a user object.
     * @return array Array of the user data.
     */
    public function getUser(): array
    {
        if ($this->userValid) {
            $app = $this->app;
            $userID = $this->_user_id;
            $um = "SELECT * FROM user_master WHERE iduser_master = '$userID'";
            $um = $app['db']->fetchAssoc($um);
            if (!empty($um)) {
                $adminID = $um['admin_master_idadmin_master'];
                adminMaster::__construct($adminID);
                $admin = adminMaster::getAdmin();
                if (is_array($admin)) {
                    $um['admin_master_idadmin_master'] = $admin;
                }
                
                return $um;
            }

            return $um;
        }

        return MessageManager::error("INVALID_USER_ID");
    }

    /**
     * To get a collection of user objects.
     * @param int $offset defaults to 0. -1 gets all the user rows.
     * 
     * @return array Array of all the users.
     */
    public function getUsers(int $offset = 0): array
    {
        $app = $this->app;
        $um = "SELECT iduser_master FROM user_master WHERE stat = '1'";
        if ($offset >= 0) {
            $um = "SELECT iduser_master FROM user_master WHERE stat = '1' ORDER BY iduser_master DESC $offset, 10";
        }
        $um = $app['db']->fetchAll($um);
        if (!empty($um)) {
            $users = array();
            foreach ($user as $um) {
                $userID = $user['iduser_master'];
                $this->__construct($userID);
                $userData = $this->getUser();
                array_push($users, $userData);
            }

            return $users;
        }

        return MessageManager::error("NO_USERS_FOUND");
    }

    /**
     * To delete a user object
     * @return array response to the user object being deleted.
     */
    public function deleteUser(): array
    {
        $app = $this->app;
        $userID = $this->_user_id;
        $um = "UPDATE user_master SET stat = '0' WHERE iduser_master = '$userID'";
        $um - $app['db']->executeUpdate($um);

        return MessageManager::info("USER_DELETED");
    }
}