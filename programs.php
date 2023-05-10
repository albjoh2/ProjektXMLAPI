<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programs</title>
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
    <?php
        //Hämta data
        $data = file_get_contents('https://wwwlab.webug.se/examples/XML/scheduleservice/programs?mode=json');

        //Omvandla till JSON
        $data = json_decode($data, true);
        ?>

        <form action="" method="post">
        <select id="program" name="program">
            <?php foreach ($data as $rooms): ?>
                <option id="program" value="<?php echo $rooms['name'] ?>"><?php echo $rooms['name'] ?></option>
            <?php endforeach ?>
        </select>
        <button>Check room</button>
    </form>

    <?php
        //Om något är postat hämta rum
        if(isset($_POST['program'])) {
            $programToGet = $_POST['program'];
            $xml = file_get_contents('https://wwwlab.webug.se/examples/XML/scheduleservice/programs?namesearch='.rawurlencode($programToGet));
            $dom = new DomDocument;
            $dom->preserveWhiteSpace = FALSE;
            $dom->loadXML($xml);
            $entries = $dom->getElementsByTagName("entries");
        }
    ?>
    <?php if(isset($entries)):?>
    <?php echo "<h1>".$programToGet."</h1>" ?>
    <table>
        <thead>
            <th>ID</th>
            <th>HP</th>
            <th>Area</th>
            <th>Name</th>
        </thead>
        <tbody>
        <?php foreach ($entries as $entry) : ?>
            <tr>
                <td>
                    <p><?php echo $entry->getAttribute('id') ?></p>
                </td>
                <td>
                    <p><?php echo $entry->getAttribute('hp') ?></p>
                </td>
                <td>
                    <p><?php echo $entry->getAttribute('area') ?></p>
                </td>
                <td>
                    <p><?php echo $entry->getAttribute('name') ?></p>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?php endif ?>
</body>
</html>