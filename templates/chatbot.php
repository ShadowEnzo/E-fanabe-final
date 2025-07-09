<?php
// Message à envoyer au chatbot Python
$message = "Bonjour, comment vas-tu ?";

// Préparation des données à envoyer en JSON
$data = json_encode(['message' => $message]);

// URL de l'API Python FastAPI (le backend Python doit être lancé dans le dossier "chatbot")
$pythonApiUrl = 'http://localhost:5000/chatbot';

// Initialisation de la requête cURL
$ch = curl_init($pythonApiUrl);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data)
]);

// Exécution de la requête et récupération du résultat
$result = curl_exec($ch);

// Fermeture de la session cURL
curl_close($ch);

// Décodage de la réponse JSON
$response = json_decode($result, true);

// Affichage de la réponse du chatbot
if (isset($response['response'])) {
    echo "Réponse du chatbot : " . $response['response'];
} else {
    echo "Erreur lors de la communication avec le chatbot.";
}
?>