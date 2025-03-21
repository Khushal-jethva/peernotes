<?php include("../Layout/header.php") ?>
<?php include("../Layout/sidebar.php") ?>

<?php
include("../../includes/dbconnection.php");

if (isset($_POST['add_course'])) {
    // Get course data from form submission
    $name = $_POST['name'];

    // Insert the course into the database
    $sql = "INSERT INTO course (name) VALUES ('$name')";
    if (mysqli_query($conn, $sql)) {
        // Redirect to avoid form re-submission on page refresh
        header("Location: view_coursedata.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
// Handle edit course
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_course'])) {
    $course_id = $_POST['course_id'];
    $name = $_POST['name'];


    $sql = "UPDATE course SET name = '$name' WHERE id = '$course_id'";
    if (mysqli_query($conn, $sql)) {
        echo "Course updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Handle delete course
if (isset($_GET['delete_id'])) {
    $course_id = $_GET['delete_id'];
    $sql = "DELETE FROM course WHERE id = '$course_id'";
    if (mysqli_query($conn, $sql)) {
        echo "Course deleted successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Retrieve courses from the database
$sql = "SELECT * FROM course";
$result = mysqli_query($conn, $sql);
?>

<div class="main-panel">
    <?php include("../Layout/admin_header.php") ?>
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Courses</h4>
                                <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#addcourse">
                                    <i class="fa fa-plus"></i> Add Course
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Modal for adding a new course -->
                            <div class="modal fade" id="addcourse" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addcourseLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addcourseLabel">Add New Course</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="view_coursedata.php" method="POST">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Course Name</label>
                                                    <input type="text" class="form-control" id="name" name="name" required>
                                                </div>

                                                <button type="submit" name="add_course" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="statusSwitch<?php echo $row['id']; ?>" <?php echo $row['status'] == 1 ? 'checked' : ''; ?> onchange="updateStatus(<?php echo $row['id']; ?>)">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-button-action">
                                                        <button type="button" class="btn btn-link btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#editCourseModal<?php echo $row['id']; ?>">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </button>
                                                        <a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-link btn-danger">
                                                            <i class="fa fa-times"></i> Delete
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editCourseModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editCourseLabel<?php echo $row['id']; ?>" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editCourseLabel<?php echo $row['id']; ?>">Edit Course</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="view_coursedata.php" method="POST">
                                                                <input type="hidden" name="course_id" value="<?php echo $row['id']; ?>">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Course Name</label>
                                                                    <input type="text" class="form-control" name="name" value="<?php echo $row['name']; ?>" required>
                                                                </div>
                                                                <div class="mb-3 form-check">
                                                                    <input type="checkbox" class="form-check-input" name="status" <?php echo $row['status'] == 1 ? 'checked' : ''; ?>>
                                                                    <label class="form-check-label" for="status">Active</label>
                                                                </div>
                                                                <button type="submit" name="edit_course" class="btn btn-primary">Save changes</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  
</div>


    <script>
        // Function to update the status when the toggle is changed
        function updateStatus(courseId) {
            // Get the current state of the switch
            var status = document.getElementById('statusSwitch' + courseId).checked ? 1 : 0;

            // Show a SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to change the status of this course.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, make an AJAX request to update the status in the database
                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", "update_status.php?course_id=" + courseId + "&status=" + status, true);
                    xhr.send();

                    // Optional: Display a success message after status update
                    xhr.onload = function() {
                        if (xhr.status == 200) {
                            Swal.fire(
                                'Updated!',
                                'The status has been updated.',
                                'success'
                            );
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was an issue updating the status.',
                                'error'
                            );
                        }
                    };
                } else {
                    // If the user cancels, reset the switch to its previous state
                    document.getElementById('statusSwitch' + courseId).checked = !document.getElementById('statusSwitch' + courseId).checked;
                }
            });
        }
    </script>



    <?php include("../Layout/footer.php") ?>