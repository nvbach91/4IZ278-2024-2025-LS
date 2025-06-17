<?php
// sp/database/db-config.php

const DB_SERVER_URL = 'localhost';
const DB_USERNAME   = 'lugp00';
const DB_PASSWORD   = '';
const DB_DATABASE   = 'lugp00';

// Seznam e-mailů administrátorů
const ADMIN_USERS = [
    'admin@admin.com',
    'admin2@admin.com'
];

// Google OAuth2
const GOOGLE_CLIENT_ID     = '';
const GOOGLE_CLIENT_SECRET = '';
// Přesměrovací URL musí být zaregistrovaná v Google API Console
const GOOGLE_REDIRECT_URI  = 'https://eso.vse.cz/~lugp00/sp/google_callback.php';