<?php
// --- 1. Veritabanı bağlantısı ---
$host = "localhost";        // genelde 'localhost'
$dbname = "kap262kyaocomtr_";     // kendi veritabanı adın
$username = "kpdk_deger_odul";      // veritabanı kullanıcı adın
$password = "kpdk2026!";      // veriatabanı şifren

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Veritabanı bağlantı hatası: " . $conn->connect_error);
}

// --- 2. Form verilerini al ---
$adsoyad  = $_POST['adsoyad'] ?? '';
$email    = $_POST['email'] ?? '';
$telefon  = $_POST['telefon'] ?? '';
$kategori = $_POST['kategori'] ?? '';
$mesaj    = $_POST['mesaj'] ?? '';

// Güvenlik: XSS ve boş değer kontrolü
$adsoyad  = htmlspecialchars(trim($adsoyad));
$email    = htmlspecialchars(trim($email));
$telefon  = htmlspecialchars(trim($telefon));
$kategori = htmlspecialchars(trim($kategori));
$mesaj    = htmlspecialchars(trim($mesaj));

if (empty($adsoyad) || empty($email) || empty($kategori)) {
    die("Lütfen gerekli alanları doldurunuz!");
}

// --- 3. Veritabanına kaydet ---
$stmt = $conn->prepare("INSERT INTO basvurular (adsoyad, email, telefon, kategori, mesaj) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $adsoyad, $email, $telefon, $kategori, $mesaj);

if ($stmt->execute()) {
    // --- 4. Mail gönder ---
    $to = "iletisim@tgc.org.tr"; // kurum mail adresiniz
    $subject = "Yeni Başvuru: $adsoyad";
    $body = "Ad Soyad: $adsoyad\nE-posta: $email\nTelefon: $telefon\nKategori: $kategori\nMesaj: $mesaj";
    $headers = "From: no-reply@seninsite.com";

    mail($to, $subject, $body, $headers);

    echo "<h2>Başvurunuz başarıyla alınmıştır. Teşekkür ederiz!</h2>";
} else {
    echo "Bir hata oluştu: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
