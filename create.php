<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stylish Form</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Task Details</h5>
            <form id="taskForm">
              <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
              </div>
              <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="8" placeholder="Enter description"></textarea>
              </div>
              <div class="form-group">
                <label for="date">Due Date</label>
                <input type="date" class="form-control" id="date" name="date" value="<?php echo date('Y-m-d'); ?>">
              </div>
              <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                  <option value="pending">Pending</option>
                  <option value="completed">Completed</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
              <a href="index.php" class="btn btn-warning">Cancel</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#taskForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
          type: "POST",
          url: "save_task.php",
          data: formData,
          success: function(response) {
            alert(response);
            window.location.href = 'index.php';
          }
        });
      });
    });
  </script>
</body>

</html>