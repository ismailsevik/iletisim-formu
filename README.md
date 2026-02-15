
# 📬 PHP & PHPMailer İletişim Formu

Bu proje, **PHPMailer** kütüphanesini kullanarak **Gmail SMTP** üzerinden e-posta gönderen, güvenli ve tek sayfa bir iletişim formudur. 

Özellikle **Localhost (XAMPP/WAMP)** üzerinde çalışırken karşılaşılan SSL/TLS sertifika hatalarını aşacak şekilde yapılandırılmıştır.

## 🚀 Özellikler

* **SMTP Desteği:** PHP `mail()` fonksiyonu yerine güvenilir SMTP protokolü kullanır.
* **Localhost Uyumlu:** Yerel sunucularda SSL sertifika hatası vermeden çalışır.
* **Güvenlik:** XSS saldırılarına karşı `htmlspecialchars` ve veri temizleme filtreleri içerir.
* **Kolay Kurulum:** Tek dosya (`iletisim.php`) üzerinden çalışır.

## 📂 Dosya Yapısı

Proje klasörünüz şu şekilde görünmelidir:

```
proje-klasoru/
├── PHPMailer/          # PHPMailer kütüphanesi dosyaları
│   ├── Exception.php
│   ├── PHPMailer.php
│   └── SMTP.php
├── iletisim.php        # Form ve gönderim kodları

```

## ⚙️ Kurulum ve Ayarlar

1. Bu projeyi bilgisayarınıza indirin.
2. `iletisim.php` dosyasını bir kod editörü ile açın.
3. Aşağıdaki alanları kendi bilgilerinizle güncelleyin:

```
// iletisim.php - Satır 30 civarı
$mail->Username   = 'seninmailin@gmail.com';  // Gmail adresiniz
$mail->Password   = 'abcd efgh ijkl mnop';    // 16 Haneli Google Uygulama Şifresi

```

> **Önemli Not:** `$mail->Password` alanına normal Gmail şifrenizi **yazmayın**. Google Hesabınızdan [Uygulama Şifresi](https://myaccount.google.com/apppasswords) oluşturup onu kullanmalısınız.

## ssl_fix (Localhost İçin)

Kod içerisinde şu blok, yerel sunucuda (Localhost) SSL hatası almadan mail göndermenizi sağlar. Canlı sunucuya (Hosting) taşıdığınızda bu bloğu silebilirsiniz.

```php
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);

```

## 📝 Kullanım

Projeyi `localhost/iletisim.php` adresinden çalıştırın, formu doldurun ve gönderin. Mesaj anında belirlediğiniz e-posta adresine düşecektir.

---

