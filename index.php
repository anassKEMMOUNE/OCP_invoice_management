<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <section class="main">
    <div class="sidebar">
            
    </div>
    <div class="main_block">

    </div>
    </section>
    <form method="post" enctype="multipart/form-data" action ="Controller/upload.php">
        <label for="fileToUpload">Please input your excel sheet</label>
         <input type="file" name="fileToUpload" id="fileToUpload">
         <label for="fileToUpload2">Please input your second excel sheet</label>
         <input type="file" name="fileToUpload2" id="fileToUpload2">
         <input type="submit">

    </form>

</body>
</html>