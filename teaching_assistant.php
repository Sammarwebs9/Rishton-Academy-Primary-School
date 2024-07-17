<?php include 'templates/layout.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<div class="container">
    <section class="teaching-assistant-management">
        <h2>Teaching Assistant Management</h2>

        <!-- Form for adding a new teaching assistant -->
        <form method="post" action="teaching_assistant.php" class="form-teaching-assistant">
            <div class="form-group">
                <label for="name">Teaching Assistant Name</label>
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
                <label for="salary">Salary</label>
                <input type="number" step="0.01" id="salary" name="salary">
            </div>
            <button type="submit" name="add_teaching_assistant" class="btn btn-primary">Add Teaching Assistant</button>
        </form>

        <?php
        if (isset($_POST['add_teaching_assistant'])) {
            $name = $_POST['name'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];
            $salary = $_POST['salary'];

            $sql = "INSERT INTO TeachingAssistants (Name, Address, Phone, Salary) VALUES ('$name', '$address', '$phone', '$salary')";
            if ($link->query($sql) === TRUE) {
                echo "<p class='success-message'>New teaching assistant added successfully!</p>";
            } else {
                echo "<p class='error-message'>Error: " . $sql . "<br>" . $link->error . "</p>";
            }
        }
        ?>

        <h3>List of Teaching Assistants</h3>
        <table class="teaching-assistants-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Salary</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $link->query("SELECT * FROM TeachingAssistants");
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['Name'] . "</td>
                            <td>" . $row['Address'] . "</td>
                            <td>" . $row['Phone'] . "</td>
                            <td>" . $row['Salary'] . "</td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Search Teaching Assistants</h3>
        <form method="get" action="teaching_assistant.php" class="form-teaching-assistant">
            <div class="form-group">
                <label for="search_name">Teaching Assistant Name</label>
                <input type="text" id="search_name" name="search_name" required>
            </div>
            <button type="submit" name="search_teaching_assistant" class="btn btn-primary">Search Teaching Assistant</button>
        </form>

        <?php
        if (isset($_GET['search_teaching_assistant'])) {
            $search_name = $_GET['search_name'];
            $sql = "SELECT * FROM TeachingAssistants WHERE Name LIKE '%$search_name%'";
            $result = $link->query($sql);

            if ($result->num_rows > 0) {
                echo "<h3>Search Results</h3>";
                echo "<table class='teaching-assistants-table'>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Salary</th>
                            </tr>
                        </thead>
                        <tbody>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['Name'] . "</td>
                            <td>" . $row['Address'] . "</td>
                            <td>" . $row['Phone'] . "</td>
                            <td>" . $row['Salary'] . "</td>
                        </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p class='error-message'>No teaching assistants found with that name.</p>";
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
