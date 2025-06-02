<?php 
require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/connect.php'; // Підключення до бази даних


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

$httpClient = new Client([
    
    'timeout'  => 2.0,  
    'headers' => [
        'User-Agent' => 'GuzzleHttp/7.0',
    ]
]);


 $leftMenu = [
    "sweets" => "Солодощі",
    "sauces" => "Соуси і паста",
    "snacks" => "Снеки",
    "ramen" => "Рамен",
 ];


$selectedMenuL = null;

if (isset($_GET['leftchoise'])) {
    $selectedMenuL = $_GET['leftchoise'];

    // Якщо ключ не існує в меню — 404
    if (!array_key_exists($selectedMenuL, $leftMenu)) {
        http_response_code(404);
        echo "404 - Категорія не знайдена.";
        exit;
    }
}

 
 
?>

<!DOCTYPE html>
<html lang="uk">
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="./css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Spectral:wght@400;700&display=swap" rel="stylesheet">

</head>

<body>
    <div class="grid-container">
       <header>
    <div id="header-wrapper" style="display: flex; justify-content: space-between; align-items: center;">
       
        <div style="flex: 0;">
            <button id="open-cart" class="cart-button">🛒 Кошик (<span id="cart-count">0</span>)</button>
        </div>

         <div id="logo" style="flex: 1;">
            <img src="./img/logo-transparent-png.png" height="100">
            <p1>Київ, вулиця Хрещатик 38,<br>тц TSUM, 2 поверх, 01001</p1>
        </div>
    </div>

  
</header>




        <nav class="horizontal-menu">
            <ul>
                <li><strong><a href="./index.php">Home</a></strong></li>
                <li><a href="./about.html">About us</a></li>
                <li><a href="./contacts.html">Contacts</a></li>
            </ul>
        </nav>
        
        <aside id="left-menu">
            <h2>Каталог</h2>

            <?php if ( isset($leftMenu) && is_array($leftMenu)) : ?>
                <ul>
                    <?php foreach ($leftMenu as $key => $value) : ?>
                        <li><a href="?leftchoise=<?= $key ?>"><?= htmlspecialchars($value) ?></a></li>
                    <?php endforeach; ?>
                </ul>
           <?php else : ?>
                <p>Каталог порожній</p>
            <?php endif; ?>

        </aside>


        <main>
           <?php
                    if (null !== $selectedMenuL) {
                        // Якщо вибрана категорія, показуємо її назву
                        echo '<h2>' . htmlspecialchars($leftMenu[$selectedMenuL]) . '</h2>';
                    } elseif (!empty($_GET['search'])) {
                        // Якщо пошук є, але категорія — ні
                        echo '<h2>Результати пошуку: "' . htmlspecialchars($_GET['search']) . '"</h2>';
                    } else {
                        // За замовчуванням
                        echo '<h1>Ласкаво просимо до Rameniolla!</h1>';
                    }
            ?>



        <form method="GET" action="" id="search-form" style="position: relative;">
    <input type="text" id="search-input" name="search" autocomplete="off" placeholder="Пошук товарів..."> <br>
    <div id="autocomplete-list" class="autocomplete-items"></div>
    <button type="submit">🔍</button>
     </form>





<div id="autocomplete-list" class="autocomplete-items"></div>

 
            
        <?php

        
$query = "SELECT * FROM products";
$params = [];

if ($selectedMenuL !== null) {
    $query .= " WHERE category = ?";
    $params[] = $selectedMenuL;
}

if (!empty($_GET['search'])) {
    $searchTerm = '%' . $_GET['search'] . '%';
    if ($selectedMenuL !== null) {
        $query .= " AND title LIKE ?";
    } else {
        $query .= " WHERE title LIKE ?";
    }
    $params[] = $searchTerm;
}



$stmt = $pdo->prepare($query);
$stmt->execute($params);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div id="catalog">
    <?php if ($items): ?>
        <?php foreach ($items as $item): ?>
            <div class="item">
                <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" height="100">
                <div class="item-info">
                    <div class="item-title"><?= htmlspecialchars($item['title']) ?></div>
                    <div class="item-description"><?= htmlspecialchars($item['description']) ?></div>
                    <div class="item-price">Ціна: <span><?= htmlspecialchars($item['price']) ?> грн</span></div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Нічого не знайдено.</p>
    <?php endif; ?>
</div>

            
            
        </main>



        <footer>
            <p>© 2025 Rameniolla</p>

        </footer>


          <div id = "modal">
             <img id = "modal-image" >
             <div id = "modal-label"> </div>
             <button id = "close"> X </button>
                  
          </div>
          
          <!--  вікно кошика -->
            <div id="cart-modal" class="modal">
                <div class="modal-content">
                <h2>Кошик</h2>
                <div id="cart-items"></div>
                <p><strong>Загальна сума: <span id="cart-total">0</span> грн</strong></p>
                <button id="close-cart">Закрити</button>
                </div>
            </div>
  

    </div>

    <script src="./js/script.js"></script>



</body>

</html>