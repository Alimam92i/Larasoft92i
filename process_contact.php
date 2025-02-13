<?php
header('Content-Type: application/json');

// Récupération des données du formulaire
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

// Validation des données
if (empty($name) || empty($email) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Veuillez remplir tous les champs.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Adresse e-mail invalide.']);
    exit;
}

// Configuration de l'e-mail
$to = 'mm86822296@gmail.com';
$subject = 'Nouveau message de contact - Larasoft';
$headers = [
    'From' => $email,
    'Reply-To' => $email,
    'X-Mailer' => 'PHP/' . phpversion(),
    'Content-Type' => 'text/html; charset=UTF-8'
];

// Corps du message
$email_content = "
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #0ff; color: #000; padding: 10px; }
        .content { padding: 20px 0; }
        .footer { color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h2>Nouveau message de contact</h2>
        </div>
        <div class='content'>
            <p><strong>Nom:</strong> " . htmlspecialchars($name) . "</p>
            <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
            <p><strong>Message:</strong></p>
            <p>" . nl2br(htmlspecialchars($message)) . "</p>
        </div>
        <div class='footer'>
            <p>Ce message a été envoyé depuis le formulaire de contact de Larasoft.</p>
        </div>
    </div>
</body>
</html>";

// Envoi de l'e-mail
$mail_sent = mail($to, $subject, $email_content, implode("\r\n", $headers));

if ($mail_sent) {
    echo json_encode(['success' => true, 'message' => 'Votre message a été envoyé avec succès.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Une erreur est survenue lors de l\'envoi du message.']);
}
