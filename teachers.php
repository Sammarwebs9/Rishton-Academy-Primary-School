<?php include 'templates/layout.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<div class="container">
    <section class="teachers-management">
        <h2>Teacher Management</h2>

        <!-- Form for adding a new teacher -->
        <form method="post" action="teachers.php" class="form-teacher">
            <div class="form-group">
                <label for="name">Teacher Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone">
            </div>
            <div class="form-group">
                <label for="annual_salary">Annual Salary</label>
                <input type="number" step="0.01" id="annual_salary" name="annual_salary">
            </div>
            <div class="form-group">
                <label for="background_check">Background Check</label>
                <input type="text" id="background_check" name="background_check">
            </div>
            <button type="submit" name="add_teacher" class="btn btn-primary">Add Teacher</button>
        </form>

        <?php
        if (isset($_POST['add_teacher'])) {
            $name = $_POST['name'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];
            $annual_salary = $_POST['annual_salary'];
            $background_check = $_POST['background_check'];

            $sql = "INSERT INTO Teachers (Name, Address, Phone, AnnualSalary, BackgroundCheck) VALUES ('$name', '$address', '$phone', '$annual_salary', '$background_check')";
            if ($link->query($sql) === TRUE) {
                echo "<p class='success-message'>New teacher added successfully!</p>";
            } else {
                echo "<p class='error-message'>Error: " . $sql . "<br>" . $link->error . "</p>";
            }
        }
        ?>

        <h3>List of Teachers</h3>
        <table class="teachers-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Annual Salary</th>
                    <th>Background Check</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $link->query("SELECT * FROM Teachers");
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['Name'] . "</td>
                            <td>" . $row['Address'] . "</td>
                            <td>" . $row['Phone'] . "</td>
                            <td>" . $row['AnnualSalary'] . "</td>
                            <td>" . $row['BackgroundCheck'] . "</td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Search Teachers</h3>
        <form method="get" action="teachers.php" class="form-teacher">
            <div class="form-group">
                <label for="search_name">Teacher Name</label>
                <input type="text" id="search_name" name="search_name" required>
            </div>
            <button type="submit" name="search_teacher" class="btn btn-primary">Search Teacher</button>
        </form>

        <?php
        if (isset($_GET['search_teacher'])) {
            $search_name = $_GET['search_name'];
            $sql = "SELECT * FROM Teachers WHERE Name LIKE '%$search_name%'";
            $result = $link->query($sql);

            if ($result->num_rows > 0) {
                echo "<h3>Search Results</h3>";
                echo "<table class='teachers-table'>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Annual Salary</th>
                                <th>Background Check</th>
                            </tr>
                        </thead>
                        <tbody>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['Name'] . "</td>
                            <td>" . $row['Address'] . "</td>
                            <td>" . $row['Phone'] . "</td>
                            <td>" . $row['AnnualSalary'] . "</td>
                            <td>" . $row['BackgroundCheck'] . "</td>
                        </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p class='error-message'>No teachers found with that name.</p>";
            }
        }
        ?>
    </section>
</div>

</main>
<footer>
    <div class="container">
        <p>&copy; 2024 School Management System. All Rights Reserved.</p>
    </div>
</footer>
</body>
</html>
