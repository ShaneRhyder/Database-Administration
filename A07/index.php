<?php
include("connect.php");

if (isset($_POST['btnPost'])) {
  $newPost = $_POST['newPost'];
  $date = $_POST['formattedDate'];

  $insertQuery = "INSERT INTO `posts`(`userID`, `content`, `dateTime`, `privacy`, `isDeleted`, `cityID`, `provinceID`) VALUES ('1', '$newPost', '$date', 'Public', 'No', '1', '1')";
  mysqli_query($conn, $insertQuery);
}

$query = "SELECT Userinfo.firstName, Users.userName, Posts.dateTime, Posts.content, Posts.postID FROM Userinfo INNER JOIN Users ON Userinfo.userID = Users.userID INNER JOIN Posts ON Userinfo.userID = Posts.userID WHERE Posts.isDeleted = 'No'";
$result = executeQuery($query);

if (isset($_POST['btnDelete'])) {
  $postID = $_POST['postID'];

  $deleteQuery = "UPDATE `posts` SET `isDeleted`='Yes' WHERE postID = '$postID'";
  mysqli_query($conn, $deleteQuery);

  header("Location: " . $_SERVER['PHP_SELF']);
  exit();
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Activity 7 DA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="icon" type="image/png" href="favicon.png">
  <style>
    .expanding-textarea {
      width: 100%;
      resize: none;
      overflow: hidden;
      min-height: 40px;
    }
  </style>
</head>

<body>
  <div class="container-fluid shadow mb-3 p-3" style="background-color: slategray;">
    <h1>
      Posts
    </h1>
  </div>

  <div class="container mb-3">
    <form method="POST">
      <textarea class="form-control expanding-textarea mb-2" name="newPost" id="expandingTextarea" rows="1"
        placeholder="New post"></textarea>
      <input type="hidden" name="formattedDate" id="formattedDate">
      <div class="d-flex justify-content-end">
        <button type="submit" class="px-3 btn btn-primary rounded-4" name="btnPost">Post</button>
      </div>
    </form>
  </div>

  <script>
    const textarea = document.getElementById('expandingTextarea');

    textarea.addEventListener('input', function() {
      textarea.style.height = 'auto';
      textarea.style.height = textarea.scrollHeight + 'px';
    });
  </script>

  <div class="containter-fluid" style="border-bottom: groove; border-width: 2px;">

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
                <form method="POST">
                  <input type="hidden" name="postID" value="<?php echo $user['postID']; ?>">
                  <div class="container-fluid d-flex">
                    <h5 class="card-title">
                      <?php echo $user["firstName"]; ?>
                    </h5>
                    <h6 class="card-subtitle mt-1 ms-1 text-body-secondary">
                      <?php echo "@" . $user["userName"] . " - " . $user["dateTime"]; ?>
                    </h6>
                    <div class="ms-auto mt-0">
                      <a href="view.php?postID=<?php echo $user['postID']; ?>" class="btn btn-secondary rounded-4">Edit</a>
                      <button type="submit" class="btn btn-primary rounded-4" name="btnDelete">Delete</button>
                    </div>
                  </div>
                </form>

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

<script src="getDate.js"></script>

</html>