<?php
require('header.inc.php');

// Fetch data from the database
$sql = "SELECT * FROM category";
$result = $conn->query($sql);

// Logic to handle category deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['category_id'])) {
    // Assuming you have a function to safely sanitize input (e.g., for an integer)
    $category_id = sanitizeInput($_POST['category_id']);

    // Perform deletion
    $deleteSql = "DELETE FROM category WHERE id = $category_id";
    if ($conn->query($deleteSql) === TRUE) {
        // Deletion successful
        // Redirect to the same page after deletion (refreshing the category list)
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Error handling if deletion fails
        echo "Error deleting record: " . $conn->error;
    }
}
?>

<body class="hold-transition sidebar-mini">
    <?php require('sider.inc.php'); ?>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Categories</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="create-category.php" class="btn btn-primary">New Category</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body table-responsive p-2">
                        <table id="myTable" class="table data-table my-2">
                            <thead>
                                <tr>
                                    <th width="60">S.NO</th>
                                    <th> Category Name</th>
                                    <th>Slug</th>
                                    <th width="100">Status</th>
                                    <th width="100">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i=1;
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $i. "</td>";
                                        echo "<td>" . $row["category_name"] . "</td>";
                                        echo "<td>" . $row["slug"] . "</td>";
                                        
                                        // Displaying status icons based on 'status' value
                                        echo "<td>";
                                        if ($row['status'] == 1) {
                                            echo "<svg class='text-success-500 h-6 w-6 text-success' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' aria-hidden='true'>
                                                    <path stroke-linecap='round' stroke-linejoin='round' d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'></path>
                                                </svg>";
                                        } else {
                                            echo "<svg class='text-danger h-6 w-6' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' aria-hidden='true'>
                                                    <path stroke-linecap='round' stroke-linejoin='round' d='M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'></path>
                                                </svg>";
                                        }
                                        echo "</td>";

                                        // Delete and update buttons
                                        echo "<td>";
                                        echo "<a href='update-category.php?id=" . $row["id"] . "' class='btn btn-sm btn-info my-2'>";
                                        echo "<svg class='filament-link-icon w-4 h-4 mr-1 icon-spacing' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor' aria-hidden='true'>
                                                <path d='M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z'></path>
                                            </svg>";
                                        echo "Update</a>";
                                        
                                        // Delete form for each category
                                        echo "<form method='POST' action='" . $_SERVER['PHP_SELF'] . "'>";
                                        echo "<input type='hidden' name='category_id' value='" . $row["id"] . "'>";
                                        echo "<button type='submit' class='delete-category text-danger' onclick=\"return confirm('Are you sure you want to delete this category?');\">
                                                <svg wire:loading.remove.delay=\"\" wire:target=\"\" class=\"filament-link-icon w-4 h-4 mr-1\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 20 20\" fill=\"currentColor\" aria-hidden=\"true\">
                                                    <path fill-rule=\"evenodd\" d=\"M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z\" clip-rule=\"evenodd\"></path>
                                                </svg>
                                                delete</button>";
                                        echo "</form>";
                                       
                                        echo "</td>";
                                        echo "</tr>";
                                        $i++;
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No categories found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php
    require("footer.inc.php");
    $conn->close();
    ?>
