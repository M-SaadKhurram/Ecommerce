<?php
require('header.inc.php');

// Assuming you have a database connection in connection.inc.php

// Fetch data from the database
$sql = "SELECT * FROM brands";
$result = $conn->query($sql);

// Logic to handle brand deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['brand_id'])) {
    // Assuming you have a function to safely sanitize input (e.g., for an integer)
    $brand_id = sanitizeInput($_POST['brand_id']);

    // Perform deletion
    $deleteSql = "DELETE FROM brands WHERE id = $brand_id";
    if ($conn->query($deleteSql) === TRUE) {
        // Deletion successful
        // Redirect to the same page after deletion (refreshing the brabd list)
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Error handling if deletion fails
        echo "Error deleting record: " . $conn->error;
    }
}
?>

<body class="hold-transition sidebar-mini">
    <?php require('sider.inc.php') ?>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Brands</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="create-brand.php" class="btn btn-primary">New Brand</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body table-responsive p-2">
                        <table id="myTable" class="table data-table my-2 ">
                            <thead>
                                <tr>
                                    <th width="60">S.No</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th width="100">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i=1;
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $i . "</td>";
                                        echo "<td>" . $row["brand_name"] . "</td>";
                                        echo "<td>" . $row["slug"] . "</td>";
                                        // Logic for status icons
                                        echo "<td>";
                                        echo "<a href='update-brand.php?id=" . $row["id"] . "' class='btn btn-sm btn-info my-2'>";
                                        echo "<svg class='filament-link-icon w-4 h-4 mr-1 icon-spacing' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor' aria-hidden='true'>
                                                <path d='M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z'></path>
                                            </svg>";
                                        echo "Update</a>";

                                        // Delete form for each brand
                                        echo "<form method='POST' action='" . $_SERVER['PHP_SELF'] . "'>";
                                        echo "<input type='hidden' name='brand_id' value='" . $row["id"] . "'>";
                                        echo "<button type='submit' class='delete-brand text-danger' onclick=\"return confirm('Are you sure you want to delete this brand?');\">
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
                                    echo "<tr><td colspan='5'>No brand found</td></tr>";
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