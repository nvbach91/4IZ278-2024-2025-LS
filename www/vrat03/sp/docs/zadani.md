# Semestrální projekt – E-shop s deskovými hrami

## Stručný popis aplikace

Webová aplikace umožňuje uživatelům procházet nabídku deskových her, přidávat je do košíku, provádět objednávky a spravovat svůj účet. Správce může přidávat a upravovat produkty.

Data pro eshop budou získána z webu [boardgamegeek.com](https://boardgamegeek.com) pomocí dostupného [API](https://boardgamegeek.com/wiki/page/BGG_XML_API2). (Data získaná pomocí API budou uložena do databáze na eso.vse.cz)

---

## Popis funkcionalit

- Registrace, přihlášení, odhlášení uživatele
- Zapamatování přihlášení pomocí cookies
- Výpis produktů (deskové hry)
- Detail produktu
- Přidávání do košíku, úprava množství
- Potvrzení objednávky
- Historie objednávek
- Administrace produktů (přidání, úprava, smazání)
- Validace vstupních dat
- Zabezpečení (hashování hesel, ochrana proti SQL injection)

---

## Use Case diagram



---

## Wireframe & výčet stránek

| Stránka                        | Popis                                      |
|--------------------------------|--------------------------------------------|
| `/index.php`                   | Úvodní stránka s výpisem produktů          |
| `/product.php`                 | Detail produktu                            |
| `/login.php`                   | Přihlášení                                 |
| `/register.php`                | Registrace                                 |
| `/cart.php`                    | Nákupní košík                              |
| `/checkout.php`                | Potvrzení objednávky                       |
| `/account.php`                 | Uživatelský profil, možnost změny údajů    |
| `/account-history.php`         | Historie objednávek                        |
| `/admin/edit-items.php`        | Administrace produktů                      |
| `/admin/edit-item.php`         | Editace konkrétního produktu               |
| `/admin/add-item.php`          | Přidání nového produktu                    |
| `/admin/categories.php`        | Zobrazení všech egorií                     |
| `/admin/add-category.php`      | Přidání kategorie                          |
| `/admin/order-history.php`     | Přehled všech objednávek                   |
| `/admin/users.php`             | Přehled všech uživatelů, možnost změny přístupových práv |

---

## Architektura

- **Webový server**: Apache
- **Back-end**: PHP 8+
- **Databáze**: MySQL
- **Front-end**: HTML, CSS, Bootstrap, JavaScript
- **Komunikace**: Požadavek klienta &rarr; PHP server požadavek zpracuje, získá data z databáze pomocí rozhraní PDO &rarr; Klientovi se vrací čisté HTML

---

## Návrh databáze

### Logický model

- **eshop_users** (user_id, name, email, phone, adress, password, privilege)
- **eshop_products** (product_id, name, price, img, img_thumb, quantity, description, minplayers, maxplayers, playtime)
- **eshop_categories** (category_id, name)
- **eshop_product_category** (product_id, category_id)
- **eshop_orders** (order_id, date, discount, user_id)
- **eshop_order_items** (order_item_id, quantity, price, product_id, order_id)


### Fyzický model

---

## Procesní diagram

## Sekvenční diagram