<?php

$dsn = 'sqlite:' . __DIR__ . '/DataBase.db'; 
$pdo = new PDO($dsn);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('PRAGMA encoding = "UTF-8";'); 

$sql_regions = "SELECT states, localaty, region_id FROM regions"; 
$stmt_regions = $pdo->prepare($sql_regions);
$stmt_regions->execute();
$regions = $stmt_regions->fetchAll(PDO::FETCH_ASSOC);

function insertStudent($pdo, $fullName, $nationalNumberImage, $nationalNumber, $gender, $educationalStage, $grade, $previousSchool, $lastResult, $previousResidence, $regionId, $currentHousing, $phoneNumber, $email, $guardianPhoneNumber, $whatsappNumber, $notes) {
    $sql = "INSERT INTO students (full_name, national_number_image, national_number, gender, educational_stage, grade, previous_school, last_result, previous_residence, region_id, current_housing, phone_number, email, guardian_phone_number, whatsapp_number, notes) 
            VALUES (:fullName, :nationalNumberImage, :nationalNumber, :gender, :educationalStage, :grade, :previousSchool, :lastResult, :previousResidence, :regionId, :currentHousing, :phoneNumber, :email, :guardianPhoneNumber, :whatsappNumber, :notes)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':fullName', $fullName);
    $stmt->bindParam(':nationalNumberImage', $nationalNumberImage, PDO::PARAM_LOB);
    $stmt->bindParam(':nationalNumber', $nationalNumber);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':educationalStage', $educationalStage);
    $stmt->bindParam(':grade', $grade);
    $stmt->bindParam(':previousSchool', $previousSchool);
    $stmt->bindParam(':lastResult', $lastResult, PDO::PARAM_LOB);
    $stmt->bindParam(':previousResidence', $previousResidence);
    $stmt->bindParam(':regionId', $regionId);
    $stmt->bindParam(':currentHousing', $currentHousing);
    $stmt->bindParam(':phoneNumber', $phoneNumber);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':guardianPhoneNumber', $guardianPhoneNumber);
    $stmt->bindParam(':whatsappNumber', $whatsappNumber);
    $stmt->bindParam(':notes', $notes);

    $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullName = $_POST['fullName'];
    $nationalNumber = $_POST['nationalNumber'];
    $gender = $_POST['gender'] == 'ذكر' ? 1 : 2; 
    $educationalStage = $_POST['educationalStage'];
    $grade = $_POST['grade'];
    $previousSchool = $_POST['previousSchool'];
    $previousResidence = $_POST['previousResidence'];
    $regionId = $_POST['regionId'];
    $currentHousing = $_POST['currentHousing'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $guardianPhoneNumber = $_POST['guardianPhoneNumber'];
    $whatsappNumber = $_POST['whatsappNumber'];
    $notes = isset($_POST['notes']) ? $_POST['notes'] : null;

    $nationalNumberImage = isset($_FILES['nationalNumberImage']) ? file_get_contents($_FILES['nationalNumberImage']['tmp_name']) : null;
    $lastResult = isset($_FILES['lastResult']) ? file_get_contents($_FILES['lastResult']['tmp_name']) : null;

    if (empty($fullName) || empty($nationalNumber) || empty($phoneNumber) || empty($email)) {
        echo "الرجاء ملء جميع الحقول المطلوبة.";
        exit;
    }

    insertStudent(
        $pdo,
        $fullName, 
        $nationalNumberImage, 
        $nationalNumber, 
        $gender, 
        $educationalStage, 
        $grade, 
        $previousSchool, 
        $lastResult, 
        $previousResidence, 
        $regionId, 
        $currentHousing, 
        $phoneNumber, 
        $email, 
        $guardianPhoneNumber, 
        $whatsappNumber, 
        $notes
    );

    echo "تم إرسال البيانات بنجاح!";
}

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدخال بيانات الطالب</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            position: relative;
        }
        .logo-left, .logo-right {
            position: absolute;
            top: 10px;
            width: 50px; /* تعديل حجم الشعار */
            height: auto;
        }
        .logo-left {
            left: 10px;
        }
        .logo-right {
            right: 10px;
        }
        .container {
            max-width: 800px;
            margin: 30px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333333;
            font-size: 1.8rem;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-weight: bold;
            color: #555555;
        }
        input, select, textarea {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            transition: border-color 0.3s;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #007bff;
            outline: none;
        }
        textarea {
            resize: vertical;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        option {
            padding: 5px;
        }
    </style>
</head>
<body>
    <img src="logo.jpg" alt="شعار الوزارة" class="logo-left">
    <img src="logo.jpg" alt="شعار الوزارة" class="logo-right">

    <div class="container">
        <h1> وزارة التربية و التعليم</h1>
        <h1> حصر الطلاب المتضررين من الحرب </h1>
        <form id="studentForm" action="" method="POST" enctype="multipart/form-data">
            <label for="fullName">الاسم الكامل</label>
            <input type="text" id="fullName" name="fullName" required>

            <label for="nationalNumberImage">الرقم الوطني (صورة)</label>
            <input type="file" id="nationalNumberImage" name="nationalNumberImage" accept="image/*" required>

            <label for="nationalNumber">الرقم الوطني</label>
            <input type="text" id="nationalNumber" name="nationalNumber" required>

            <label for="gender">الجنس</label>
            <select id="gender" name="gender" required>
                <option value="ذكر">ذكر</option>
                <option value="أنثى">أنثى</option>
            </select>

            <label for="educationalStage">المرحلة الدراسية</label>
            <select id="educationalStage" name="educationalStage" required>
                <option value="الابتدائية">الابتدائية</option>
                <option value="المتوسطة">المتوسطة</option>
                <option value="الثانوية">الثانوية</option>
            </select>

            <label for="grade">الصف الدراسي</label>
            <input type="text" id="grade" name="grade" required>

            <label for="previousSchool">المدرسة السابقة</label>
            <input type="text" id="previousSchool" name="previousSchool">

            <label for="lastResult">نتيجة آخر فصل دراسي</label>
            <input type="file" id="lastResult" name="lastResult" accept="image/*">

            <label for="previousResidence">منطقة الإقامة السابقة</label>
            <input type="text" id="previousResidence" name="previousResidence" required>

            <label for="regionId">المنطقة</label>
            <select id="regionId" name="regionId" required>
                <option value="">اختر المنطقة</option>
                <?php
                foreach ($regions as $region) {
                    $regionDisplay = $region['states'] . ' - ' . $region['localaty'];
                    echo "<option value='{$region['region_id']}'>{$regionDisplay}</option>";
                }
                ?>
            </select>

            <label for="currentHousing">نوع السكن الحالي</label>
            <input type="text" id="currentHousing" name="currentHousing">

            <label for="phoneNumber">رقم الهاتف</label>
            <input type="tel" id="phoneNumber" name="phoneNumber" required>

            <label for="email">البريد الإلكتروني</label>
            <input type="email" id="email" name="email" required>

            <label for="guardianPhoneNumber">رقم ولي الأمر</label>
            <input type="tel" id="guardianPhoneNumber" name="guardianPhoneNumber" required>

            <label for="whatsappNumber">رقم واتساب</label>
            <input type="tel" id="whatsappNumber" name="whatsappNumber" required>

            <label for="notes">ملاحظات</label>
            <textarea id="notes" name="notes"></textarea>

            <button type="submit">إرسال البيانات</button>
        </form>
    </div>
</body>
</html>
