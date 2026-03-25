<?php

$apiToken = "efaufhxcc38umo5w5mkzib7nhp4oz1jz1484j6vjrmonmt08rq3l56z5zufewbeu";
$apiUrl = "https://app.sigilopay.com.br/api/v1/transactions";

// PEGAR DADOS DO FORM
$nome = $_POST['nome'];
$email = $_POST['email'];
$cpf = $_POST['cpf'];

// DADOS DO PAGAMENTO
$data = [
    "amount" => 49.90,
    "paymentMethod" => "pix",
    "customer" => [
        "name" => $nome,
        "email" => $email,
        "document" => $cpf
    ],
    "items" => [
        [
            "title" => "Kit Exclusivo",
            "quantity" => 1,
            "unitPrice" => 49.90
        ]
    ]
];

// CURL
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $apiToken",
    "Content-Type: application/json"
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

// MOSTRAR RESULTADO
if(isset($result['pix']['qrCode'])) {

    echo "<h2>Pagamento PIX</h2>";

    echo "<p>Copia e cola:</p>";
    echo "<textarea rows='5' cols='50'>" . $result['pix']['qrCode'] . "</textarea>";

    echo "<p>QR Code:</p>";
    echo "<img src='data:image/png;base64," . $result['pix']['qrCodeBase64'] . "' />";

} else {
    echo "Erro:";
    echo "<pre>";
    print_r($result);
    echo "</pre>";
}

?>