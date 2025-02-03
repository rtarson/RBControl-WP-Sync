<?php

class RB_Control_Sync_MSSQL {

    private $server;
    private $username;
    private $password;
    private $database;
    private $ignore_ssl;
    private $encryption_key;

    public function __construct() {
        // Get the encryption key from the WordPress options table
        $this->encryption_key = get_option('rbcs_encryption_key', 'default_key');
        
        // Get the MS SQL connection details from the WordPress options table
        $this->server = get_option('rbcs_mssql_host');
        $this->username = get_option('rbcs_mssql_user');
        $this->password = $this->decrypt(get_option('rbcs_mssql_password'));
        $this->database = get_option('rbcs_mssql_database');
        $this->ignore_ssl = get_option('rbcs_ignore_ssl', false);
    }

    public function connect() {
        // Connect to the MS SQL database using SQLSRV
        $connectionInfo = array(
            "Database" => $this->database,
            "UID" => $this->username,
            "PWD" => $this->password
        );

        if ($this->ignore_ssl) {
            $connectionInfo["TrustServerCertificate"] = true;
        }

        // Debugging: Log the decrypted password
        error_log('Decrypted password: ' . $this->password);

        $conn = sqlsrv_connect($this->server, $connectionInfo);

        if ($conn === false) {
            $this->log_connection_attempt('SQLSRV connection error: ' . print_r(sqlsrv_errors(), true));
            throw new Exception('SQLSRV connection error');
        }

        $this->log_connection_attempt('SQLSRV connection successful.');
        return $conn;
    }

    public function find_customer_by_phone($phone_number) {
        // Strip out any special characters and spaces from the phone number
        $phone_number = preg_replace('/[^0-9]/', '', $phone_number);

        // Connect to the MS SQL database
        $conn = $this->connect();

        // Prepare the SQL query to find the customer by phone number
        $sql = "SELECT CustId FROM dbo.Customers WHERE REPLACE(Phone1, '-', '') = ? OR REPLACE(Phone2, '-', '') = ? OR REPLACE(Phone3, '-', '') = ?";
        $params = array($phone_number, $phone_number, $phone_number);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            $this->log_connection_attempt('SQLSRV query error: ' . print_r(sqlsrv_errors(), true));
            throw new Exception('SQLSRV query error');
        }

        // Fetch the customer ID
        $customer_id = null;
        if (sqlsrv_fetch($stmt)) {
            $customer_id = sqlsrv_get_field($stmt, 0);
        }

        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);

        return $customer_id;
    }

    private function decrypt($data) {
        // Decrypt the data using the encryption key
        $encryption_key = $this->encryption_key;
        error_log('Encryption key used for decryption: ' . $encryption_key);
        $parts = explode('::', base64_decode($data), 2);
        if (count($parts) !== 2) {
            error_log('Decryption failed - invalid data format');
            return false;
        }
        list($encrypted_data, $iv) = $parts;
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    }

    private function log_connection_attempt($message) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'rbcs_logs';
        $encrypted_message = $this->encrypt($message);
        $wpdb->insert(
            $table_name,
            array(
                'time' => current_time('mysql'),
                'query' => $encrypted_message
            )
        );
    }

    private function encrypt($data) {
        $encryption_key = $this->encryption_key;
        error_log('Encryption key used for encryption: ' . $encryption_key);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }
}