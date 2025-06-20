<?php include __DIR__.'/../prefix.php'; ?>
<?php require_once __DIR__ . '/Logger.php'; ?>
<?php

class Email
{
    private $headers;
    private $url;
    private $log;

    public function __construct(){
        global $urlPrefix;
        $this->headers =
            "MIME-Version: 1.0\r\n" .
            "From: vrat03@vse.cz\r\n" .
            "Reply-To: vrat03@vse.cz\r\n" .
            "Content-Type: text/html; charset=UTF-8\r\n" .
            "X-Mailer: PHP/" . phpversion();
        $this->url = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . '://' . $_SERVER['HTTP_HOST'] . $urlPrefix;
        $this->log = AppLogger::getLogger();
    }

    private function sendMail($email, $subject, $message){
        return mail($email, $subject, $message, $this->headers);
    }

    private function isEsoUsed(){
        return preg_match('/eso.vse\.cz$/i', $_SERVER['HTTP_HOST']);    
    }

    private function isEmailInVseDomain($email){
        return preg_match('/@vse\.cz$/i', $email);
    }

    public function sendRegistrationSuccess(int $userId, string $name, string $email, string $phone, string $address){
        if (!$this->isEsoUsed() || !$this->isEmailInVseDomain($email)) {
            $type = "debug";
            $title  = "Registration email not sent due to domain restrictions";
        } else {
            $url=$this->url;
            $subject = "Registration was successful";
            $message = "
                <html>
                    <head>
                        <title>Registration Successful</title>
                    </head>
                    <body>
                        <h1>Welcome, $name!</h1>
                        <p>Registration on <a href=".$url.">Tom's shop</a> was successful!</p>
                        <p>Here are the details you entered:</p>
                        <ul>
                            <li>Name: $name</li>
                            <li>Email: $email</li>
                            <li>Phone number: $phone</li>
                            <li>Address: $address</li>
                        </ul>
                        <p>You can now <a href='".$url."/login.php'>log in</a> to your account and start shopping.</p>
                    </body>
                </html>
            ";
            if($this->sendMail($email, $subject, $message)){
                $type = "info";
                $title  = "Registration email sent";
            } else {
                $type = "error";
                $title  = "Failed to send registration email";
            }
        }
        $this->log->$type($title, [
            'user_id' => $userId,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address
        ]);
        return;
    }

    public function sendGoogleRegistrationSuccess(int $userId, string $name, string $email){
        if (!$this->isEsoUsed() || !$this->isEmailInVseDomain($email)) {
            $type = "debug";
            $title  = "Google registration email not sent due to domain restrictions";
        } else {
            $url=$this->url;
            $subject = "Google Registration Successful";
            $message = "
                <html>
                    <head>
                        <title>Google Registration Successful</title>
                    </head>
                    <body>
                        <h1>Welcome, $name!</h1>
                        <p>Registration on <a href=".$url.">Tom's shop</a> was successful!</p>
                        <p>Please complete your <a href='".$url."/account.php'>account details</a>.</p>
                    </body>
                </html>
            ";
            if ($this->sendMail($email, $subject, $message)){
                $type = "info";
                $title  = "Google registration email sent";
            } else {
                $type = "error";
                $title  = "Failed to send Google registration email";
            }
        }
        $this->log->$type($title, [
            'user_id' => $userId,
            'name' => $name,
            'email' => $email
        ]);
        return;
    }

    public function sendOrderSuccess(int $orderId){
        if (!$this->isEsoUsed()  || !$this->isEmailInVseDomain($_SESSION['user']['email'])) {
            $type = "debug";
            $title  = "Order confirmation email not sent due to domain restrictions";
        } else {
            $url=$this->url;
            $subject = "Order Confirmation";
            $message = "
                <html>
                    <head>
                        <title>Order Confirmation</title>
                    </head>
                    <body>
                        <h1>Your order has been successfully placed!</h1>
                        <p>Thank you for shopping at <a href=".$url.">Tom's shop</a>.</p>
                        <p>Your order ID is: <strong>$orderId</strong></p>
                        <p>You can view your order details in <a href='".$url."/order-items.php?id=".$orderId."'>your account.</a></p>
                    </body>
                </html>
            ";
            if ($this->sendMail($_SESSION['user']['email'], $subject, $message)){
                $type = "info";
                $title  = "Order confirmation email sent";
            } else {
                $type = "error";
                $title  = "Failed to send order confirmation email";
            }
        }    
        $this->log->$type($title, [
            'email' => $_SESSION['user']['email'],
            'order_id' => $orderId
        ]);
        return;
    }

    public function sendOrderStatusChange(int $orderId, int $status, string $email){
        $statusText = $status ? 'completed' : 'pending';
        if (!$this->isEsoUsed()  || !$this->isEmailInVseDomain($email)) {
            $type = "debug";
            $title  = "Order status change email not sent due to domain restrictions";
        } else {
            $url=$this->url;
            $subject = "Order Status Update";
            $message = "
                <html>
                    <head>
                        <title>Order Status Update</title>
                    </head>
                    <body>
                        <h1>Your order status has been updated!</h1>
                        <p>Your order ID: <strong>$orderId</strong> is now marked as <strong>$statusText</strong>.</p>
                        <p>You can view your order details in <a href='".$url."/account-history.php'>your account.</a></p>
                    </body>
                </html>
            ";
            if ($this->sendMail($email, $subject, $message)) {
                $type = "info";
                $title  = "Order status change email sent";
            } else {
                $type = "error";
                $title  = "Failed to send order status change email";
            }
        }
        $this->log->$type($title, [
                'email' => $email,
                'order_id' => $orderId,
                'status' => $statusText
            ]);
        return;
    }

    public function sendPasswordReset(string $email, string $resetLink){
        if (!$this->isEsoUsed() || !$this->isEmailInVseDomain($email)) {
            $type = "debug";
            $title  = "Password reset email not sent due to domain restrictions";
            $return = false;
        } else {
            $url=$this->url;
            $subject = "Password Reset Request";
            $message = "
                <html>
                    <head>
                        <title>Password Reset Request</title>
                    </head>
                    <body>
                        <h1>Password Reset Request</h1>
                        <p>We received a request to reset your password on <a href=".$url.">Tom's shop</a>.</p>
                        <p>If you did not make this request, please ignore this email.</p>
                        <p>To reset your password, please click the link below:</p>
                        <p><a href=".$url."/".$resetLink.">Reset Password</a></p>
                    </body>
                </html>
            ";
            if ($this->sendMail($email, $subject, $message)){
                $type = "info";
                $title  = "Password reset email sent";
                $return = true;
            } else {
                $type = "error";
                $title  = "Failed to send password reset email";
                $return = false;
            }
        }
        $this->log->$type($title, [
            'email' => $email
        ]);
        return $return;
    }
}