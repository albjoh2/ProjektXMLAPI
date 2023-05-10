<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>
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
        <label id="course" for="course">
            <input name="course" type="text" id="course" value="">
        </label>
        <button>Check course</button>
    </form>

    <?php
        //Om något är postat hämta rum
        if(isset($_POST['course'])) {
            $courseToGet = $_POST['course'];
            $xml = file_get_contents('https://wwwlab.webug.se/examples/XML/scheduleservice/courses?namesearch='.rawurlencode($courseToGet));
            $dom = new DomDocument;
            $dom->preserveWhiteSpace = FALSE;
            $dom->loadXML($xml);
            $courses = $dom->getElementsByTagName("course");
        }
        ?>

<?php if(isset($courses)):?>
    <?php echo "<h1>".$courseToGet."</h1>" ?>
    <?php foreach ($courses as $course) : ?>
        <table>
            <thead>
                    <th>ID</th>
                    <th>HP</th>
                    <th>Area</th>
                    <th>Name</th>
                </thead>
                <tbody>
            <tr>
                <td>
                    <p><?php echo $course->getAttribute('id') ?></p>
                </td>
                <td>
                    <p><?php echo $course->getAttribute('hp') ?></p>
                </td>
                <td>
                    <p><?php echo $course->getAttribute('department') ?></p>
                </td>
                <td>
                    <p><?php echo $course->getAttribute('name') ?></p>
                </td>
            </tr>

            <table>
                <thead>
                    <th>Room</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Sign</th>
                    <th>Comment</th>
                    <th>Group</th>
                    <th>Type</th>
                </thead>
                <tbody>
                    <?php ?>
                <?php foreach ($course->getElementsByTagName('entries') as $entry) : ?>
                    <tr>
                        <td>
                            <p><?php echo $entry->getAttribute('room') ?></p>
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
        <?php endforeach ?>
        </tbody>
    </table>
<?php endif ?>
</body>
</html>