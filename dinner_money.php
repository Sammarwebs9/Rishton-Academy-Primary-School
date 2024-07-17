<?php include 'templates/layout.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<div class="container">
    <section class="dinner-money-management">
        <h2>Dinner Money Management</h2>

        <!-- Form for adding a new dinner money entry -->
        <form method="post" action="dinner_money.php" class="form-dinner-money">
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
                <label for="amount">Amount</label>
                <input type="number" step="0.01" id="amount" name="amount" required>
            </div>
            <div class="form-group">
                <label for="payment_date">Payment Date</label>
                <input type="date" id="payment_date" name="payment_date" required>
            </div>
            <button type="submit" name="add_dinner_money" class="btn btn-primary">Add Dinner Money</button>
        </form>

        <?php
        if (isset($_POST['add_dinner_money'])) {
            $pupil_id = $_POST['pupil_id'];
            $amount = $_POST['amount'];
            $payment_date = $_POST['payment_date'];

            $sql = "INSERT INTO DinnerMoney (PupilID, Amount, PaymentDate) VALUES ('$pupil_id', '$amount', '$payment_date')";
            if ($link->query($sql) === TRUE) {
                echo "<p class='success-message'>New dinner money entry added successfully!</p>";
            } else {
                echo "<p class='error-message'>Error: " . $sql . "<br>" . $link->error . "</p>";
            }
        }
        ?>

        <h3>List of Dinner Money Entries</h3>
        <table class="dinner-money-table">
            <thead>
                <tr>
                    <th>Pupil Name</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $link->query("
                    SELECT Pupils.Name AS PupilName, DinnerMoney.Amount, DinnerMoney.PaymentDate
                    FROM DinnerMoney
                    JOIN Pupils ON DinnerMoney.PupilID = Pupils.PupilID
                ");
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['PupilName'] . "</td>
                            <td>" . $row['Amount'] . "</td>
                            <td>" . $row['PaymentDate'] . "</td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Search Dinner Money Entries</h3>
        <form method="get" action="dinner_money.php" class="form-dinner-money">
            <div class="form-group">
                <label for="search_pupil_name">Pupil Name</label>
                <input type="text" id="search_pupil_name" name="search_pupil_name" required>
            </div>
            <button type="submit" name="search_dinner_money" class="btn btn-primary">Search Dinner Money</button>
        </form>

        <?php
        if (isset($_GET['search_dinner_money'])) {
            $search_pupil_name = $_GET['search_pupil_name'];
            $sql = "
                SELECT Pupils.Name AS PupilName, DinnerMoney.Amount, DinnerMoney.PaymentDate
                FROM DinnerMoney
                JOIN Pupils ON DinnerMoney.PupilID = Pupils.PupilID
                WHERE Pupils.Name LIKE '%$search_pupil_name%'
            ";
            $result = $link->query($sql);

            if ($result->num_rows > 0) {
                echo "<h3>Search Results</h3>";
                echo "<table class='dinner-money-table'>
                        <thead>
                            <tr>
                                <th>Pupil Name</th>
                                <th>Amount</th>
                                <th>Payment Date</th>
                            </tr>
                        </thead>
                        <tbody>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['PupilName'] . "</td>
                            <td>" . $row['Amount'] . "</td>
                            <td>" . $row['PaymentDate'] . "</td>
                        </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p class='error-message'>No dinner money entries found for that pupil name.</p>";
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
