<?php
$dsn = 'sqlite:' . __DIR__ . '/DataBase.db'; 
$pdo = new PDO($dsn);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('PRAGMA encoding = "UTF-8";'); 

$sql_regions = "SELECT states, localaty, region_id FROM regions"; 
$stmt_regions = $pdo->prepare($sql_regions);
$stmt_regions->execute();
$regions = $stmt_regions->fetchAll(PDO::FETCH_ASSOC);

function insertTeacher($pdo, $fullName, $gender, $maritalStatus, $nationalityId, $idProof, $level, $degree, $previousLocality, $subjects, $previousRegion, $regionId, $email, $phone) {
    $sql = "INSERT INTO teachers (full_name, gender, marital_status, nationality_id, id_proof, level, degree, previous_locality, subjects, previous_region, region_id, email, phone) 
            VALUES (:fullName, :gender, :maritalStatus, :nationalityId, :idProof, :level, :degree, :previousLocality, :subjects, :previousRegion, :regionId, :email, :phone)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':fullName', $fullName);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':maritalStatus', $maritalStatus);
    $stmt->bindParam(':nationalityId', $nationalityId);
    $stmt->bindParam(':idProof', $idProof, PDO::PARAM_LOB);
    $stmt->bindParam(':level', $level);
    $stmt->bindParam(':degree', $degree);
    $stmt->bindParam(':previousLocality', $previousLocality);
    $stmt->bindParam(':subjects', $subjects);
    $stmt->bindParam(':previousRegion', $previousRegion);
    $stmt->bindParam(':regionId', $regionId);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);

    $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullName = $_POST['fullName'];
    $gender = $_POST['gender'] == 'ذكر' ? 'ذكر' : 'أنثى'; 
    $maritalStatus = $_POST['maritalStatus'];
    $nationalityId = $_POST['nationalityId'];
    $level = $_POST['level'];
    $degree = $_POST['degree'];
    $previousLocality = $_POST['previousLocality'];
    $subjects = $_POST['subjects'];
    $previousRegion = $_POST['previousRegion'];
    $regionId = $_POST['regionId'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $idProof = isset($_FILES['idProof']) ? file_get_contents($_FILES['idProof']['tmp_name']) : null;

    if (empty($fullName) || empty($gender) || empty($maritalStatus) || empty($email) || empty($phone)) {
        echo "الرجاء ملء جميع الحقول المطلوبة.";
        exit;
    }

    insertTeacher(
        $pdo,
        $fullName,
        $gender,
        $maritalStatus,
        $nationalityId,
        $idProof,
        $level,
        $degree,
        $previousLocality,
        $subjects,
        $previousRegion,
        $regionId,
        $email,
        $phone
    );

    echo "تم إرسال البيانات بنجاح!";
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدخال بيانات المعلم</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            position: relative;
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
        h2 {
            text-align: center;
            font-size: 1.4rem;
            color: #007bff;
        }
        img {
            position: absolute;
            top: 10px;
            width: 50px;  /* تعديل الحجم ليظهر أصغر */
        }
        .logo-left {
            left: 10px;
        }
        .logo-right {
            right: 10px;
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
        .checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
    </style>
</head>
<body>
    <img src="logo.jpg" alt="شعار الوزارة" class="logo-left">
    <img src="logo.jpg" alt="شعار الوزارة" class="logo-right">
    <div class="container">
        <h1>إدخال بيانات المعلم</h1>
        <h2>وزارة التربية والتعليم</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <h4>الرجاء ملء جميع البيانات بشكل صحيح</h4>
            
            <label for="fullName">الاسم الكامل</label>
            <input type="text" id="fullName" name="fullName" required>

            <label for="gender">الجنس</label>
            <select id="gender" name="gender" required>
                <option value="ذكر">ذكر</option>
                <option value="أنثى">أنثى</option>
            </select>

            <label for="maritalStatus">الحالة الاجتماعية</label>
            <select id="maritalStatus" name="maritalStatus" required>
                <option value="أعزب">أعزب</option>
                <option value="متزوج">متزوج</option>
                <option value="مطلق">مطلق</option>
                <option value="أرمل">أرمل</option>
            </select>

            <label for="nationalityId">الرقم الوطني</label>
            <input type="text" id="nationalityId" name="nationalityId">

            <label for="idProof">إثبات الهوية (صورة)</label>
            <input type="file" id="idProof" name="idProof" accept="image/*">

            <label for="level">المستوى الدراسي</label>
            <select id="level" name="level" required>
                <option value="الابتدائية">الابتدائية</option>
                <option value="المتوسطة">المتوسطة</option>
                <option value="الثانوية">الثانوية</option>
                <option value="الجامعية">الجامعية</option>
            </select>

            <label for="degree">الدرجة العلمية</label>
            <input type="number" id="degree" name="degree" required>

            <label for="previousLocality">المحلية السابقة</label>
            <input type="text" id="previousLocality" name="previousLocality">

            <label for="subjects">المواد الدراسية</label>
            <div class="checkbox-group">
                <label><input type="checkbox" name="subjects[]" value="اللغة العربية"> اللغة العربية</label>
                <label><input type="checkbox" name="subjects[]" value="الرياضيات"> الرياضيات</label>
                <label><input type="checkbox" name="subjects[]" value="العلوم"> العلوم</label>
                <label><input type="checkbox" name="subjects[]" value="الفيزياء"> الفيزياء</label>
                <label><input type="checkbox" name="subjects[]" value="الكيمياء"> الكيمياء</label>
                <label><input type="checkbox" name="subjects[]" value="اللغة الإنجليزية"> اللغة الإنجليزية</label>
                <label><input type="checkbox" name="subjects[]" value="التربية الإسلامية"> التربية الإسلامية</label>
                <label><input type="checkbox" name="subjects[]" value="التاريخ"> التاريخ</label>
                <label><input type="checkbox" name="subjects[]" value="الجغرافيا"> الجغرافيا</label>
                <label><input type="checkbox" name="subjects[]" value="التربية الفنية"> التربية الفنية</label>
            </div>

            <label for="previousRegion">المنطقة السابقة</label>
            <input type="text" id="previousRegion" name="previousRegion">

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

            <label for="email">البريد الإلكتروني</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">رقم الهاتف</label>
            <input type="tel" id="phone" name="phone" required>

            <button type="submit">إرسال البيانات</button>
        </form>
    </div>
</body>
</html>
