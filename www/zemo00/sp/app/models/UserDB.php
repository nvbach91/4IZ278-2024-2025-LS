<?php

require_once __DIR__ . "/../core/Model.php";

class UserDB extends Model {
    
    protected string $tableName = 'sp_users';
    protected string|array $primaryKey = 'user_id';
    public ?array $sortingColumns = ['user_id', 'email', 'created_at'];

    /**
     * Fetches a user with the provided email
     * 
     * @param string $email The email of the user;
     * @return array|null The matching user data. Null if not found.
     */
    public function fetchByEmail($email): array|null {
        $condition = [ 'email' => $email ];
        return $this->fetchWhere($condition)[0] ?? null;
    }

    /**
     * Validates a user's email and password.
     * 
     * @param string $email The email of the user.
     * @param string $password The raw password of the user.
     * @return bool True if this user exists and the password
     *              is correct.
     */
    public function validateUser($email, $password): bool {
        $user = $this->fetchByEmail($email);

        if($user && password_verify($password, $user['password'])) {
            return true;
        }
        return false;
    }

    /**
     * Checks whether a user with the provided email is verified.
     * 
     * @param string $email The email of the user.
     * @return bool True if the user if verified.
     */
    public function isVerified($email): bool {
        $verified = $this->fetchWhere([ 'email' => $email ], ['is_verified'])[0] ?? null;
        $verified = (int)$verified['is_verified'];
        if ($verified === 1) {
            return true;
        }
        return false;
    }

    /**
     * Verifies the user (updates the is_verified value to 1).
     * 
     * @param string $email The email of the unverified user.
     */
    public function verify($email) {
        $user = $this->fetchByEmail($email);
        if ($user) {
            $this->update($user['user_id'], ["is_verified" => 1, 'verification_token' => null]);
        }
    }

    /**
     * Refreshes the verification token.
     * 
     * @param string $email The email of the user.
     * @param string $token The new token.
     */
    public function refreshToken(string $email, string $token): void {
        $user = $this->fetchByEmail($email);
        if ($user) {
            $this->update($user['user_id'], ['verification_token' => $token, 'token_created_at' => date('Y-m-d H:i:s')]);
        }
    }

}

?>