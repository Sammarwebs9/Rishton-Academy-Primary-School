<?php include 'templates/layout.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<div class="container">
    <section class="salaries-management">
        <h2>Salaries Management</h2>

        <!-- Form for adding a new salary -->
        <form method="post" action="salaries.php" class="form-salary">
            <div class="form-group">
                <label for="staff_type">Staff Type</label>
                <select id="staff_type" name="staff_type" required>
                    <option value="">Select a staff type</option>
                    <option value="Teacher">Teacher</option>
                    <option value="TeachingAssistant">Teaching Assistant</option>
                </select>
            </div>
            <div class="form-group">
                <label for="staff_id">Staff</label>
                <select id="staff_id" name="staff_id" required>
                    <option value="">Select a staff member</option>
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" step="0.01" id="amount" name="amount" required>
            </div>
            <div class="form-group">
                <label for="payment_date">Payment Date</label>
                <input type="date" id="payment_date" name="payment_date" required>
            </div>
            <button type="submit" name="add_salary" class="btn btn-primary">Add Salary</button>
        </form>

        <?php
        if (isset($_POST['add_salary'])) {
            $staff_type = $_POST['staff_type'];
            $staff_id = $_POST['staff_id'];
            $amount = $_POST['amount'];
            $payment_date = $_POST['payment_date'];

            $sql = "INSERT INTO Salaries (StaffType, StaffID, Amount, PaymentDate) VALUES ('$staff_type', '$staff_id', '$amount', '$payment_date')";
            if ($link->query($sql) === TRUE) {
                echo "<p class='success-message'>New salary added successfully!</p>";
            } else {
                echo "<p class='error-message'>Error: " . $sql . "<br>" . $link->error . "</p>";
            }
        }
        ?>

        <h3>List of Salaries</h3>
        <table class="salaries-table">
            <thead>
                <tr>
                    <th>Staff Type</th>
                    <th>Staff Name</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $link->query("
                    SELECT Salaries.StaffType, 
                           IF(Salaries.StaffType='Teacher', Teachers.Name, TeachingAssistants.Name) AS StaffName,
                           Salaries.Amount, Salaries.PaymentDate
                    FROM Salaries
                    LEFT JOIN Teachers ON Salaries.StaffType='Teacher' AND Salaries.StaffID=Teachers.TeacherID
                    LEFT JOIN TeachingAssistants ON Salaries.StaffType='TeachingAssistant' AND Salaries.StaffID=TeachingAssistants.TAID
                ");
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['StaffType'] . "</td>
                            <td>" . $row['StaffName'] . "</td>
                            <td>" . $row['Amount'] . "</td>
                            <td>" . $row['PaymentDate'] . "</td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Search Salaries</h3>
        <form method="get" action="salaries.php" class="form-salary">
            <div class="form-group">
                <label for="search_staff_type">Staff Type</label>
                <select id="search_staff_type" name="search_staff_type" required>
                    <option value="">Select a staff type</option>
                    <option value="Teacher">Teacher</option>
                    <option value="TeachingAssistant">Teaching Assistant</option>
                </select>
            </div>
            <div class="form-group">
                <label for="search_name">Staff Name</label>
                <input type="text" id="search_name" name="search_name" required>
            </div>
            <button type="submit" name="search_salary" class="btn btn-primary">Search Salary</button>
        </form>

        <?php
        if (isset($_GET['search_salary'])) {
            $search_staff_type = $_GET['search_staff_type'];
            $search_name = $_GET['search_name'];
            $sql = "
                SELECT Salaries.StaffType, 
                       IF(Salaries.StaffType='Teacher', Teachers.Name, TeachingAssistants.Name) AS StaffName,
                       Salaries.Amount, Salaries.PaymentDate
                FROM Salaries
                LEFT JOIN Teachers ON Salaries.StaffType='Teacher' AND Salaries.StaffID=Teachers.TeacherID
                LEFT JOIN TeachingAssistants ON Salaries.StaffType='TeachingAssistant' AND Salaries.StaffID=TeachingAssistants.TAID
                WHERE Salaries.StaffType='$search_staff_type'
                  AND (Teachers.Name LIKE '%$search_name%' OR TeachingAssistants.Name LIKE '%$search_name%')
            ";
            $result = $link->query($sql);

            if ($result->num_rows > 0) {
                echo "<h3>Search Results</h3>";
                echo "<table class='salaries-table'>
                        <thead>
                            <tr>
                                <th>Staff Type</th>
                                <th>Staff Name</th>
                                <th>Amount</th>
                                <th>Payment Date</th>
                            </tr>
                        </thead>
                        <tbody>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['StaffType'] . "</td>
                            <td>" . $row['StaffName'] . "</td>
                            <td>" . $row['Amount'] . "</td>
                            <td>" . $row['PaymentDate'] . "</td>
                        </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p class='error-message'>No salaries found for that name.</p>";
            }
        }
        ?>
    </section>
</div>

<script>
document.getElementById('staff_type').addEventListener('change', function() {
    var staffType = this.value;
    var staffSelect = document.getElementById('staff_id');
    staffSelect.innerHTML = '<option value="">Select a staff member</option>';
    
    if (staffType) {
        fetch('fetch_staff.php?staff_type=' + staffType)
            .then(response => response.json())
            .then(data => {
                data.forEach(staff => {
                    var option = document.createElement('option');
                    option.value = staff.id;
                    option.text = staff.name;
                    staffSelect.add(option);
                });
            });
    }
});
</script>

</main>
<footer>
    <div class="container">
        <p>&copy; 2024 School Management System. All Rights Reserved.</p>
    </div>
</footer>
</body>
</html>
