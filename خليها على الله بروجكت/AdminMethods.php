<?php
// تحديد المسار للملف داخل المشروع

 
function AllStudents(){
    
        try {
            $dbFile = __DIR__ . '/DataBase.db';
            $pdo = new PDO("sqlite:" . $dbFile);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
            echo "تم الاتصال بقاعدة البيانات بنجاح!<br>";
            $sql_regions = "SELECT full_name, educational_stage, grade, previous_residence,region_id FROM students"; // اختيار الولايات والمحليات
            $stmt_regions = $pdo->prepare($sql_regions);
            $stmt_regions->execute();
            $students = $stmt_regions->fetchAll(PDO::FETCH_ASSOC);
            if (count($students) > 0) {
                echo "<table border='1' cellspacing='0' cellpadding='10' style='width: 100%; text-align: left;'>";
                echo "<thead>";
                echo "<tr style='background-color: #f2f2f2;'>";
                echo "<th>الاسم الكامل</th>";
                echo "<th>المرحلة التعليمية</th>";
                echo "<th>الصف</th>";
                echo "<th>مكان الإقامة السابق</th>";
                echo "<th>المنطقة الحالية/th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
            
                foreach ($students as $student) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($student['full_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($student['educational_stage']) . "</td>";
                    echo "<td>" . htmlspecialchars($student['grade']) . "</td>";
                    echo "<td>" . htmlspecialchars($student['previous_residence']) . "</td>";
                    echo "<td>" . htmlspecialchars($student['region_id']) . "</td>";
                    echo "</tr>";
                }
            
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>لم يتم العثور على طلاب.</p>";
            }
        }catch (PDOException $e) {
        }
    }
    function StudentsByregion($class){
        try{
            $dbFile = __DIR__ . '/DataBase.db';
            $pdo = new PDO("sqlite:" . $dbFile);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
            echo "تم الاتصال بقاعدة البيانات بنجاح!<br>";
            $sql_regions = "SELECT full_name, educational_stage, grade, previous_residence FROM students WHERE region_id = $class"; // اختيار الولايات والمحليات
            $stmt_regions = $pdo->prepare($sql_regions);
            $stmt_regions->execute();
            $students = $stmt_regions->fetchAll(PDO::FETCH_ASSOC);

            // تحقق من وجود بيانات
            if (count($students) > 0) {
                echo "<table border='1' cellspacing='0' cellpadding='10' style='width: 100%; text-align: left;'>";
                echo "<thead>";
                echo "<tr style='background-color: #f2f2f2;'>";
                echo "<th>الإسم</th>";
                echo "<th>المرحلة</th>";
                echo "<th>الصف</th>";
                echo "<th>البلد الأم</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                foreach ($students as $student) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($student['full_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($student['educational_stage']) . "</td>";
                    echo "<td>" . htmlspecialchars($student['grade']) . "</td>";
                    echo "<td>" . htmlspecialchars($student['previous_residence']) . "</td>";
                    echo "</tr>";
                }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>No students found.</p>";
        }
        }catch (PDOException $e) {
        }
    }
    function StudentsByLevel ($class){
        try {
            $dbFile = __DIR__ . '/DataBase.db';
            $pdo = new PDO("sqlite:" . $dbFile);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
            echo "تم الاتصال بقاعدة البيانات بنجاح!<br>";
            $sql_regions = "SELECT full_name, educational_stage, grade, previous_residence FROM students WHERE level = $class"; // اختيار الولايات والمحليات
            $stmt_regions = $pdo->prepare($sql_regions);
            $stmt_regions->execute();
            $students = $stmt_regions->fetchAll(PDO::FETCH_ASSOC);

// تحقق من وجود بيانات
            if (count($students) > 0) {
                echo "<table border='1' cellspacing='0' cellpadding='10' style='width: 100%; text-align: left;'>";
                echo "<thead>";
                echo "<tr style='background-color: #f2f2f2;'>";
                echo "<th>الاسم الكامل</th>";
                echo "<th>المرحلة التعليمية</th>";
                echo "<th>الصف</th>";
                echo "<th>مكان الإقامة السابق</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                foreach ($students as $student) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($student['full_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($student['educational_stage']) . "</td>";
                    echo "<td>" . htmlspecialchars($student['grade']) . "</td>";
                    echo "<td>" . htmlspecialchars($student['previous_residence']) . "</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>لم يتم العثور على طلاب.</p>";
            }
        }catch (PDOException $e) {
        }
    }
 function AllTeachers () {
        try {
            $dbFile = __DIR__ . '/DataBase.db';
    $pdo = new PDO("sqlite:" . $dbFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    echo "تم الاتصال بقاعدة البيانات بنجاح!<br>";

    // استعلام للحصول على بيانات المعلمين
    $sql_regions = "SELECT full_name, level, degree, previous_locality, subjects, region_id FROM teachers";
    $stmt_regions = $pdo->prepare($sql_regions);
    $stmt_regions->execute();
    $teachers = $stmt_regions->fetchAll(PDO::FETCH_ASSOC);

    // تحقق من وجود بيانات
        if (count($teachers) > 0) {
            echo "<table border='1' cellspacing='0' cellpadding='10' style='width: 100%; text-align: left';>";
            echo "<thead>";
            echo "<tr style='background-color: #f2f2f2;'>";
            echo "<th>الاسم الكامل</th>";
            echo "<th>المستوى</th>";
            echo "<th>الدرجة</th>";
            echo "<th>المحلية السابقة</th>";
            echo "<th>المواد</th>";
            echo "<th>رقم المنطقة</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            foreach ($teachers as $teacher) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($teacher['full_name']) . "</td>";
                echo "<td>" . htmlspecialchars($teacher['level']) . "</td>";
                echo "<td>" . htmlspecialchars($teacher['degree']) . "</td>";
                echo "<td>" . htmlspecialchars($teacher['previous_locality']) . "</td>";
                echo "<td>" . htmlspecialchars($teacher['subjects']) . "</td>";
                echo "<td>" . htmlspecialchars($teacher['region_id']) . "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>لم يتم العثور على معلمين.</p>";
        }
            } catch (PDOException $e) {
            }
        }
        function displayTeachersByLevel($class) 
        {
            try {
                // الاتصال بقاعدة البيانات
                $dbFile = __DIR__ . '/DataBase.db';
                $pdo = new PDO("sqlite:" . $dbFile);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                echo "تم الاتصال بقاعدة البيانات بنجاح!<br>";
        
                // استعلام للحصول على بيانات المعلمين بناءً على المستوى
                $sql_regions = "SELECT full_name, degree, previous_locality, subjects, region_id FROM teachers WHERE level = :class";
                $stmt_regions = $pdo->prepare($sql_regions);
                $stmt_regions->execute(['class' => $class]);
                $teachers = $stmt_regions->fetchAll(PDO::FETCH_ASSOC);
                if (count($teachers) > 0) {
                    echo "<table border='1' cellspacing='0' cellpadding='10' style='width: 100%; text-align: 'left';>";
                    echo "<thead>";
                    echo "<tr style='background-color: #f2f2f2;'>";
                    echo "<th>الاسم الكامل</th>";
                    echo "<th>الدرجة</th>";
                    echo "<th>المحلية السابقة</th>";
                    echo "<th>المواد</th>";
                    echo "<th>رقم المنطقة</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    foreach ($teachers as $teacher) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($teacher['full_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($teacher['degree']) . "</td>";
                        echo "<td>" . htmlspecialchars($teacher['previous_locality']) . "</td>";
                        echo "<td>" . htmlspecialchars($teacher['subjects']) . "</td>";
                        echo "<td>" . htmlspecialchars($teacher['region_id']) . "</td>";
                        echo "</tr>";
                    }
        
                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "<p>لم يتم العثور على معلمين.</p>";
                }
            } catch (PDOException $e) {
                echo "<p>حدث خطأ أثناء الاتصال بقاعدة البيانات: " . htmlspecialchars($e->getMessage()) . "</p>";
            } catch (Exception $e) {
                echo "<p>حدث خطأ غير متوقع: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        }
        function displayTeachersByRegion($class) {
            try {
                // الاتصال بقاعدة البيانات
                $dbFile = __DIR__ . '/DataBase.db';
                $pdo = new PDO("sqlite:" . $dbFile);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                echo "تم الاتصال بقاعدة البيانات بنجاح!<br>";
        
                // استعلام للحصول على بيانات المعلمين بناءً على رقم المنطقة
                $sql_regions = "SELECT full_name, level, degree, previous_locality, subjects, region_id FROM teachers WHERE region_id = :class";
                $stmt_regions = $pdo->prepare($sql_regions);
                $stmt_regions->execute(['class' => $class]);
                $teachers = $stmt_regions->fetchAll(PDO::FETCH_ASSOC);
        
                // تحقق من وجود بيانات
                if (count($teachers) > 0) {
                    echo "<table border='1' cellspacing='0' cellpadding='10' style='width: 100%; text-align: left;'>";
                    echo "<thead>";
                    echo "<tr style='background-color: #f2f2f2;'>";
                    echo "<th>الاسم الكامل</th>";
                    echo "<th>المستوى</th>";
                    echo "<th>الدرجة</th>";
                    echo "<th>المحلية السابقة</th>";
                    echo "<th>المواد</th>";
                    echo "<th>رقم المنطقة</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
        
                    foreach ($teachers as $teacher) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($teacher['full_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($teacher['level']) . "</td>";
                        echo "<td>" . htmlspecialchars($teacher['degree']) . "</td>";
                        echo "<td>" . htmlspecialchars($teacher['previous_locality']) . "</td>";
                        echo "<td>" . htmlspecialchars($teacher['subjects']) . "</td>";
                        echo "<td>" . htmlspecialchars($teacher['region_id']) . "</td>";
                        echo "</tr>";
                    }
        
                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "<p>لم يتم العثور على معلمين.</p>";
                }
            } catch (PDOException $e) {
                echo "<p>حدث خطأ أثناء الاتصال بقاعدة البيانات: " . htmlspecialchars($e->getMessage()) . "</p>";
            } catch (Exception $e) {
                echo "<p>حدث خطأ غير متوقع: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
    
    }   
function AllCollaborators(){
    
}

    
// conect func with  HTML  
if (isset($_GET['type'])) {
        $type = $_GET['type']; // استلام المتغير
        // echo "<p>قيمة المتغير type هي: " . $type . "</p>";
        // التحقق من نوع البيانات والقيام بالإجراء المناسب بناءً على ذلك
        switch ($type) {
            case 'students':
                // عرض بيانات الطلاب
                echo "<h2>  بيانات الطلاب</h2>";
                AllStudents();
                break;
    
            case 'teachers':
                // عرض بيانات المعلمين
                echo "<h2>بيانات المعلمين</h2>";
                AllTeachers ();
                break;
    
            case 'collaborators':
                // عرض بيانات المتعاونين
                echo "<h2>بيانات المتعاونين</h2>";
                AllCollaborators();
                    break;
    
            case 'schools':
                // عرض بيانات المدارس
                echo "<h2>عرض المدارس</h2>";
                //   إضافة كود  معلومات المدارس
                break;
    
            default: 
                echo "<h2>خيار غير معروف</h2>";
                break;
        }
    } else {
        echo "<h2>لم يتم تحديد الخيار بعد</h2>";
    }
    ?>