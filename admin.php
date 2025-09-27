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

// --- 2. Başvuruları Çek ---
$sql = "SELECT * FROM basvurular ORDER BY basvuru_tarihi DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Başvurular Listesi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-warning">Başvurular</h2>
    <a href="export.php" class="btn btn-sm btn-success">📥 Excel'e Aktar</a>
  </div>
  
  <table class="table table-bordered table-hover table-dark align-middle">
    <thead>
      <tr class="text-warning">
        <th>ID</th>
        <th>Ad Soyad</th>
        <th>E-Posta</th>
        <th>Telefon</th>
        <th>Kategori</th>
        <th>Mesaj</th>
        <th>Başvuru Tarihi</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['adsoyad']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['telefon']) ?></td>
            <td><?= htmlspecialchars($row['kategori']) ?></td>
            <td><?= nl2br(htmlspecialchars($row['mesaj'])) ?></td>
            <td><?= $row['basvuru_tarihi'] ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="7" class="text-center">Henüz başvuru yok.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

</body>
</html>

<?php $conn->close(); ?>
