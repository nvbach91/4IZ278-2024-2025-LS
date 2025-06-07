<?php require_once __DIR__.'/../database/UsersDB.php';?>
<?php

    class Validator {
        private array $errors;
        private $userDB;

        public function __construct(){
            $this->errors = [];
            $this->userDB = new UsersDB();
        }

        private function validateRequired(string $field, $value): bool {
            if (empty($value)) {
                $this->errors[$field] = "Field '$field' must be filled.";
                return false;
            }
            return true;
        }

        private function validateEmailFormat(string $field, string $value): bool {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $this->errors[$field] = "Invalid $field format.";
                return false;
            }
            return true;
        }

        private function validatePhoneFormat(string $field, string $value): bool {
            if (!empty($value) && !preg_match('/^(\+\d{1,3} ?)?([0-9] ?){9}$/', $value)) {
                $this->errors[$field] = "Invalid $field number format.";
                return false;
            }
            return true;
        }

        private function validateMatch(string $field, string $value1, string $value2): bool {
            if ($value1 !== $value2) {
                $this->errors[$field] = "$field do not match";
                return false;
            }
            return true;
        }

        private function validateNumber(string $field, string $value): bool {
            if (!is_numeric($value) && $value>0) {
                $this->errors[$field] = "$field must be a positive number";
                return false;
            }
            return true;
        }

        private function validateMinLength(string $field, int $minLength, string $value): bool {
            if (strlen($value) < $minLength) {
                $this->errors[$field] = "$field must be at least $minLength characters long.";
                return false;
            }
            return true;
        }

        private function validateURL(string $field, string $value): bool {
            if (!filter_var($value, FILTER_VALIDATE_URL)) {
                $this->errors[$field] = "Invalid $field URL format.";
                return false;
            }
            return true;
        }

        public function validateRequiredField(string $field, $value): void {
            $this->validateRequired($field, $value);
        }

        public function validateEmail(string $field, string $value): void {
            $this->validateRequired($field, $value) && 
            $this->validateEmailFormat($field, $value);
        }

        public function validateCurrentPassword(string $field, string $value): void {
            $user=$this->userDB->fetchUserById($_SESSION['user']['id']);
            $match= password_verify($value, $user['password']);
            $this->validateRequired($field, $value) &&
            !$match ? $this->errors[$field] = "Password is incorrect." : true;            
        }

        public function validatePassword(string $field, string $value1, string $value2, int $minLength = 8): void {
            $this->validateRequired($field, $value1) && 
            $this->validateMinLength($field, $minLength, $value1) &&
            $this->validateRequired($field.'2', $value2) &&
            $this->validateMatch($field, $value1, $value2);
        }

        public function validatePhone(string $field, string $value): void {
            $this->validatePhoneFormat($field, $value);
        }

        public function validateNumberField(string $field, string $value): void {
            $this->validateRequired($field, $value) &&
            $this->validateNumber($field, $value);
            
        }

        public function validateURLField(string $field, string $value): void {
            $this->validateRequired($field, $value) &&
            $this->validateURL($field, $value);
        }


        public function getErrors(): array {
            return $this->errors;
        }

        public function hasErrors(): bool {
            return !empty($this->errors);
        }
    }

?>