<?php
//! PHP mail fonksiyonu
//! ÖNEMLİ: Daha gelişmiş ve güvenli bir iletişim formu için PHPMailer gibi bir kütüphane kullanmanız şiddetle tavsiye edilir.

$subject = 'Yeni İletişim Formu Mesajı';
$to = 'cemiyet@tgc.org.tr';

//! Kullanıcıdan gelen verileri güvenli hale getirme
//! trim() fonksiyonu gereksiz boşlukları siler
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$msg = trim($_POST['message']);

//! Basit doğrulama kontrolleri
if (empty($name) || empty($email) || empty($msg)) {
    echo 'Lütfen tüm zorunlu alanları doldurun.';
    exit;
}

//! E-posta adresinin geçerli formatta olup olmadığını kontrol etme
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'Lütfen geçerli bir e-posta adresi girin.';
    exit;
}

//! E-posta içeriğini oluşturma
$message_body = "İsim: " . htmlspecialchars($name) . "\n";
$message_body .= "E-posta: " . htmlspecialchars($email) . "\n";
$message_body .= "Telefon: " . htmlspecialchars($phone) . "\n";
$message_body .= "Mesaj: " . htmlspecialchars($msg) . "\n";

//! E-posta başlıklarını oluşturma
$headers = "From: " . htmlspecialchars($name) . " <" . htmlspecialchars($email) . ">\r\n";
$headers .= "Reply-To: " . htmlspecialchars($email) . "\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n"; // Daha basit ve güvenli kullanım için text/plain önerilir

//! E-postayı gönderme
if (mail($to, $subject, $message_body, $headers)) {
    echo 'sent';
} else {
    echo 'failed';
}

?>