<?php 
  session_start();
  require("configurations/constructions.php"); 
  $voiture = afficher();

  ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique</title> 
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="ps.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #04202e;
            color: #fff;
        }
        .product-card {
            background-color: #fff;
            color: #000;
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            transition: transform 0.3s;
        }
        .product-card:hover {
            transform: scale(1.05);
        }
        .product-image {
            height: 200px;
            object-fit: cover;
        }
        .product-content {
            padding: 20px;
        }
        .product-title, .product-description, .product-price {
            margin-bottom: 15px;
        }
    </style>
</head>
<body> 
<a href="panier.php" class="link">Panier<span><?= array_sum($_SESSION['panier'])?></span></a>

<div class="container my-5">
        <h1 class="text-center mb-5">Nos voitures</h1>
        <div class="row g-4">
            <?php foreach($voiture as $v): ?> 
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="product-card">
                    <div class="image_voiture">  
                        <img src="<?= htmlspecialchars($v->image) ?>" class="img-fluid product-image">
                    </div> 
                    <div class="product-content"> 
                        <h5 class="product-title"><?= htmlspecialchars($v->modèle); ?></h5> 
                        <p class="product-description"><?= htmlspecialchars($v->description); ?></p>
                        <p class="product-price"><?= htmlspecialchars($v->prix); ?> Dt/J</p> 
                        <a href="ajout_panier.php?idv=<?= htmlspecialchars($v->idv);?>" class="id_voiture">Ajouter au panier</a>
           
                    </div>
                </div>
            </div> 
            
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 
