<!doctype html>
<html>
    <head>
        <title>Add New Record</title>
        <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=Doto:wght@100..900&family=Fragment+Mono:ital@0;1&family=Major+Mono+Display&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    </head>
    <body style='font-family: monospace;
    color: white;'
    data-bs-theme="dark">
        <h1 style='color: black;
                    background-color: white;'>
        Add New Record</h1>
        <?php
        
        
        include "connection.php";
        
        
        
        if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['name'])){
            // Prepared statement to insert data
            $insert = $connection->prepare("insert into SCPs(name, class, title, SCPdescr, descr, img, alt) values(?,?,?,?,?,?,?)");
            $insert->bind_param("sssssss", $_POST['name'], $_POST['class'], $_POST['title'], $_POST['SCPdescr'], $_POST['descr'], $_POST['img'], $_POST['alt']);
            
            if($insert->execute()){
                
                echo "
                    
                    <p class='alert alert-success mt-3' >Record succesfully created</p>
                ";
            
                
            }
            else{
                
                echo "

                    <p class='alert alert-danger mt-3' style='color: white'>Error: {$insert->error}</p>
                
                ";
                
            }
        }
        
        
        ?>
        
        
        <div class='container'>
        
        <div class='d-grid gap-1 mt-3 mb-3'>
        <a style='border: solid 5px white;
                font-family: monospace;
                font-weight: bold;'
        
        href="index.php" 
        class="btn btn-outline-light">Back to index page</a>
        </div>
        
        <form method="post" action="create.php" class="form-group p-3 border rounded shadow mb-3">
            <label style="font-size: 1.25rem; font-weight: bold;">Name/Item #</label>
            <br>
            <input type="text" name="name" placeholder="Enter item #" class="form-control">
            <br>
            
            <label style="font-size: 1.25rem; font-weight: bold;">Object Class</label>
            <br>
            <input type="text" name="class" placeholder="Enter class" class="form-control">
            <br>
            
            <label style="font-size: 1.25rem; font-weight: bold;">Title</label>
            <br>
            <input type="text" name="title" placeholder="Enter title" class="form-control">
            <br>
            
            <label style="font-size: 1.25rem; font-weight: bold;">Containment Procedure</label>
            <br>
            <textarea name="SCPdescr" class="form-control">Enter Containment Procedure</textarea>
            <br>
            
            <label style="font-size: 1.25rem; font-weight: bold;">Description</label>
            <br>
            <textarea name="descr" class="form-control">Enter Description</textarea>
            <br>
            
            <label style="font-size: 1.25rem; font-weight: bold;">Image Link</label>
            <br>
            <input type="text" name="img" placeholder="Enter image URL" class="form-control">
            <br>
            
            <label style="font-size: 1.25rem; font-weight: bold;">Alternative Image Label</label>
            <br>
            <input type="text" name="alt" placeholder="Enter alt image label" class="form-control">
            <br>
            <div class='d-grid gap-1'>
            <input type="button" name="create" value="Create new record" class="btn btn-outline-success" 
                style='border: solid 5px #15902B;
                font-family: monospace;
                font-weight: bold;'
                onclick='confirmCreate()'>
            </div>
        </form>
        </div>
        <script>
function confirmCreate() {
    if (confirm("Are you sure you wanna to create this record?")) {
        document.querySelector('form').submit();
    }
}
</script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    </body>
</html>