<?php
include("../Layout/header.php");
include("../Layout/sidebar.php");

include("../../includes/dbconnection.php");

// Fetch teacher data where status is 0 (not approved yet)
$sql = "SELECT * FROM user WHERE role = 'teacher' AND status = 1";
$result = mysqli_query($conn, $sql);

if (isset($_GET['update_status'])) {
    $teacher_id = $_GET['teacher_id'];
    $new_status = $_GET['status']; // 1 for active, 0 for inactive

    $update_sql = "UPDATE user SET status = '$new_status' WHERE id = '$teacher_id'";
    if (mysqli_query($conn, $update_sql)) {
        echo "Status updated successfully!";
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
}
// Handle approval update
if (isset($_GET['update_approve'])) {
    $teacher_id = $_GET['teacher_id'];
    $new_approve = $_GET['approve']; // 1 for approved, 0 for not approved

    $update_sql = "UPDATE user SET approve = '$new_approve' WHERE id = '$teacher_id'";
    if (mysqli_query($conn, $update_sql)) {
        echo "Approval status updated successfully!";
    } else {
        echo "Error updating approval: " . mysqli_error($conn);
    }
}

// Check if the 'delete' action is requested
if (isset($_GET['delete_id'])) {
    $teacher_id = $_GET['delete_id'];

    // Update status to 0 (inactive) instead of deleting the record
    $update_sql = "UPDATE user SET status = 0 WHERE id = '$teacher_id' AND role = 'teacher'";
    if (mysqli_query($conn, $update_sql)) {
        // Optionally, redirect after update
        header("Location: view_teacher.php");
        exit;
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
}

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
                                <h4 class="card-title">Teacher </h4>
                             
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th>Approve</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td>
                                                    <?php if ($row['image']) { ?>
                                                        <img src="path/to/images/<?php echo $row['image']; ?>" alt="Teacher Image" width="50">
                                                    <?php } else { ?>
                                                        <img src="path/to/default-image.jpg" alt="Default Image" width="50">
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="statusSwitch<?php echo $row['id']; ?>" <?php echo $row['status'] == 1 ? 'checked' : ''; ?> onchange="updateStatus(<?php echo $row['id']; ?>)">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="approveSwitch<?php echo $row['id']; ?>" <?php echo $row['approve'] == 1 ? 'checked' : ''; ?> onchange="updateApprove(<?php echo $row['id']; ?>)">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-button-action">
                                                        <a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-link btn-danger">
                                                            <i class="fa fa-times"></i> Delete
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
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

   

    <?php include("../Layout/footer.php") ?>
</div>
<script>
    // Function to update the status (active/inactive) with SweetAlert
    function updateStatus(teacherId) {
        var status = document.getElementById('statusSwitch' + teacherId).checked ? 1 : 0;

        // SweetAlert confirmation before status update
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to change the status of this teacher.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, update it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to update status in database
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "view_teacher.php?update_status=1&teacher_id=" + teacherId + "&status=" + status, true);
                xhr.send();
                
                // Show success SweetAlert
                Swal.fire(
                    'Updated!',
                    'The status has been updated.',
                    'success'
                );
            } else {
                // Reset the switch if the action was cancelled
                document.getElementById('statusSwitch' + teacherId).checked = !document.getElementById('statusSwitch' + teacherId).checked;
            }
        });
    }

    // Function to update the approval status (approved/not approved) with SweetAlert
    function updateApprove(teacherId) {
        var approve = document.getElementById('approveSwitch' + teacherId).checked ? 1 : 0;

        // SweetAlert confirmation before approval update
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to change the approval status of this teacher.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, approve it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to update approval in database
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "view_teacher.php?update_approve=1&teacher_id=" + teacherId + "&approve=" + approve, true);
                xhr.send();
                
                // Show success SweetAlert
                Swal.fire(
                    'Approved!',
                    'The approval status has been updated.',
                    'success'
                );
            } else {
                // Reset the switch if the action was cancelled
                document.getElementById('approveSwitch' + teacherId).checked = !document.getElementById('approveSwitch' + teacherId).checked;
            }
        });
    }
</script>