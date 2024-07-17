<?php include 'templates/layout.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<div class="container">
    <section class="pupils-management">
        <h2>Pupil Management</h2>
        <form method="post" action="pupils.php" class="form-pupil">
            <div class="form-group">
                <label for="name">Pupil Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="medical_info">Medical Information</label>
                <textarea id="medical_info" name="medical_info" required></textarea>
            </div>
            <div class="form-group">
                <label for="class_id">Class</label>
                <select id="class_id" name="class_id" required>
                    <option value="">Select a class</option>
                    <?php
                    $result = $link->query("SELECT ClassID, ClassName FROM Classes");
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['ClassID'] . "'>" . $row['ClassName'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="add_pupil" class="btn btn-primary">Add Pupil</button>
        </form>

        <?php
        if (isset($_POST['add_pupil'])) {
            $name = $_POST['name'];
            $address = $_POST['address'];
            $medical_info = $_POST['medical_info'];
            $class_id = $_POST['class_id'];

            $sql = "INSERT INTO Pupils (Name, Address, MedicalInfo, ClassID) VALUES ('$name', '$address', '$medical_info', '$class_id')";
            if ($link->query($sql) === TRUE) {
                echo "<p class='success-message'>New pupil added successfully!</p>";
            } else {
                echo "<p class='error-message'>Error: " . $sql . "<br>" . $link->error . "</p>";
            }
        }
        ?>

        <h3>List of Pupils</h3>
        <table class="pupils-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Medical Info</th>
                    <th>Class</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $link->query("SELECT Pupils.Name, Pupils.Address, Pupils.MedicalInfo, Classes.ClassName FROM Pupils JOIN Classes ON Pupils.ClassID = Classes.ClassID");
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['Name'] . "</td>
                            <td>" . $row['Address'] . "</td>
                            <td>" . $row['MedicalInfo'] . "</td>
                            <td>" . $row['ClassName'] . "</td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <section class="pupils-search">
        <h2>Search Pupil</h2>
        <form method="get" action="pupils.php" class="form-search-pupil">
            <div class="form-group">
                <label for="search_name">Pupil Name</label>
                <input type="text" id="search_name" name="search_name" required>
            </div>
            <button type="submit" name="search_pupil" class="btn btn-primary">Search Pupil</button>
        </form>

        <?php
        if (isset($_GET['search_pupil'])) {
            $search_name = $_GET['search_name'];
            $sql = "SELECT Pupils.Name, Pupils.Address, Pupils.MedicalInfo, Classes.ClassName FROM Pupils JOIN Classes ON Pupils.ClassID = Classes.ClassID WHERE Pupils.Name LIKE '%$search_name%'";
            $result = $link->query($sql);
            if ($result->num_rows > 0) {
                echo "<h3>Search Results</h3>";
                echo "<table class='pupils-table'>";
                echo "<thead>
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Medical Info</th>
                            <th>Class</th>
                        </tr>
                    </thead>";
                echo "<tbody>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['Name'] . "</td>
                            <td>" . $row['Address'] . "</td>
                            <td>" . $row['MedicalInfo'] . "</td>
                            <td>" . $row['ClassName'] . "</td>
                        </tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p class='error-message'>No pupils found with that name.</p>";
            }
        }
        ?>
    </section>
</div>
