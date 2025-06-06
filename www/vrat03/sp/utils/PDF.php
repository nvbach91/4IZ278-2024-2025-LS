<?php require_once __DIR__ . '/../vendor/autoload.php'; ?>
<?php require_once __DIR__ . '/../database/OrderItemsDB.php'; ?>
<?php require_once __DIR__ . '/../database/OrdersDB.php'; ?>
<?php
use Dompdf\Dompdf;

class PDF{
    private static ?dompdf $dompdf = null;
    private static ?OrderItemsDB $orderItemsDB = null;
    private static ?OrdersDB $ordersDB = null;

    public function __construct(){
        if (self::$dompdf === null) {
            self::$dompdf = new dompdf();
        }
        if (self::$orderItemsDB === null) {
            self::$orderItemsDB = new OrderItemsDB();
        }
        if (self::$ordersDB === null) {
            self::$ordersDB = new OrdersDB();
        }
    }

    private static function loadHtml($html){
        self::$dompdf->loadHtml($html);
    }

    private static function setPaper($size = 'A4', $orientation = 'portrait'){
        self::$dompdf->setPaper($size, $orientation);
    }

    private static function render(){
        self::$dompdf->render();
    }

    private static function saveOutput(string $orderId, string $path = __DIR__ . '/../invoices'){
        $pdfOutput = self::$dompdf->output();
        $outputPath = $path . '/order_' . $orderId . '.pdf';
        file_put_contents($outputPath, $pdfOutput);
    }

    private static function createPDF(string $html, string $orderId, $size = 'A4', $orientation = 'portrait', string $path = __DIR__ . '/../invoices'){
        $pdf = new PDF();
        $pdf->loadHtml($html);
        $pdf->setPaper($size, $orientation);
        $pdf->render();
        $pdf->saveOutput($orderId, $path);
    }

    public static function generateInvoice(
        string $userName,
        string $userAddress,
        string $userPhone,
        string $userEmail,
        string $orderId,
        $size = 'A4',
        $orientation = 'portrait',
        string $path = __DIR__ . '/../invoices'
    ) {
        $total = 0;
        $itemsHtml = '';
        $orderItems = self::$orderItemsDB->getItemsNamesByOrderId($orderId);
        $order = self::$ordersDB->getOrderByOrderId($orderId);

        foreach ($orderItems as $item) {
            $productName = htmlspecialchars($item['name']);
            $unitPrice = number_format($item['price'], 2);
            $quantity = (int)$item['quantity'];
            $itemTotal = $item['price'] * $quantity;
            $total += $itemTotal;

            $itemsHtml .= "
            <tr>
                <td>{$productName}</td>
                <td class='right'>{$unitPrice} CZK</td>
                <td class='right'>{$quantity}</td>
                <td class='right'>" . number_format($itemTotal, 2) . " CZK</td>
            </tr>";
        }

        $html = "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
            <meta charset='UTF-8'>
            <title>Invoice</title>
            <style>
                body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
                h1 { text-align: center; }
                .addresses { display: flex; justify-content: space-between; margin-bottom: 20px; }
                .box { width: 45%; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #000; padding: 6px; text-align: left; }
                th { background-color: #eee; }
                .right { text-align: right; }
                .order-info { margin-bottom: 10px; text-align: center; }
            </style>
            </head>
            <body>

            <h1>Invoice No.". htmlspecialchars($order['order_id']) ."</h1>
            <div class='order-info'>
                <strong>Order date:</strong> " . htmlspecialchars($order['date']) . "
            </div>

            <div class='addresses'>
            <div class='box'>
                <strong>Seller:</strong><br>
                Tom's games Ltd.<br>
                123 Street Name<br>
                100 00 Prague<br>
                Company ID: 12345678<br>
                VAT ID: CZ12345678<br>
            </div>
            <div class='box'>
                <strong>Billing Address:</strong><br>"
                . htmlspecialchars($userName) . "<br>"
                . htmlspecialchars($userAddress) . "<br>"
                . (!empty($userPhone) ? htmlspecialchars($userPhone) . "<br>" : '')
                . htmlspecialchars($userEmail) . "
            </div>
            </div>

            <table>
            <thead>
                <tr>
                <th>Product</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Total</th>
                </tr>
            </thead>
            <tbody>
                {".$itemsHtml."}
            </tbody>
            <tfoot>
                <tr>
                <td colspan='3' class='right'><strong>Total Amount</strong></td>
                <td class='right'><strong>" . number_format($total, 2) . " CZK</strong></td>
                </tr>
            </tfoot>
            </table>

            <p>Thank you for your purchase!</p>

            </body>
            </html>";

        self::createPDF($html, $orderId, $size, $orientation, $path);
    }
}

?>