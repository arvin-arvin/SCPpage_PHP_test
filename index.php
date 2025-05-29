<!doctype html>
<html>
    <head>
        <title>PHP CRUD Application</title>
        <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=Doto:wght@100..900&family=Fragment+Mono:ital@0;1&family=Major+Mono+Display&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    </head>
        <body style="background-color: rgb(24, 24, 24);
    font-family: monospace;
    color: white">
            <?php include "connection.php"; ?>
            
            
<!---->
    <nav class="top_nav navbar sticky-top" data-bs-theme="dark" id="nav1"">
      <div class="container-fluid ">
        <a class="navbar-brand d-inline-block align-text-top" href="index.php">
          <img src="images/logo.png" id="logo" alt="logo" width="30s" height="30" >
          <span id="nav-title">SCP Foundation</span></a>
        </button>
          <ul class="navbar-nav ms-auto d-flex flex-row">
            <li class="nav-item d-lg-none d-xl-none" style="margin-right: 2rem;">
              <a class="nav-link" href="#scplist">SCP List</a>
            </li>
            <li class="nav-item " style="margin-right: 2rem;">
                <a href="create.php" class="nav-link">Add New Records</a>
           </li>
          </ul>
        </div>
      </div>                
    </nav>
<!---->
            <?php 
            
            if(isset($_GET['del'])) {
$ID = $_GET['del'];
$delete = $connection->prepare('delete from SCPs where id=?');
$delete->bind_param('i', $ID);
if($delete->execute()) {
echo "<p class='alert alert-primary'><strong>Record successfully deleted</strong> (refresh to see effect)</p>";
} else{
echo "<p class='alert alert-danger'>Error: {$delete->error}</p>";
}
}?>

    <div class="container mt-3">
      <div class="row gy-4 gx-5 sidecon">
        <div class="col-12 col-xl-10 col-lg-10" >
      <div class="row gy-4 gx-2 sidecon" id="col-left" style="background-color: rgb(39, 39, 39)">

<!---->


