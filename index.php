<?php
// PHPMailer sınıflarını dahil ediyoruz
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Gerekli dosyaları çağırıyoruz (Klasör yollarının doğru olduğundan emin ol)
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$mesaj_durumu = ""; // Ekrana basılacak mesaj

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Formdan gelen verileri temizle
    $ad_soyad = htmlspecialchars(trim($_POST['ad_soyad']));
    $email    = htmlspecialchars(trim($_POST['email']));
    $konu     = htmlspecialchars(trim($_POST['konu']));
    $mesaj    = htmlspecialchars(trim($_POST['mesaj']));

    // Mail Gönderme İşlemi Başlıyor
    $mail = new PHPMailer(true);

    try {
        // --- Sunucu Ayarları ---
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.gmail.com';                       
        $mail->SMTPAuth   = true;                                   
        
        // *** BURAYI KENDİ BİLGİLERİNLE DOLDUR ***
        $mail->Username   = 'seninmailin@gmail.com';       // Senin Gmail adresin
        $mail->Password   = '1234 abcd 1234 abcd';      // Google'dan aldığın 16 haneli Uygulama Şifresi
     
       //*** https://myaccount.google.com/apppasswords adresinden alınacak şifre

   
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
        $mail->Port       = 587;                                    

        // *** SSL HATASI ÇÖZÜMÜ (Localhost İçin) ***
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        // *** ÇÖZÜM BİTTİ ***

        // --- Alıcı ve Gönderici Ayarları ---
        $mail->setFrom('seninmailin@gmail.com@gmail.com', 'İletişim Formu');  // Kimden gidiyor (Senin mailin)
        $mail->addAddress('seninmailin@gmail.com');                 // Kime gidiyor (Yine senin mailin)
        
        // Yanıtla deyince form dolduranın maili çıksın
        $mail->addReplyTo($email, $ad_soyad);

        // --- İçerik ---
        $mail->isHTML(true);                                  
        $mail->Subject = "Yeni Mesaj: " . $konu;
        $mail->Body    = "
            <h2>Yeni Mesaj Var!</h2>
            <p><strong>Gönderen:</strong> $ad_soyad</p>
            <p><strong>E-posta:</strong> $email</p>
            <p><strong>Konu:</strong> $konu</p>
            <p><strong>Mesaj:</strong><br>$mesaj</p>
            <p><small> Powered by İsmail Şevik </small</p>
            <p><small> Created by İsmail Şevik</small></p>      ";
        
        // Türkçe karakter sorunu olmaması için
        $mail->CharSet = 'UTF-8';

        $mail->send();
        $mesaj_durumu = "<div class='alert success'>Mesajınız başarıyla gönderildi!</div>";
        
    } catch (Exception $e) {
        $mesaj_durumu = "<div class='alert error'>Mesaj gönderilemedi. Hata: {$mail->ErrorInfo}</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim Formu</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #fff; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .form-container { background: #fff; padding: 40px;  width: 100%; max-width: 400px; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        input, textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; font-size: 14px; transition: border-color 0.3s; }
        input:focus, textarea:focus { border-color: #007bff; outline: none; }
        button { width: 100%; background: #007bff; color: white; padding: 12px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold; transition: background 0.3s; }
        button:hover { background: #0056b3; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; text-align: center; font-size: 14px; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Bize Ulaşın</h2>
    
    <?php echo $mesaj_durumu; ?>

    <form method="POST" action="">
        <div class="form-group">
            <input type="text" name="ad_soyad" placeholder="Adınız Soyadınız" required>
        </div>
        <div class="form-group">
            <input type="email" name="email" placeholder="E-posta Adresiniz" required>
        </div>
        <div class="form-group">
            <input type="text" name="konu" placeholder="Konu" required>
        </div>
        <div class="form-group">
            <textarea name="mesaj" rows="5" placeholder="Mesajınız" required></textarea>
        </div>
        <button type="submit">GÖNDER</button>
    </form>
</div>

</body>
</html>
