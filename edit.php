<?php
include_once "connect.php";
// Fetch task details
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $sql = "SELECT * FROM tk WHERE id = $id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $title = $row['title'];
    $description = $row['desc'];
    $addtime = $row['duedate'];
    $status = $row['status'];
  } else {
    echo "Task not found.";
  }
}

if (isset($_POST['submit'])) {
  $id = $_POST['id'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $addtime = $_POST['addtime'];
  $status = $_POST['status'];
  $sql = "UPDATE tk SET title='$title', `desc`='$description', duedate='$addtime', status='$status' WHERE id=$id";

  if ($conn->query($sql) === TRUE) {
    session_start();
    $_SESSION['message'] = 'Task updated Successfully !.';
  } else {
    session_start();
    $_SESSION['message'] = 'Task Not updated !.';
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Task</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Edit Task</h5>
            <form method="post">
              <div class="form-group">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>">
              </div>
              <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="8"><?php echo $description; ?></textarea>
              </div>
              <div class="form-group">
                <label for="addtime">Due Date</label>
                <input type="date" class="form-control" id="addtime" name="addtime" value="<?php echo $addtime; ?>">
              </div>
              <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                  <option value="pending" <?php if ($status == 'pending') echo 'selected'; ?>>Pending</option>
                  <option value="completed" <?php if ($status == 'completed') echo 'selected'; ?>>Completed</option>
                </select>
              </div>
              <?php if (isset($_SESSION['message'])) { ?>
                <p id="message" style="color:green;"><?php echo $_SESSION['message']; ?></p>
              <?php
                session_destroy();
              } ?>
              <button type="submit" class="btn btn-primary" name="submit">Update</button>
              <a href="index.php" class="btn btn-warning">Index !</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>