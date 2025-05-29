<?php
    include "connection.php";
if (isset($_POST['update'])) {
    // prepare an update statement
    $update = $connection->prepare("update SCPs set name=?, class=?, title=?, SCPdescr=?, descr=?, img=?, alt=? WHERE id=?");
    $update->bind_param("sssssssi", $_POST['name'], $_POST['class'], $_POST['title'], $_POST['SCPdescr'], $_POST['descr'], $_POST['img'], $_POST['alt'], $_POST['id']);

    if ($update->execute()) {
        echo "<p>Record successfully updated</p>
            <p> <a href='index.php'>index page</a></p>";
    } else {
        echo "<p>Error: " . $update->error . "</p>";
       echo "<p> <a href='index.php'>index page</a></p>";
    }
}

?>