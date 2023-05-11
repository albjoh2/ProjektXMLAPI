<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programs</title>
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
    <h2>Antal Terminer</h2>
    <div class="graph-container">
        <?php
        $my_graph_data = [];
        foreach($entries as $entry){
            $my_graph_data[] = $entry->getAttribute('hp');
        }
        echo "<div style='position:absolute; display:flex; flex-direction: column;'>";
        foreach($my_graph_data as $bar_height){
            echo "<div class='graph-bar' style='height:".$bar_height."px'></div>";
        }
        echo "</div>";
        echo "<div style='z-index:1;display:flex; flex-direction: column;'>";
            echo "<div class='graph-bar' style='height:30px; background-color:#ccccff55;'>Termin 6</div>";
            echo "<div class='graph-bar' style='height:30px; background-color:#ccffcc55;'>Termin 5</div>";
            echo "<div class='graph-bar' style='height:30px; background-color:#ccccff55;'>Termin 4</div>";
            echo "<div class='graph-bar' style='height:30px; background-color:#ccffcc55;'>Termin 3</div>";
            echo "<div class='graph-bar' style='height:30px; background-color:#ccccff55;'>Termin 2</div>";
            echo "<div class='graph-bar' style='height:30px; background-color:#ccffcc55;'>Termin 1</div>";
        echo "</div>";
        ?>
    </div>
    <h2>Inkluderade kurser</h2>
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
                    <?php echo "<a href='https://wwwlab.webug.se/xmlapi/a22albjo/projekt/courses.php?course=".rawurlencode($entry->getAttribute('name'))."'>" ?>
                        <p><?php echo $entry->getAttribute('name') ?></p>
                    </a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?php endif ?>
</body>
</html>