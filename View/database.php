<?php 
session_start();
if (!isset($_SESSION['user_id'])){
header("Location: login.html");
}
?>
<!DOCTYPE html>
<html lang="en">
<?php
include 'head.html';
?>
<body class = 'main flex'>

    <?php
        include "sidebar.html";
    ?>

    <div class="main_block ">
        <div class="up_block">
        <div class="upload_form">
            <form method="post" enctype="multipart/form-data" action ="../Controller/upload.php" class='file_input'>
                <label >Please input your two excel sheets</label>
                
                <div class="flex">
                    <div class="container">
                        <input type="file" name="fileToUpload" id="fileToUpload" required>
                    </div>
                    <div class="container">
                        <input type="file" name="fileToUpload2" id="fileToUpload2" required>
                    </div>
                </div>

                <input type="submit">
            </form>
        </div>
        <div class="download_file">
            <p>Download your Finale DataBase in CSV Format</p>
            <?php
                
                // echo $fileDir;
                if (isset($_GET['file'])){
                    $fileDir = $_GET['file'];
                    echo "<a href='$fileDir' download > Download </a>";
                }
                else {
                    echo "<a class='disabled' > Not Yet Uploaded </a>";
                }
               

            ?>
</a>
        </div>
        </div>

        <?php $directory = '../Exports';
        $files = glob($directory . '/*');
        if (count($files)!=0){
            include 'table.php';
        }
        else{
            //to modify later
            echo "No database Uploaded";
        }
        
        ?>
    </div>

</body>
</html>