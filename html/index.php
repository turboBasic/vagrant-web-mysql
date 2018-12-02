<html>
<head>
    <title>Ansible Application</title>
</head>
 <body>
    <h1>
      <a href="http://web/index.html">Homepage</a>
    </h1>
    <p>
    <?php
        print "Hello, World! I am a web server configured using Ansible and I am : ";
        echo exec('hostname');
    ?>
    </p>
    <?php
        echo "List of Databases: <br/>";
                $res = mysqli_query($link, "SHOW DATABASES;");
        while ($row = mysqli_fetch_assoc($res)) {
            echo $row['Database'] . "\n";
        }
    ?>
    </p>
</body>
</html>
