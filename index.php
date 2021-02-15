<?php
// INF653 VB Week 4 Project
// Author: Craig Freeburg
// Date: 2/15/21

require('database.php');

$newTask = filter_input(INPUT_POST, "newtask", FILTER_SANITIZE_STRING);
$newDesc = filter_input(INPUT_POST, "newdesc", FILTER_SANITIZE_STRING);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Craig's To Do List</title>
    <link rel="stylesheet" href="main.css">
</head>


<!-- the body section -->

<body>
    <header>
        <h1>ToDo List</h1>
    </header>
    <main>
        <!-- results secion -->
        <section>
            <?php

            if ($newTask && $newDesc) {
                $query = "INSERT INTO todoitems(Title, Description)
                    VALUES (:newTask, :newDesc)";
                $statement = $db->prepare($query);
                $statement->bindValue(':newTask', $newTask);
                $statement->bindValue(':newDesc', $newDesc);
                $statement->execute();
                $statement->closeCursor();
                header("location:index.php");
            }

            $query = 'SELECT * FROM todoitems';
            $statement = $db->prepare($query);
            $statement->execute();
            $tasks = $statement->fetchAll();
            $statement->closeCursor();

            if (!$tasks) {
                echo "Put your feet up!";
            }
            ?>
            
            <?php foreach ($tasks as $task) : ?>
                <tr>
                    <td><?php echo $task['Title']; ?></td>
                    <td><?php echo $task['Description']; ?></td>
                </tr>
                <form class="delete" action="delete.php" method="POST">
                    <input type="hidden" value="<?php echo $result['ItemNum']?>">
                    <button type="deleteButton" id="deleteButton">Delete</button>   
                    
                </form>
            <?php endforeach; ?>
        </section>
        <!-- add items section -->
        <section id="addItem">
            <h2>Add Item:</h2><br>
            <form id="submitTask" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <input type="text" id="newTask" placeholder="Task"><br>
                <input type="text" id="newDesc" placeholder="Description"><br>
                <button type="addButton" id="addButton"> ADD </button>
            </form>
            <?php

            ?>
        </section>
    </main>
</body>

</html>