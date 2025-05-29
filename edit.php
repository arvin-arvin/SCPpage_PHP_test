<!doctype html>
<html>
    <head>
        <title>Edit Record</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=Doto:wght@100..900&family=Fragment+Mono:ital@0;1&family=Major+Mono+Display&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    </head>
    <body style='font-family: monospace; color: white;' data-bs-theme="dark">
        <h1 style='color: black; background-color: white;'>Update Record</h1>
        <?php
        // Enable error reporting
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        include "connection.php";

        // Initialize empty array
        $row = [];

        // If directed from index page via edit button
        if (isset($_GET['edit'])) {
            $id = $_GET['edit'];

            // Based on id select appropriate record from db
            $recordID = $connection->prepare("SELECT * FROM SCPs WHERE id = ?");
            
            if (!$recordID) {
                echo "<p class='alert alert-danger mt-3'>Error preparing query</p>";
                exit;
            }

            $recordID->bind_param("i", $id);

            if ($recordID->execute()) {
                echo "<p class='alert alert-primary mt-3'>Record ready for editing</p>";
                $temp = $recordID->get_result();
                $row = $temp->fetch_assoc();
            } else {
                echo "<p class='alert alert-danger'>Error: {$recordID->error}</p>";
            }
        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
            $update = $connection->prepare("UPDATE SCPs SET name=?, class=?, title=?, SCPdescr=?, descr=?, img=?, alt=? WHERE id=?");
            $update->bind_param("sssssssi", $_POST['name'], $_POST['class'], $_POST['title'], $_POST['SCPdescr'], $_POST['descr'], $_POST['img'], $_POST['alt'], $_POST['id']);
            
            if ($update->execute()) {
                echo "<p class='alert alert-success mt-3'>Record successfully updated</p>
                ";
                
            } else {
                echo "<p class='alert alert-danger mt-3' style='color: white'>Error: {$update->error}</p>";
            }
        }
        ?>

        <div class='container'>
            <div class='d-grid gap-1 mt-3 mb-3'>
                <a style='border: solid 5px white; font-family: monospace; font-weight: bold;'
                   href="index.php" class="btn btn-outline-light">Back to index page</a>
            </div>

            <?php if (!empty($row)): ?>
                <form method="post" action="edit.php" class="form-group p-3 border rounded shadow mb-3">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>" class="form-control">
                    <label style="font-size: 1.25rem; font-weight: bold;">Name / Item #</label>
                    <br>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" class="form-control">
                    <br>
                    
                    <label style="font-size: 1.25rem; font-weight: bold;">Object Class</label>
                    <br>
                    <input type="text" name="class" value="<?php echo htmlspecialchars($row['class']); ?>" class="form-control">
                    <br>
                    
                    <label style="font-size: 1.25rem; font-weight: bold;">Title</label>
                    <br>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" class="form-control">
                    <br>
                    
                    <label style="font-size: 1.25rem; font-weight: bold;">Containment Procedures</label>
                    <br>
                    <textarea name="SCPdescr" class="form-control"><?php echo htmlspecialchars($row['SCPdescr']); ?></textarea>
                    <br>
                    
                    <label style="font-size: 1.25rem; font-weight: bold;">Description</label>
                    <br>
                    <textarea name="descr" class="form-control"><?php echo htmlspecialchars($row['descr']); ?></textarea>
                    <br>
                    
                    <label style="font-size: 1.25rem; font-weight: bold;">Image URL</label>
                    <br>
                    <input type="text" name="img" value="<?php echo htmlspecialchars($row['img']); ?>" class="form-control">
                    <br>
                    
                    <label style="font-size: 1.25rem; font-weight: bold;">Alt Image Label</label>
                    <br>
                    <input type="text" name="alt" value="<?php echo htmlspecialchars($row['alt']); ?>" class="form-control">
                    <br>
                    <div class='d-grid gap-1'>
                        <input style='border: solid 5px #15902B; font-family: monospace; font-weight: bold;'
                               type="button" value="Update record" class="btn btn-outline-success" onclick='confirmEdit()'>
                    </div>
                </form>
            <?php else: ?>
                <p style='text-align: center'>Nice editing!</p>
            <?php endif; ?>
        </div>

        <script>
        function confirmEdit() {
            if (confirm("Are you sure you want to update this record?")) {
                document.querySelector('form').submit();
            }
        }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    </body>
</html>