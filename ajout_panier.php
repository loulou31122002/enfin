<?php  
session_start();
require("configurations/connexion.php");   
require("configurations/constructions.php");  

// vérifier si une session existe 
if (!isset($_SESSION)) { 
    // sinon on démarre la session 
    session_start();
} 

// créer la session 
if (!isset($_SESSION['panier'])) { 
    // s'il n'existe pas une session on crée 1 et on met 1 tab à l'intérieur
    $_SESSION['panier'] = array();
} 

// récupération de l'id dans le lien 
if (isset($_GET['idv'])) { 
    // si un id a été envoyé alors :
    $idv = $_GET['idv']; 

    // vérifier grâce à l'id si le produit existe dans la bd 
    $stmt = $access->prepare("SELECT * FROM voiture WHERE idv = :idv");
    $stmt->execute(['idv' => $idv]);
    $voiture = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($voiture)) { 
        // si ce produit n'existe pas 
        die("Ce produit n'existe pas");
    }

    // ajouter le produit dans le panier (le tableau)
    if (isset($_SESSION['panier'][$idv])) { 
        // si le produit existe déjà dans le panier 
        $_SESSION['panier'][$idv]++; // représenter la quantité 
    } else { 
        // sinon on ajoute le produit 
        $_SESSION['panier'][$idv] = 1;
    }

   
}


// Récupération de la voiture pour l'affichage
if (isset($_GET['id'])) {
    $idv = $_GET['id'];

    // Rechercher les informations de la voiture correspondante
    $stmt = $access->prepare("SELECT * FROM voiture WHERE idv = :idv");
    $stmt->execute(['idv' => $idv]);
    $voiture = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Traitement du formulaire de réservation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['date_debut'], $_POST['date_fin'], $_POST['mode_paiement'])) {
        $date_debut = htmlspecialchars(strip_tags($_POST['date_debut']));
        $date_fin = htmlspecialchars(strip_tags($_POST['date_fin'])); 
        $mode_paiement = htmlspecialchars(strip_tags($_POST['mode_paiement'])); 

        // Ajout de la réservation
        $reservation = ajouterR($date_debut, $date_fin, $mode_paiement, $idv);

        if ($reservation) {
            header('Location: confirmation_reservation.php');
            exit();
        } else {
            $error = "Erreur lors de la réservation.";
        }
    } else {
        $error = "Tous les champs du formulaire doivent être remplis.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation de Voiture</title>
    <!-- Liens vers Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Vos styles personnalisés -->
    <style>
        body {
            background-color: #f8f9fa;
            color: #212529;
        }
        .reservation-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            padding: 20px;
            margin-bottom: 20px;
        }
        .btn-reserver {
            background-color: #007bff;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-5">Réservation de Voiture</h1>
        <div class="row">
            <div class="col-md-6">  
                <div class="reservation-card"> 
                    <?php if ($voiture): ?>
                        <h2><?= htmlspecialchars($voiture['modèle']); ?></h2>
                        <p><?= htmlspecialchars($voiture['description']); ?></p>
                        <p><strong>Prix par jour:</strong> <?= htmlspecialchars($voiture['prix']); ?> Dt</p>
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
                        <?php endif; ?>
                        <form action="ajout_panier.php?id=<?= htmlspecialchars($idv); ?>" method="POST">
                            <input type="hidden" name="voiture_id" value="<?= htmlspecialchars($voiture['idv']); ?>">
                            <div class="mb-3">
                                <label for="date_debut" class="form-label">Date de Départ:</label>
                                <input type="date" class="form-control" name="date_debut" required>
                            </div>
                            <div class="mb-3">
                                <label for="date_fin" class="form-label">Date de Fin:</label>
                                <input type="date" class="form-control" name="date_fin" required>
                            </div>
                            <div class="mb-3">
                                <label for="mode_paiement" class="form-label">Mode de Paiement:</label>
                                <select class="form-select" name="mode_paiement" required>
                                    <option value="">Sélectionner le mode de paiement</option>
                                    <option value="carte">Carte Bancaire</option>
                                    <option value="virement">Virement Bancaire</option>
                                    <option value="paypal">PayPal</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-reserver">Valider</button> 
                            <button href="panier.php"type="submit" class="btn btn-reserver">Annuler</button>

                        </form>
                    <?php else: ?>
                        <p>Voiture introuvable.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
