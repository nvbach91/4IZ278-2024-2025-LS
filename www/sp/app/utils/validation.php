<?php

/**
 * Checks whether any fields are missing values.
 * 
 * @param array $data An array of data to be checked.
 * @return bool True if no fields are empty.
 */
function fieldsNotEmpty(array $data) {
    foreach ($data as $datum) {
        if (empty($datum)){
            return false;
        }
    }
    return true;
}

/**
 * Checks that an email value is in the correct format.
 * 
 * @param string $email The email to be checked.
 * @return bool True on correct.
 */
function validateEmailFormat($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}

/**
 * Checks that the email's domain is in the whitelist.
 * 
 * @param string $email The email to be checked.
 * @return bool True if permitted.
 */
function validateDomain(string $email): bool {
    $domain = substr(strrchr($email, '@'), 1);
    $permittedDomains = require __DIR__ . "/../../config/mail_whitelist.php";

    if (in_array($domain, $permittedDomains)) {
        return true;
    }
    return false;
}




?>