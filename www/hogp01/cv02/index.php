<?php
require 'classes/Person.php';


$persons = array(new Person(
    "https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.pngmart.com%2Ffiles%2F21%2FAdmin-Profile-PNG-Clipart.png&f=1&nofb=1&ipt=b8007091a8c5a9ff0e0f2b21c3496e008afa90088db4b52b7a3b3a19af86f195&ipo=images",
    "Jan",
    "Novak",
    new DateTime("12-02-2004"),
    "UX Designer",
    "UX s.r.o",
    "Bulharská",
    "18600",
    "29",
    "Praha",
    "772 289 839",
    "jan.novak@gmail.com",
    "https://novak.com",
    true
),
new Person(
    "https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.pngmart.com%2Ffiles%2F21%2FAdmin-Profile-PNG-Clipart.png&f=1&nofb=1&ipt=b8007091a8c5a9ff0e0f2b21c3496e008afa90088db4b52b7a3b3a19af86f195&ipo=images",
    "Magda",
    "Novakova",
    new DateTime("12-05-2000"),
    "Backend Developer",
    "Backend s.r.o",
    "Národní obrany",
    "13400",
    "7",
    "Praha",
    "897 567 478",
    "magda.novakova@gmail.com",
    "https://novakova.cz",
    false
),
new Person(
    "https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.pngmart.com%2Ffiles%2F21%2FAdmin-Profile-PNG-Clipart.png&f=1&nofb=1&ipt=b8007091a8c5a9ff0e0f2b21c3496e008afa90088db4b52b7a3b3a19af86f195&ipo=images",
    "Jindřich",
    "Kalvoda",
    new DateTime("01-10-1998"),
    "Data Analyst",
    "Analyst s.r.o",
    "Nebušická",
    "10400",
    "69",
    "Praha",
    "532 674 632",
    "jindra.kalvoda@gmail.com",
    "https://kalvoda.cz",
    false
)

);

?>
<?php include 'src/header.php'; ?>
    <div class="wrapper">
        <?php include 'src/business_card.php'; ?>
    </div>
<?php include 'src/footer.php';?>