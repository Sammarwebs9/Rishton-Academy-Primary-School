<?php include 'templates/layout.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<div class="container">
    <section class="parents-management">
        <h2>Parent Management</h2>

        <!-- Form for adding a new parent -->
        <form method="post" action="parents.php" class="form-parent">
            <div class="form-group">
                <label for="name">Parent Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone">
            </div>
            <button type="submit" name="add_parent" class="btn btn-primary">Add Parent</button>
        </form>

        <?php
        if (isset($_POST['add_parent'])) {
            $name = $_POST['name'];
            $address = $_POST['address'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];

            $sql = "INSERT INTO Parents (Name, Address, Email, Phone) VALUES ('$name', '$address', '$email', '$phone')";
            if ($link->query($sql) === TRUE) {
                echo "<p class='success-message'>New parent added successfully!</p>";
            } else {
                echo "<p class='error-message'>Error: " . $sql . "<br>" . $link->error . "</p>";
            }
        }
        ?>

        <h3>List of Parents</h3>
        <table class="parents-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $link->query("SELECT * FROM Parents");
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['Name'] . "</td>
                            <td>" . $row['Address'] . "</td>
                            <td>" . $row['Email'] . "</td>
                            <td>" . $row['Phone'] . "</td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Search Parents</h3>
        <form method="get" action="parents.php" class="form-parent">
            <div class="form-group">
                <label for="search_name">Parent Name</label>
                <input type="text" id="search_name" name="search_name" required>
            </div>
            <button type="submit" name="search_parent" class="btn btn-primary">Search Parent</button>
        </form>

        <?php
        if (isset($_GET['search_parent'])) {
            $search_name = $_GET['search_name'];
            $sql = "SELECT * FROM Parents WHERE Name LIKE '%$search_name%'";
            $result = $link->query($sql);

            if ($result->num_rows > 0) {
                echo "<h3>Search Results</h3>";
                echo "<table class='parents-table'>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Phone</th>
                            </tr>
                        </thead>
                        <tbody>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['Name'] . "</td>
                            <td>" . $row['Address'] . "</td>
                            <td>" . $row['Email'] . "</td>
                            <td>" . $row['Phone'] . "</td>
                        </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p class='error-message'>No parents found with that name.</p>";
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
