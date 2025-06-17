<?php
require_once __DIR__ . '/../functions/php/checkoutHelpers.php';
require_once __DIR__ . '/layouts/head.php';
?>
<div class="container mt-5" style="max-width: 900px;">
    <h2 class="mb-4">Objednávka</h2>
    <?php if (!empty($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>
    <form method="post" action="../functions/php/checkoutProcess.php" novalidate>
        <!-- Zvol dopravu -->
        <div class="mb-4 p-3 checkout-box">
            <strong>Zvol dopravu</strong>
            <select class="form-select mt-2" name="shipping_method" required>
                <option value="" disabled selected>Vyber dopravu...</option>
                <?php foreach ($dopravy as $key => $name): ?>
                    <option value="<?= $key ?>"><?= $name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <!-- Zvol možnost platby -->
        <div class="mb-4 p-3 checkout-box">
            <strong>Zvol možnost platby</strong>
            <select class="form-select mt-2" name="payment_method" required>
                <option value="" disabled selected>Vyber platbu...</option>
                <?php foreach ($platby as $key => $name): ?>
                    <option value="<?= $key ?>"><?= $name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="row">
            <!-- Fakturační údaje -->
            <div class="col-md-6">
                <div class="p-3 checkout-box">
                    <strong>Fakturační údaje</strong>
                    <div class="mb-2 mt-3">
                        <label for="shipping_name" class="form-label">Jméno a příjmení</label>
                        <input type="text" class="form-control" id="shipping_name" name="shipping_name"
                            pattern=".{3,}" title="Zadejte jméno a příjmení (alespoň 3 znaky)." value="<?= $shipping_name ?>" required>
                    </div>
                    <div class="mb-2">
                        <label for="shipping_street" class="form-label">Ulice a číslo popisné</label>
                        <input type="text" class="form-control" id="shipping_street" name="shipping_street"
                            pattern=".{3,}" title="Zadejte ulici a číslo popisné (alespoň 3 znaky)." value="<?= $shipping_street ?>" required>
                    </div>
                    <div class="mb-2">
                        <label for="shipping_postal_code" class="form-label">PSČ</label>
                        <input type="text" class="form-control" id="shipping_postal_code" name="shipping_postal_code"
                            pattern="^\d{3}\s?\d{2}$" title="Zadejte platné PSČ (např. 11000 nebo 110 00)" value="<?= $shipping_postal_code ?>" required>
                    </div>
                    <div class="mb-2">
                        <label for="shipping_city" class="form-label">Město</label>
                        <input type="text" class="form-control" id="shipping_city" name="shipping_city"
                            pattern=".{2,}" title="Zadejte město (alespoň 2 znaky)." value="<?= $shipping_city ?>" required>
                    </div>
                    <div class="mb-2">
                        <label for="shipping_phone" class="form-label">Telefon</label>
                        <input type="tel" class="form-control" id="shipping_phone" name="shipping_phone"
                            pattern="^\d{9}$" title="Zadejte telefon ve tvaru 123456789 (9 číslic bez mezer)" value="<?= $shipping_phone ?>" required>
                    </div>
                </div>
            </div>
            <!-- Email a souhlasy -->
            <div class="col-md-6">
                <div class="p-3 checkout-box">
                    <strong>Emailová adresa a souhlasy</strong>
                    <div class="mb-2 mt-3">
                        <label for="user_email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="user_email" name="user_email"
                            value="<?= $user_email ?>" required>
                    </div>
                    <div class="form-check mt-4">
                        <input class="form-check-input" type="checkbox" name="agreement" id="agreement" required>
                        <label class="form-check-label" for="agreement">
                            Souhlasím se zpracováním osobních údajů a obchodními podmínkami
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <!-- Potvrdit objednávku -->
        <div class="text-center mt-5">
            <button type="submit" class="btn btn-success btn-lg">Odeslat objednávku</button>
        </div>
    </form>
</div>
<?php require_once __DIR__ . '/layouts/footer.php'; ?>
