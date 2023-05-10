<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff</title>
    <link rel="stylesheet" href="style.css">

</head>
<header>
    <a href="https://wwwlab.webug.se/xmlapi/a22albjo/projekt/">Home</a>
    <a href="https://wwwlab.webug.se/xmlapi/a22albjo/projekt/courses.php">Courses</a>
    <a href="https://wwwlab.webug.se/xmlapi/a22albjo/projekt/programs.php">Programs</a>
    <a href="https://wwwlab.webug.se/xmlapi/a22albjo/projekt/rooms.php">Rooms</a>
    <a href="https://wwwlab.webug.se/xmlapi/a22albjo/projekt/staff.php">Staff</a>
</header>
<body>

    <form action="" method="post">
        <label id="staff" for="staff">
            <input name="staff" type="text" id="staff" value="">
        </label>
        <button>Filter staff</button>
    </form>

    <?php
        //Om något är postat hämta rum
        if(isset($_POST['staff'])) {
            $staffToGet = $_POST['staff'];
        } else{
            $staffToGet = "";
        }
        $xml = file_get_contents('https://wwwlab.webug.se/examples/XML/scheduleservice/staff?namesearch='.rawurlencode($staffToGet));
        $dom = new DomDocument;
        $dom->preserveWhiteSpace = FALSE;
        $dom->loadXML($xml);
        $staffs = $dom->getElementsByTagName("staff");
    ?>

    <?php if(isset($staffs)):?>
        <?php echo "<h1>".$staffToGet."</h1>" ?>
        <div class="staffCardContainer">
        <?php foreach ($staffs as $staff) : ?>
            <div class="staffCard">
                <img src="./bilder/<?php echo $staff->getAttribute('title') ?>.svg" alt="Bild på en <?php echo $staff->getAttribute('title') ?>" height="300px" width="240px" >
                <p><?php echo $staff->getAttribute('id') ?></p>
                <p><b><?php echo $staff->getAttribute('fname') ?> <?php echo $staff->getAttribute('lname') ?></b></p>
                <p>Titel: <?php echo $staff->getAttribute('title') ?></p>
                <p>Department: <?php echo $staff->getAttribute('department') ?></p>
                <p>Born: <?php echo $staff->getAttribute('birthyear') ?></p>
                <p>Tel: <?php echo $staff->getAttribute('telnr') ?></p>
            </div>
            <?php endforeach ?>
        </div>
    <?php else :?>
        <p>No values found</p>
    <?php endif ?>

</body>
</html>