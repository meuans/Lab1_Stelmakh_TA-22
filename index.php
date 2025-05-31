<?php 
require __DIR__ . '/vendor/autoload.php';

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
 } 
 if (!array_key_exists($selectedMenuL, $leftMenu)) {
    $selectedMenuL = null;
        header("HTTP/1.1 404 Not Found");
        echo "404 not found";
        exit;
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
            <!-- <h1>Rameniolla</h1> -->
            <div id="logo">
                <img src="./img/logo-transparent-png.png" height="120">
                <p1>Київ, вулиця Хрещатик 38,<br>
                    тц TSUM, 2 поверх, 01001</p1>
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
            <?php if (null !== $selectedMenuL) : ?>
                <h1><?= htmlspecialchars($leftMenu[$_GET['leftchoise']]) ?></h1>
            <?php else : ?>
                <h1>Ласкаво просимо до Rameniolla!</h1>
            <?php endif; ?>
            
            <div class="main-content">
                <h2> Пропозиції дня</h2>
                <p> <br> Локшина, рамени, токпоккі, супи <br> <br> </p>
                <button id="open-cart" class="cart-button">🛒 Кошик (<span id="cart-count">0</span>)</button>
                <br> <br>
            </div>
            
            
            <div id="catalog">

                <div class="item">
                    <img src="./img/sticker1.webp" alt="Shim Shin Ramyun" height="120">

                    <div class="item-info">
                        <div class="item-title">Shim Shin Ramyun</div>
                        <div class="item-description">120г</div>
                        <div class="item-price">Ціна: <span>99.9 грн</span></div>
                    </div>

                </div>

                <div class="item">
                    <img src="./img/sticker2.webp" alt="Samyang 2X Spicy Hot" height="100">
                    <div class="item-info">
                        <div class="item-title">Samyang 2X Spicy Hot</div>
                        <div class="item-description">140г</div>
                        <div class="item-price">Ціна: <span>160 грн</span></div>
                    </div>
                </div>


                <div class="item">
                    <img src="./img/sticker3.webp" alt="Samyang Original Instant Ramen" height="100">
                    <div class="item-info">
                        <div class="item-title">Samyang Original Instant Ramen</div>
                        <div class="item-description">120г</div>
                        <div class="item-price">Ціна: <span>150 грн</span></div>
                    </div>
                </div>


                <div class="item">
                    <img src="./img/sticker4.webp" alt="NongShim Nudelsuppe" height="100">
                    <div class="item-info">
                        <div class="item-title">NongShim Nudelsuppe</div>
                        <div class="item-description">120г</div>
                        <div class="item-price">Ціна: <span>199 грн</span></div>
                    </div>
                </div>


                <div class="item">
                    <img src="./img/sticker5.webp" alt="Samyang Buldak Cheese Ramen Hot" height="100">
                    <div class="item-info">
                        <div class="item-title">Samyang Buldak Cheese Ramen Hot</div>
                        <div class="item-description">140г</div>
                        <div class="item-price">Ціна: <span>170 грн</span></div>
                    </div>
                </div>



                <div class="item">
                    <img src="./img/sticker6.webp" alt="Samyang Hot Chicken Ramen" height="100">
                    <div class="item-info">
                        <div class="item-title">Samyang Hot Chicken Ramen</div>
                        <div class="item-description">105г</div>
                        <div class="item-price">Ціна: <span>120 грн</span></div>
                    </div>
                </div>


                <div class="item">
                    <img src="./img/sticker7.webp" alt="Samyang Buldak Carbonara Ramen Hot" height="100">
                    <div class="item-info">
                        <div class="item-title">Samyang Buldak Carbonara Ramen Hot</div>
                        <div class="item-description">140г</div>
                        <div class="item-price">Ціна: <span>170 грн</span></div>
                    </div>
                </div>

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