<!---->
        </div>
       <?php
                
                // based on menu click display full record from link GET value
                if(isset($_GET['link']))
                {
                    // Save GET value as a variable
                    $model = $_GET['link'];
                    
                    // SQL query to retrieve record based on the model
                    $query = $connection->query("select * from SCPs where name= '$model'");
                    
                    // Run the query
                    if($query && $query->num_rows > 0)
                    {
                        // if query succeeds save as an array
                        $array = $query->fetch_assoc();
                        $edit = "edit.php?edit=" . $array['id'];
                        $delete = "index.php?del=" . $array['id'];
                        $head = explode("-", $array['name'])[1];
                        
                        echo "
                            <h2 id='title' class='text-center'><b><span id='object1'>Item #: </span></b><span style='color: white'>SCP-{$head}</span></h2> 
        <div class=' h1 text-center' id='objClass{$array['class']}' role='alert'>
        <span id='object2'>OBJECT CLASS:</span> <span id='{$array['class']}'>{$array['class']}</span>
        </div>
        <div class='card text-bg-dark' style='padding-top: 2rem;'>
            <img src='{$array['img']}' class='image-size rounded mx-auto d-block img mb-2' alt='{$array['alt']}' >
            <div class='card-body' >

                <blockquote class='blockquote d-flex justify-content-center' style='margin-bottom: -5rem'>
                    <footer class='blockquote-footer'>A close up of {$array['name']}</cite></footer>
                </blockquote>
            </div>
        </div>
        <hr>

        <h1 style='color: black;
                         font-family: 'Fragment Mono'>Special Containment Procedures:</h1>

        <div class='col-12 d-flex justify-content-center' id='col'>
            <div class='card text-bg-dark mb-2' style='padding: 1rem;'>
            <div class='card-body'>
                <p class='card-text'>{$array['SCPdescr']}</p>
            </div>
        </div>
        </div>

            <hr>

            <h1 style='color: black;
                         font-family: 'Fragment Mono'>Description & Reference:</h1>

            <div class='col-12 d-flex justify-content-center' id='col'>
                <div class='card text-bg-dark mb-2' style='padding: 1rem;'>
                <div class='card-body'>
                    <p class='card-text'>{$array['descr']}</p>
                </div>
            </div>
            </div>
            
            <div class='row sidecon d-flex flex-row mt-4 justify-content-between'>
                <a style='border: solid 5px #3DC7F1;
                font-family: monospace;
                font-weight: bold;'
                class='btn btn-outline-info col-5' href='{$edit}'>Edit</a>
                
                <a style='border: solid 5px #E33030;
                font-family: monospace;
                font-weight: bold;'
                class='btn btn-outline-danger col-5' href='javascript:void(0);' 
                onclick='confirmDelete(\"{$delete}\")'>Delete</a>
            </div>
                        ";
                    }
                    else
                    {
                        echo "<p>Error retrieving records</p>";
                    }
                }
                else
                {
                    // This will display first time user  visits page
                    echo "
                        <div class='card text-bg-dark mb-2 mt-3' style='padding: 1rem;'>
                        <div class='card-body'>
                        <blockquote class='blockquote mb-0'>
                            <p><strong>Mankind in its present state has been around for a quarter of a million years, yet only a small fraction of that has been of any significance.</strong></p>
                            <p>So, what did we do for nearly 250,000 years? We huddled in caves and around small fires, fearful of the things that we didn't understand. It was more than explaining why the sun came up, it was the mystery of enormous birds with heads of men and rocks that came to life. So we called them 'gods' and 'demons', begged them to spare us, and prayed for salvation.</p>
                            <p>In time, their numbers dwindled and ours rose. The world began to make more sense when there were fewer things to fear, yet the unexplained can never truly go away, as if the universe demands the absurd and impossible.</p>
                            <p><strong>Mankind must not go back to hiding in fear.</strong> No one else will protect us, and we must stand up for ourselves.</p>
                            <p>While the rest of mankind dwells in the light, we must stand in the darkness to fight it, contain it, and shield it from the eyes of the public, so that others may live in a sane and normal world.</p>
                            <p style='font-size: 1rem; color: gray'><strong>We secure. We contain. We protect.</strong></p>

                        <footer class='blockquote-footer'><cite title='Source Title'>The Administrator</cite></footer>
                        </blockquote>
                        </div>
                        </div>
                        <h1 style='color: black;
                         font-family: 'Fragment Mono'>MISSION STATEMENT</h1>
                            <p>Operating clandestine and worldwide, the Foundation acts beyond conventional jurisdiction, with the task of containing anomalous objects, entities, and phenomena.</p>
                            <p>We maintain an extensive database of information regarding anomalies requiring Special Containment Procedures, commonly referred to as 'SCPs'; all of which undermine the natural laws that the people of the world implicitly trust in.</p>
                            <p>We operate to maintain normalcy, so that the worldwide civilian population can live and go on with their daily lives without fear, mistrust, or doubt in their personal beliefs, and to maintain human independence from extraterrestrial, extradimensional, and other extranormal influence.</p>
                            <h3>Our mission is threefold:</h3>
                            <ul>
                                <li><strong>Secure:</strong> secure anomalies to prevent them from falling into the hands of civilian or rival agencies through extensive observation and surveillance, acting to intercept anomalies at the earliest opportunity.</li>
                                <li><strong>Contain:</strong> contain anomalies to prevent spread of their influence or effects; by either relocating, concealing, or dismantling them, or by suppressing public dissemination of knowledge thereof.</li>
                                <li><strong>Protect:</strong> protects humanity as well as the anomalies themselves until such time that they are either fully understood or new theories of science can be devised based on their properties and behavior.</li>
                            </ul>
                            
                            <p>Additional information will have been provided upon your joining us in pursuit of our goals. Welcome to the Foundation, and good luck.</p>

                        
                        
                    ";
                }
                ?>
      
<!---->


        
<!---->
    </div>
    <div class='colright col-12 col-xl-2 col-lg-2 mt-5 ' id='col-right'>
        <?php foreach($result as $link): ?>

        
 
          <div class='card text-bg-dark mb-2' id='side-card'>
                        <div class='card-header text-center'>
                            <?php echo $link['name']; ?>
                        </div>
                        <img src='<?php echo $link['img']; ?>' class='card-img-top' height='125' alt='${$array['alt']}'>
                        <div class='card-body'>
                            <p class='card-title text-center mb-3' id='side-text-title'>'<?php echo $link['title']; ?>'</p>
                            <a href='index.php?link=<?php echo $link['name']; ?>' class='stretched-link fancy-underline'><span>Research Now</span></a>
                        </div>
                    </div>
                    

          <?php endforeach; ?>
          </div>
        </div>
      </div>

            



     <script>
            function confirmDelete(url) {
    if (confirm("Are you sure you wanna delete this record?")) {
        window.location.href = url;
    }
}
</script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
            
            
            </script>
        </body>
</html>