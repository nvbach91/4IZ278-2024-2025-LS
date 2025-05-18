<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/../models/User.php';

/**
 * User database model
 */
class UserDb
{
    private $db;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Get user by ID
     * @param int $id User ID
     * @return User|null User object or null if not found
     */
    public function getUserById($id)
    {
        $user = $this->db->fetch(
            "SELECT u.*, r.name as role_name 
             FROM sp_users u
             JOIN sp_roles r ON u.role_id = r.id
             WHERE u.id = ?",
            [$id]
        );

        return $user ? new User($user) : null;
    }

    /**
     * Get user by email
     * @param string $email User email
     * @return User|null User object or null if not found
     */
    public function getUserByEmail($email)
    {
        $user = $this->db->fetch(
            "SELECT u.*, r.name as role_name 
             FROM sp_users u
             JOIN sp_roles r ON u.role_id = r.id
             WHERE u.email = ?",
            [$email]
        );

        return $user ? new User($user) : null;
    }

    /**
     * Get user by Facebook ID
     * @param string $facebookId Facebook ID
     * @return User|null User object or null if not found
     */
    public function getUserByFacebookId($facebookId)
    {
        $user = $this->db->fetch(
            "SELECT u.*, r.name as role_name 
             FROM sp_users u
             JOIN sp_roles r ON u.role_id = r.id
             WHERE u.facebook_id = ?",
            [$facebookId]
        );

        return $user ? new User($user) : null;
    }

    /**
     * Register a new user
     * @param string $name User name
     * @param string $email User email
     * @param string $password User password
     * @param string|null $facebookId Facebook ID (optional)
     * @return int|false User ID if successful, false otherwise
     */
    public function register($name, $email, $password, $facebookId = null)
    {
        // Check if email already exists
        if ($this->getUserByEmail($email)) {
            return false;
        }

        // Get default role (non-admin)
        $role = $this->db->fetch("SELECT id FROM sp_roles WHERE name = 'user'");
        if (!$role) {
            // If 'user' role doesn't exist, create it
            $this->db->query("INSERT INTO sp_roles (name) VALUES ('user')");
            $roleId = $this->db->lastInsertId();
        } else {
            $roleId = $role['id'];
        }

        // Hash password
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // Insert user
        $this->db->query(
            "INSERT INTO sp_users (name, email, password_hash, role_id, facebook_id) VALUES (?, ?, ?, ?, ?)",
            [$name, $email, $passwordHash, $roleId, $facebookId]
        );

        return $this->db->lastInsertId();
    }

    /**
     * Create a new user
     * @param array $userData User data
     * @return int|false User ID if successful, false otherwise
     */
    public function createUser($userData)
    {
        return $this->register(
            $userData['name'],
            $userData['email'],
            $userData['password'],
            $userData['facebook_id'] ?? null
        );
    }

    /**
     * Login user
     * @param string $email User email
     * @param string $password User password
     * @return User|false User object if login successful, false otherwise
     */
    public function login($email, $password)
    {
        $userData = $this->db->fetch(
            "SELECT u.*, r.name as role_name 
             FROM sp_users u
             JOIN sp_roles r ON u.role_id = r.id
             WHERE u.email = ?",
            [$email]
        );

        if (!$userData) {
            return false;
        }

        if (password_verify($password, $userData['password_hash'])) {
            $user = new User($userData);

            // Set session data
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->name;
            $_SESSION['user_email'] = $user->email;
            $_SESSION['user_role'] = $user->role_name;

            return $user;
        }

        return false;
    }

    /**
     * Logout user
     */
    public function logout()
    {
        // Unset all session data
        $_SESSION = [];

        // Destroy the session
        session_destroy();
    }

    /**
     * Get all users
     * @return array Array of User objects
     */
    public function getAllUsers()
    {
        $users = $this->db->fetchAll(
            "SELECT u.*, r.name as role_name 
             FROM sp_users u
             JOIN sp_roles r ON u.role_id = r.id
             ORDER BY u.name"
        );

        return array_map(function ($userData) {
            return new User($userData);
        }, $users);
    }

    /**
     * Update user
     * @param User $user User object
     * @param string|null $password New password (optional)
     * @return bool True if successful, false otherwise
     */
    public function updateUser($user, $password = null)
    {
        $params = [
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => $user->role_id,
            'facebook_id' => $user->facebook_id,
            'id' => $user->id
        ];

        $sql = "UPDATE sp_users SET name = :name, email = :email, 
                role_id = :role_id, facebook_id = :facebook_id";

        if ($password) {
            $params['password_hash'] = password_hash($password, PASSWORD_BCRYPT);
            $sql .= ", password_hash = :password_hash";
        }

        $sql .= " WHERE id = :id";

        return $this->db->query($sql, $params) !== false;
    }

    /**
     * Delete user
     * @param int $id User ID
     * @return bool True if successful, false otherwise
     */
    public function deleteUser($id)
    {
        return $this->db->query(
            "DELETE FROM sp_users WHERE id = ?",
            [$id]
        ) !== false;
    }

    /**
     * Get all roles
     * @return array Array of roles
     */
    public function getAllRoles()
    {
        return $this->db->fetchAll("SELECT * FROM sp_roles ORDER BY name");
    }

    /**
     * Change user role
     * @param int $userId User ID
     * @param int $roleId New role ID
     * @return bool True if successful, false otherwise
     */
    public function changeUserRole($userId, $roleId)
    {
        return $this->db->query(
            "UPDATE sp_users SET role_id = ? WHERE id = ?",
            [$roleId, $userId]
        ) !== false;
    }

    /**
     * Get recent users
     * @param int $days Number of days to look back
     * @return array Array of User objects
     */
    public function getRecentUsers($days = 7)
    {
        $users = $this->db->fetchAll(
            "SELECT u.*, r.name as role_name 
             FROM sp_users u
             JOIN sp_roles r ON u.role_id = r.id
             WHERE u.created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
             ORDER BY u.created_at DESC",
            [$days]
        );

        return array_map(function ($userData) {
            return new User($userData);
        }, $users);
    }
}
