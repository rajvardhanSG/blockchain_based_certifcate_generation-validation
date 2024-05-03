<!doctype html>
<html>
    <head>
        <title>Create Course</title>
    </head>
    <body>
    <?php
        $connection = mysqli_connect(
            'localhost',
            'root',
            '123',
            'ELITE_CODERS'
        );

        if(isset($_POST['submit'])){
            //retrieving the files from the form
            $course_name = $_POST['course'];
            $template = $_FILES['template']['tmp_name'];
            $font = $_FILES['font']['tmp_name'];
            $coordinates = $_FILES['coordinates']['tmp_name'];

            //creating the directories
            if( !file_exists('../Issuer1/' . $course_name) ){
                //create directory course_name
                $c_name = '../Issuer1/' . $course_name;
                mkdir($c_name);

                //create directory course_name/templates and course_name/certificates
                $temp = '../Issuer1/' . $course_name . '/templates';
                mkdir($temp);

                $temp = '../Issuer1/' . $course_name . '/certificates';
                mkdir($temp);
            }

            //placing the required files in the course_name/templates dir (all the files have same destination)
            $destination = '../Issuer1/' . $course_name . '/templates';

            if(move_uploaded_file($template, $destination . '/Certificate_template.jpg')){
                    move_uploaded_file($font, $destination . '/font.ttf');
                    move_uploaded_file($coordinates, $destination . '/position.txt');

                    //update the database
                    $q = "INSERT INTO COURSES (COURSE_NAME, ISSUER_ID) VALUES ('$course_name', 1001)";
                    if($query = mysqli_query($connection, $q)){
                        // echo '<h3>The Course has been generated successfuly!!</h3>';
                        header('Location: http://localhost/Final/frontend/newcertificate/newCertificate.php');
                    }
            }
            else{
                echo ('Failed Miserably');
            }
        }
    ?>
    </body>
</html>

