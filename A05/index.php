<?php
include("connect.php");

$query = "SELECT Userinfo.firstName, Users.userName, Posts.dateTime, Posts.content FROM Userinfo INNER JOIN Users ON Userinfo.userID = Users.userID INNER JOIN Posts ON Userinfo.userID = Posts.userID";
$result = executeQuery($query);

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Activity 5 DA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <div class="container-fluid shadow mb-5 p-3" style="background-color: slategray;">
    <h1>
      Posts
    </h1>
  </div>

  <div class="container">
    <div class="row">
      <!-- PHP BLOCK -->
      <?php
      if (mysqli_num_rows($result)) {
        while ($user = mysqli_fetch_assoc($result)) {
      ?>
          <div class="col-12">
            <div class="card rounded-4 shadow my-3 mx-5">
              <div class="card-body">
                <div class="container-fluid d-flex">
                  <h5 class="card-title">
                    <?php echo $user["firstName"] ?>
                  </h5>
                  <h6 class="card-subtitle mt-1 ms-1 text-body-secondary">
                    <?php echo "@" . $user["userName"] . " -" ?>
                    <?php
                    if ($user["dateTime"] != "") {
                      echo $user["dateTime"];
                    } else {
                      echo "-----";
                    }
                    ?>
                  </h6>
                </div>

                <div class="container d-flex">
                  <p class="card-text">
                    <?php
                    if ($user['content'] != "") {
                      echo $user['content'];
                    } else {
                      echo "<i style='color: grey'>No data to show</i>";
                    }

                    ?>
                  </p>
                </div>
              </div>
            </div>
          </div>
      <?php
        }
      }
      ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>