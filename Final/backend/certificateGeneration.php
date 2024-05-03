<?php
$connection = mysqli_connect(
    'localhost',
    'root',
    '123',
    'ELITE_CODERS'
);


if(isset($_POST['submit'])){
    $iniName = $_POST['send_instiname'];
    $stdName = $_POST['send_stuname'];
    $grades = $_POST['send_grade'];
    $courseName = $_POST['send_course'];
    $certificateID = $_POST['send_id'];

    $con = array($stdName, $iniName, $grades, $certificateID);

    //fetch the course_id from the database
    $q = "SELECT COURSE_ID FROM COURSES WHERE COURSE_NAME='$courseName'";
    $result = mysqli_fetch_assoc(mysqli_query($connection, $q));
    $course_id = $result['COURSE_ID'];

    //define the destinations
    $destinationTXT ="../Issuer1/". $courseName ."/templates/position.txt";
    $destinationFONT ="../Issuer1/". $courseName ."/templates/font.ttf";
    $destinationJPEG ="../Issuer1/". $courseName ."/templates/Certificate_template.jpg";
    $destinationCERTIFICATE ="../Issuer1/". $courseName ."/certificates";

    $file = fopen($destinationTXT , 'r');
    $temp = fgets($file);
    $row = $temp[0][0];

    $array = array();

//read the position in an array
    for($i = 0; $i < $row; $i++){
        preg_match_all('/[0-9]+/', fgets($file), $content);
        $array[$i] = $content[0];
    }
//create the certificate
    $im = imagecreatefromjpeg($destinationJPEG);
    $color = imagecolorallocate($im, 51, 51, 102);
    $font = realpath($destinationFONT);
    for($i = 0; $i < $row; $i++){
        imagettftext($im, $array[$i][0], 0, $array[$i][1], $array[$i][2], $color, $font, $con[$i]);
    }
    imagejpeg($im, $destinationCERTIFICATE . "/".$stdName.$certificateID.'.jpg');
    imagedestroy($im);

    $q1 = "INSERT INTO CERTIFICATES (COURSE_ID, ISSUER_ID, STUD_NAME, BLOCKCHAIN_ID) VALUES ('$course_id', 1001, '$con[0]', '$con[3]')";
    mysqli_query($connection, $q1);
    header('Location: http://localhost/Final/frontend/newcertificate/newCertificate.php');
}