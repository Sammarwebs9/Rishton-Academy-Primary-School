<?php include 'templates/layout.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<div class="container">
    <section class="classes-management">
        <h2>Class Management</h2>

        <!-- Form for adding a new class -->
        <form method="post" action="classes.php" class="form-class">
            <div class="form-group">
                <label for="class_name">Class Name</label>
                <input type="text" id="class_name" name="class_name" required>
            </div>
            <div class="form-group">
                <label for="capacity">Capacity</label>
                <input type="number" id="capacity" name="capacity" required>
            </div>
            <div class="form-group">
                <label for="teacher_id">Teacher</label>
                <select id="teacher_id" name="teacher_id">
                    <option value="">Select a teacher</option>
                    <?php
                    $result = $link->query("SELECT TeacherID, Name FROM Teachers");
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['TeacherID'] . "'>" . $row['Name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="add_class" class="btn btn-primary">Add Class</button>
        </form>

        <?php
        if (isset($_POST['add_class'])) {
            $class_name = $_POST['class_name'];
            $capacity = $_POST['capacity'];
            $teacher_id = $_POST['teacher_id'];

            $sql = "INSERT INTO Classes (ClassName, Capacity, TeacherID) VALUES ('$class_name', '$capacity', ".($teacher_id ? "'$teacher_id'" : "NULL").")";
            if ($link->query($sql) === TRUE) {
                echo "<p class='success-message'>New class added successfully!</p>";
            } else {
                echo "<p class='error-message'>Error: " . $sql . "<br>" . $link->error . "</p>";
            }
        }
        ?>

        <h3>List of Classes</h3>
        <table class="classes-table">
            <thead>
                <tr>
                    <th>Class Name</th>
                    <th>Capacity</th>
                    <th>Teacher</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $link->query("SELECT Classes.ClassName, Classes.Capacity, Teachers.Name AS TeacherName FROM Classes LEFT JOIN Teachers ON Classes.TeacherID = Teachers.TeacherID");
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['ClassName'] . "</td>
                            <td>" . $row['Capacity'] . "</td>
                            <td>" . ($row['TeacherName'] ? $row['TeacherName'] : "No teacher assigned") . "</td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Search Classes</h3>
        <form method="get" action="classes.php" class="form-class">
            <div class="form-group">
                <label for="search_class_name">Class Name</label>
                <input type="text" id="search_class_name" name="search_class_name" required>
            </div>
            <button type="submit" name="search_class" class="btn btn-primary">Search Class</button>
        </form>

        <?php
        if (isset($_GET['search_class'])) {
            $search_class_name = $_GET['search_class_name'];
            $sql = "SELECT Classes.ClassName, Classes.Capacity, Teachers.Name AS TeacherName 
                    FROM Classes 
                    LEFT JOIN Teachers ON Classes.TeacherID = Teachers.TeacherID 
                    WHERE Classes.ClassName LIKE '%$search_class_name%'";
            $result = $link->query($sql);

            if ($result->num_rows > 0) {
                echo "<h3>Search Results</h3>";
                echo "<table class='classes-table'>
                        <thead>
                            <tr>
                                <th>Class Name</th>
                                <th>Capacity</th>
                                <th>Teacher</th>
                            </tr>
                        </thead>
                        <tbody>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['ClassName'] . "</td>
                            <td>" . $row['Capacity'] . "</td>
                            <td>" . ($row['TeacherName'] ? $row['TeacherName'] : "No teacher assigned") . "</td>
                        </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p class='error-message'>No classes found with that name.</p>";
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
