<?php
include("./PageParts/header.php");

?>
<html>
<head>
    <title>My Social Network</title>

</head>
<body>
    <header>
        <?php 
            $query = "SELECT * FROM users";
            $result = $conn->query($query);
            $row = $result->fetch_assoc();
            foreach ($row as $key => $value) {
                echo $key . " : " . $value . "<br>";
            }
            
        ?>
    </header>

    <main>
        
    </main>
</body>
</html>