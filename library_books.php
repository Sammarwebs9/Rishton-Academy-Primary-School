<?php include 'templates/layout.php'; ?>
<?php include 'includes/db_connect.php'; ?>

<div class="container">
    <section class="library-books-management">
        <h2>Library Books Management</h2>

        <!-- Form for adding a new library book -->
        <form method="post" action="library_books.php" class="form-library-book">
            <div class="form-group">
                <label for="title">Book Title</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" id="author" name="author" required>
            </div>
            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" id="isbn" name="isbn">
            </div>
            <div class="form-group">
                <label for="available_copies">Available Copies</label>
                <input type="number" id="available_copies" name="available_copies" required>
            </div>
            <button type="submit" name="add_library_book" class="btn btn-primary">Add Book</button>
        </form>

        <?php
        if (isset($_POST['add_library_book'])) {
            $title = $_POST['title'];
            $author = $_POST['author'];
            $isbn = $_POST['isbn'];
            $available_copies = $_POST['available_copies'];

            $sql = "INSERT INTO LibraryBooks (Title, Author, ISBN, AvailableCopies) VALUES ('$title', '$author', '$isbn', '$available_copies')";
            if ($link->query($sql) === TRUE) {
                echo "<p class='success-message'>New book added successfully!</p>";
            } else {
                echo "<p class='error-message'>Error: " . $sql . "<br>" . $link->error . "</p>";
            }
        }
        ?>

        <h3>List of Library Books</h3>
        <table class="library-books-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>ISBN</th>
                    <th>Available Copies</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $link->query("SELECT * FROM LibraryBooks");
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['Title'] . "</td>
                            <td>" . $row['Author'] . "</td>
                            <td>" . $row['ISBN'] . "</td>
                            <td>" . $row['AvailableCopies'] . "</td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Search Library Books</h3>
        <form method="get" action="library_books.php" class="form-library-book">
            <div class="form-group">
                <label for="search_title">Book Title</label>
                <input type="text" id="search_title" name="search_title" required>
            </div>
            <button type="submit" name="search_library_book" class="btn btn-primary">Search Book</button>
        </form>

        <?php
        if (isset($_GET['search_library_book'])) {
            $search_title = $_GET['search_title'];
            $sql = "SELECT * FROM LibraryBooks WHERE Title LIKE '%$search_title%'";
            $result = $link->query($sql);

            if ($result->num_rows > 0) {
                echo "<h3>Search Results</h3>";
                echo "<table class='library-books-table'>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>ISBN</th>
                                <th>Available Copies</th>
                            </tr>
                        </thead>
                        <tbody>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['Title'] . "</td>
                            <td>" . $row['Author'] . "</td>
                            <td>" . $row['ISBN'] . "</td>
                            <td>" . $row['AvailableCopies'] . "</td>
                        </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p class='error-message'>No books found with that title.</p>";
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
