<?php

/**
 * Class to handle all db operations
 * This class will have CRUD methods for database tables
 *
 * @author Ravi Tamada
 * @link URL Tutorial link
 */
class DbHandler {

    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    /**
     * Fetching all user tasks
     * @param String $user_id id of the user
     */
    public function locales() {
        $stmt = $this->conn->prepare("SELECT * FROM locals WHERE status=1");
        $stmt->bind_param("i");
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }


}

?>
