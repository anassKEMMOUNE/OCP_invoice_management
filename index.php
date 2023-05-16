<!DOCTYPE html>
<html lang="en">
<?php
include 'View/head.html';
?>
<body class = 'main'>

    <?php
        include "View/sidebar.html";

    ?>
    <div class="main_block">
        <div class="upload_form">
    <form method="post" enctype="multipart/form-data" action ="Controller/upload.php" class='file_input'>
        <label >Please input your two excel sheets</label>
        <div class="flex">
        <input type="file" name="fileToUpload" id="fileToUpload" >
        <input type="file" name="fileToUpload2" id="fileToUpload2" >

        </div>
        <input type="submit">

    </form>
    </div>
    </div>



</body>
</html>