<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <a href="https://wwwlab.webug.se/xmlapi/a22albjo/projekt/">Home</a>
    <a href="https://wwwlab.webug.se/xmlapi/a22albjo/projekt/courses.php">Courses</a>
    <a href="https://wwwlab.webug.se/xmlapi/a22albjo/projekt/programs.php">Programs</a>
    <a href="https://wwwlab.webug.se/xmlapi/a22albjo/projekt/rooms.php">Rooms</a>
    <a href="https://wwwlab.webug.se/xmlapi/a22albjo/projekt/staff.php">Staff</a>
</header>

    <?php
        //Hämta data
        $data = file_get_contents('https://wwwlab.webug.se/examples/XML/scheduleservice/rooms?mode=json');

        //Omvandla till JSON
        $data = json_decode($data, true);
    ?>

    <form action="" method="post">
        <select id="room" name="room">
            <?php foreach ($data as $rooms): ?>
                <option id="room" value="<?php echo $rooms['number'] ?>"><?php echo $rooms['number'] ?></option>
            <?php endforeach ?>
        </select>
        <button>Check room</button>
    </form>

    <?php
        //Om något är postat hämta rum
        if(isset($_POST['room'])) {
            $roomToGet = $_POST['room'];
            $xml = file_get_contents('https://wwwlab.webug.se/examples/XML/scheduleservice/rooms?number='.$roomToGet);
            $dom = new DomDocument;
            $dom->preserveWhiteSpace = FALSE;
            $dom->loadXML($xml);
            $entrys = $dom->getElementsByTagName("entry");
        }

    ?>
        <?php if(isset($entrys)):?>
            <?php echo "<h1>".$roomToGet."</h1>" ?>
    <table>
        <thead>
            <th>ID</th>
            <th>Course</th>
            <th>Start</th>
            <th>End</th>
            <th>Sign</th>
            <th>Comment</th>
            <th>Group</th>
            <th>Type</th>
        </thead>
        <tbody>
        <?php foreach ($entrys as $entry) : ?>
            <tr>
                <td>
                    <p><?php echo $entry->getAttribute('courseid') ?></p>
                </td>
                <td>
                    <p><?php echo $entry->getAttribute('coursename') ?></p>
                </td>
                <td>
                    <p><?php echo $entry->getAttribute('starttime') ?></p>
                </td>
                <td>
                    <p><?php echo $entry->getAttribute('endtime') ?></p>
                </td>
                <td>
                    <p><?php echo $entry->getAttribute('sign') ?></p>
                </td>
                <td>
                    <p><?php echo $entry->getAttribute('comment') ?></p>
                </td>
                <td>
                    <p><?php echo $entry->getAttribute('group') ?></p>
                </td>
                <td>
                    <p><?php echo $entry->getAttribute('type') ?></p>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?php endif ?>
</body>
</html>