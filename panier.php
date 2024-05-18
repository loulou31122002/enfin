<?php 
session_start();
require("configurations/connexion.php");  
require("configurations/constructions.php"); 
$voiture = afficher(); 

// Supprimer les produits
if (isset($_GET['del'])) {
    $id_del = $_GET['del'];
    unset($_SESSION['panier'][$id_del]);

    // Redirection pour actualiser la page
    header('Location: panier.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Location de voitures | astro</title>
<link href="documents/img/logo_accueil.png" rel="icon" />
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="style.css">
<style>
    .btn:first-child {
        margin-right: 10px; 
    }
</style>
</head>
<body class="panier">
    <a href="index.php" class="link">Boutique</a>
    <section>
        <table>
            <tr>
                <th></th>
                <th>Modèle</th>
                <th>Prix</th>
                <th>Supprimer</th> 
                <th>Réserver</th>
            </tr>
            <?php   
            $total = 0;
            // Liste des produits 
            $ids = array_keys($_SESSION['panier']); 
            if (empty($ids)) { 
                echo "Votre panier est vide !";
            } else { 
                // Si oui 
                $query = "SELECT * FROM voiture WHERE idv IN (" . implode(',', array_map('intval', $ids)) . ")";
                $stmt = $access->query($query);
                $voitures = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Lister les produits
                foreach ($voitures as $v):  
                 // Ajouter le prix de chaque voiture au total
                 $total += $v['prix']; 
            ?>
            <tr>
                <td><img src="<?= htmlspecialchars($v['image']) ?>" alt="Image de voiture"></td>
                <td><?= htmlspecialchars($v['modèle']); ?></td>
                <td><?= htmlspecialchars($v['prix']); ?></td>
                <td><a href="panier.php?del=<?= htmlspecialchars($v['idv']); ?>"><img src="delete.png" alt="Supprimer"></a></td>
                <td><a href="ajout_panier.php?idv=<?= htmlspecialchars($v['idv']); ?>" class="btn btn-primary">Réserver</a></td>
            </tr>
            <?php endforeach; } ?> 
            <tr class="total"> 
                <th>Total : <?=$total?></th>
            </tr>
        </table>
    </section>
</body>
</html>
