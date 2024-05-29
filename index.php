<?php
include_once "connect.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Records Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.6/css/dataTables.bootstrap5.min.css">
    <style>
        /* Custom styling for buttons */
        .btn-margin {
            margin-right: 5px;
        }

        .card-width {
            width: 75%;
            margin: auto;
        }

        @media (max-width: 768px) {
            .card-width {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-5 mb-5">
        <div class="card card-width">
            <?php
            include_once "connect.php";
            $sql_total = "SELECT COUNT(*) AS total_tasks FROM tk";
            $result_total = $conn->query($sql_total);
            $row_total = $result_total->fetch_assoc();
            $total_tasks = $row_total['total_tasks'];
            if (isset($_POST['submit'])) {
                $days = $_POST['days'];
                // Construct the date for days ago
                $daysAgoDate = date('Y-m-d', strtotime("-$days days"));
                // Fetch records from today to $daysAgoDate
                $sql_records = "SELECT * FROM tk WHERE status = 'completed' AND addtime >= '$daysAgoDate'";
                // Execute your SQL query here
            } else {
                // Fetch number of completed tasks
                $sql_completed = "SELECT COUNT(*) AS completed_tasks FROM tk WHERE status = 'completed'";
            }

            $result_completed = $conn->query($sql_completed);
            $row_completed = $result_completed->fetch_assoc();
            $completed_tasks = $row_completed['completed_tasks'];
            $pending_tasks = $total_tasks - $completed_tasks;

            ?>
            <div class="card-body">
                <div class="text-end mb-2 d-flex justify-content-between">
                    <h2 class="card-title mb-0">Tasks</h2>
                    <a href="create.php" class="btn btn-outline-success"><i class="fas fa-plus"></i></a>
                </div>
                <style>
                    .form-select {
                        width: 20% !important;
                    }
                </style>
                <div class="row">
                    <div class="col-md-6 col-12 border-0 w-30 d-flex">
                        <div class="d-flex justify-content-start align-items-end col-12">
                            <div class="col-4 text-warning">
                                <i class="fas fa-tasks footer-icon"></i>
                                <span>Total <?php echo $total_tasks; ?></span>
                            </div>
                            <div class="col-4 text-primary">
                                <i class="fas fa-check-circle footer-icon"></i>
                                <span>Completed <?php echo $completed_tasks; ?></span>
                            </div>
                            <div class="col-4 text-danger">
                                <i class="fas fa-exclamation-circle footer-icon"></i>
                                <span>Pending <?php echo $pending_tasks; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 d-flex justify-content-end">
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" type="search" placeholder="Search" name="search" aria-label="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>

                        <select class="form-select" onchange="filterByDate(this.value)" style="margin-left:10px!important;" aria-label="Default select example">
                            <option value="1" selected>Todays</option>
                            <option value="7">This Week</option>
                            <option value="30">This Month</option>
                        </select>
                        <form action="" method="GET" name="filterForm">
                            <input type="hidden" value="" name="days">
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // if (isset($_GET['search'])) {
                            //     // Sanitize input to prevent SQL injection
                            //     $search = mysqli_real_escape_string($conn, $_GET['search']);
                            //     // Fetch data for the current page
                            //     $sql_query = "SELECT * FROM tk WHERE title LIKE '%$search%' AND DATE(addtime) = CURDATE() ORDER BY status DESC LIMIT $perpage OFFSET $offset";
                            // } else {
                            //     // Fetch data for the current page
                            //     $sql_query = "SELECT * FROM tk WHERE DATE(addtime) = CURDATE() ORDER BY status = 'pending' DESC LIMIT $perpage OFFSET $offset";
                            // }
                            $perpage = 10;
                            $sql_total = "SELECT COUNT(*) AS total_tasks FROM tk";
                            $result_total = $conn->query($sql_total);
                            $row_total = $result_total->fetch_assoc();
                            $total_tasks = $row_total['total_tasks'];
                            $totalpages = ceil($total_tasks / $perpage);

                            // Get current page number
                            $page = isset($_GET['page']) ? $_GET['page'] : 1;

                            // Calculate offset for SQL query
                            $offset = ($page - 1) * $perpage;
                            if (isset($_GET['search'])) {
                                // Sanitize input to prevent SQL injection
                                $search = mysqli_real_escape_string($conn, $_GET['search']);

                                // Fetch data for the current page
                                $sql_query = "SELECT * FROM tk WHERE title LIKE '%$search%' ORDER BY status='pending' DESC LIMIT $perpage OFFSET $offset";
                            } else {
                                // Fetch data for the current page
                                $sql_query = "SELECT * FROM tk ORDER BY status='pending' DESC LIMIT $perpage OFFSET $offset";
                            }
                            $result = mysqli_query($conn, $sql_query);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td><a href='edit.php?id=" . $row['id'] . "' style='text-decoration:none;' class='text-dark'>" . $row['title'] . "</a></td>";
                                    echo "<td>" . $row['duedate'] . "</td>";
                                    echo "<td>";
                                    echo "<input type='checkbox' class='task-status-checkbox' data-task-id='" . $row['id'] . "'";
                                    if ($row['status'] == 'completed') {
                                        echo " checked";
                                    }
                                    echo " style='margin-right: 5px; transform: scale(1.5);'>"; // Apply styling for gap and checkbox size
                                    echo "<span class='status-text'>" . ucfirst($row['status']) . "</span>"; // Display the status text
                                    echo "</td>";
                                    echo "<td>";
                                    echo "<a href='edit.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm btn-margin'><i class='fas fa-edit'></i></a>";
                                    echo "<a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i></a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No records found</td></tr>";
                            }

                            ?>
                        </tbody>
                    </table>
                    <?php
                    echo "<div class=' pagination d-flex justify-content-end gap-2'>";
                    for ($i = 1; $i <= $totalpages; $i++) {
                        echo "<a href='?page=$i' class='  ";
                        if ($i == $page) {
                            echo "active";
                        }
                        echo "'>$i</a>";
                    } ?>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const checkboxes = document.querySelectorAll('.task-status-checkbox');
                        checkboxes.forEach(function(checkbox) {
                            checkbox.addEventListener('change', function() {
                                const taskId = this.getAttribute('data-task-id');
                                const status = this.checked ? 'completed' : 'pending';
                                updateTaskStatus(taskId, status);
                            });
                        });

                        function updateTaskStatus(taskId, status) {
                            const xhr = new XMLHttpRequest();
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === XMLHttpRequest.DONE) {
                                    if (xhr.status === 200) {
                                        // Handle successful response
                                        // console.log('Status updated successfully');
                                        location.reload();
                                    } else {
                                        // Handle error
                                        console.error('Error updating status');
                                    }
                                }
                            };
                            xhr.open('POST', 'fetchdata.php', true);
                            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                            xhr.send('id=' + taskId + '&status=' + status);
                        }


                    });

                    function filterByDate(number) {
                        var days = document.getElementsByName("days").value = number;
                        var form = document.getElementsByName("filterForm");
                        form.submit;
                        console.log(days);
                    }
                </script>

            </div>

        </div>

    </div>
    <?php include_once "commonfooter.php"; ?>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>

</html>