<?php include 'includes/db_connect.php'; ?>

<?php
if (isset($_GET['staff_type'])) {
    $staff_type = $_GET['staff_type'];
    
    if ($staff_type == 'Teacher') {
        $result = $link->query("SELECT TeacherID AS id, Name AS name FROM Teachers");
    } else if ($staff_type == 'TeachingAssistant') {
        $result = $link->query("SELECT TAID AS id, Name AS name FROM TeachingAssistants");
    }

    $staff = [];
    while($row = $result->fetch_assoc()) {
        $staff[] = $row;
    }

    echo json_encode($staff);
}
?>
