<?php
require('header.inc.php');

// Fetch data from the database
$sql = "SELECT * FROM order_items";
$result = $conn->query($sql);

?>

<body class="hold-transition sidebar-mini">
    <!-- <?php require('sider.inc.php'); ?> -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Orders</h1>
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
                                    <th>Order_id</th>
                                    <th>Product Name</th>
                                    <th width="100">Price</th>
                                    <th width="100">Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i=1;
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $i. "</td>";
                                        echo "<td>" . $row["order_id"] . "</td>";
                                        echo "<td>" . $row["product_name"] . "</td>";
                                        echo "<td>" . $row["price"] . "</td>";
                                        echo "<td>" . $row["quantity"] . "</td>";
                                        

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
