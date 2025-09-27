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

header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=basvurular.xls");
header("Pragma: no-cache");
header("Expires: 0");

$sql = "SELECT * FROM basvurular ORDER BY basvuru_tarihi DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Başlık satırı
    echo "ID\tAd Soyad\tE-Posta\tTelefon\tKategori\tMesaj\tBaşvuru Tarihi\n";
    
    // Veriler
    while($row = $result->fetch_assoc()) {
        echo $row['id']."\t".$row['adsoyad']."\t".$row['email']."\t".$row['telefon']."\t".$row['kategori']."\t".str_replace("\n"," ",$row['mesaj'])."\t".$row['basvuru_tarihi']."\n";
    }
} else {
    echo "Henüz başvuru yok.";
}

$conn->close();
?>
