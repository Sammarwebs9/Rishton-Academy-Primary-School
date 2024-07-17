<?php include 'templates/layout.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<div class="container">
    <section class="pupil-parents-management">
        <h2>Pupil-Parent Management</h2>

        <!-- Form for linking a pupil with a parent -->
        <form method="post" action="pupil_parents.php" class="form-pupil-parent">
            <div class="form-group">
                <label for="pupil_id">Pupil</label>
                <select id="pupil_id" name="pupil_id" required>
                    <option value="">Select a pupil</option>
                    <?php
                    $result = $link->query("SELECT PupilID, Name FROM Pupils");
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['PupilID'] . "'>" . $row['Name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="parent_id">Parent</label>
                <select id="parent_id" name="parent_id" required>
                    <option value="">Select a parent</option>
                    <?php
                    $result = $link->query("SELECT ParentID, Name FROM Parents");
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['ParentID'] . "'>" . $row['Name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="link_pupil_parent" class="btn btn-primary">Link Pupil with Parent</button>
        </form>

        <?php
        if (isset($_POST['link_pupil_parent'])) {
            $pupil_id = $_POST['pupil_id'];
            $parent_id = $_POST['parent_id'];

            $sql = "INSERT INTO PupilParent (PupilID, ParentID) VALUES ('$pupil_id', '$parent_id')";
            if ($link->query($sql) === TRUE) {
                echo "<p class='success-message'>Pupil linked with parent successfully!</p>";
            } else {
                echo "<p class='error-message'>Error: " . $sql . "<br>" . $link->error . "</p>";
            }
        }
        ?>

        <h3>List of Pupil-Parent Relationships</h3>
        <table class="pupil-parents-table">
            <thead>
                <tr>
                    <th>Pupil Name</th>
                    <th>Parent Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $link->query("
                    SELECT Pupils.Name AS PupilName, Parents.Name AS ParentName 
                    FROM PupilParent 
                    JOIN Pupils ON PupilParent.PupilID = Pupils.PupilID 
                    JOIN Parents ON PupilParent.ParentID = Parents.ParentID
                ");
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['PupilName'] . "</td>
                            <td>" . $row['ParentName'] . "</td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Search Pupil-Parent Relationships</h3>
        <form method="get" action="pupil_parents.php" class="form-pupil-parent">
            <div class="form-group">
                <label for="search_pupil_name">Pupil Name</label>
                <input type="text" id="search_pupil_name" name="search_pupil_name" required>
            </div>
            <button type="submit" name="search_pupil_parent" class="btn btn-primary">Search</button>
        </form>

        <?php
        if (isset($_GET['search_pupil_parent'])) {
            $search_pupil_name = $_GET['search_pupil_name'];
            $sql = "
                SELECT Pupils.Name AS PupilName, Parents.Name AS ParentName 
                FROM PupilParent 
                JOIN Pupils ON PupilParent.PupilID = Pupils.PupilID 
                JOIN Parents ON PupilParent.ParentID = Parents.ParentID
                WHERE Pupils.Name LIKE '%$search_pupil_name%'
            ";
            $result = $link->query($sql);

            if ($result->num_rows > 0) {
                echo "<h3>Search Results</h3>";
                echo "<table class='pupil-parents-table'>
                        <thead>
                            <tr>
                                <th>Pupil Name</th>
                                <th>Parent Name</th>
                            </tr>
                        </thead>
                        <tbody>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['PupilName'] . "</td>
                            <td>" . $row['ParentName'] . "</td>
                        </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p class='error-message'>No relationships found with that pupil name.</p>";
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
