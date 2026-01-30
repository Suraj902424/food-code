<?php 
include 'loginQuery/session_start.php';
include 'dbc.php';

$pageTitle = "Table Booking List";
$pageName  = "Table Bookings";
$tableName = "orders";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $pageTitle ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include 'include/header-file.php'; ?>
    <link rel="stylesheet" href="vendor/datatables.net-bs/css/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" href="vendor/sweetalert/lib/sweet-alert.css" />
</head>
<body>

<?php include 'include/header.php'; ?>
<?php include 'include/side-menu.php'; ?>

<div id="wrapper">
    <div class="small-header">
        <div class="hpanel">
            <div class="panel-body">
                <h2 class="font-light m-b-xs"><?= $pageName ?></h2>
                <small><?= $pageTitle ?></small>
            </div>
        </div>
    </div>

<?php
session_start();
require_once '../config.php';

// if (!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit; }

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);
    $status   = $_POST['status'];
    $expected = !empty($_POST['expected_delivery_date']) ? $_POST['expected_delivery_date'] : NULL;

    $stmt = $conn->prepare("UPDATE orders SET status=?, expected_delivery_date=? WHERE id=?");
    $stmt->bind_param("ssi", $status, $expected, $order_id);
    $stmt->execute();
    header("Location: order-list.php"); // refresh to show updated data
    exit;
}

// Fetch all orders
$query = "
SELECT o.id, o.user_id, o.address, o.state, o.city, o.pincode,
       o.phone, o.payment_method, o.status, o.expected_delivery_date, o.created_at,
       u.name AS customer_name, u.email
FROM orders o
JOIN users u ON o.user_id = u.id
ORDER BY o.id DESC
";
$result = $conn->query($query);
$orders = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin - Orders</title>
<!-- Removed duplicate Bootstrap link here because it's already in header-file.php -->
</head>
<body class="bg-light">
<div class="container py-5 order-management-panel">
    <h2 class="mb-5 text-center text-dark fw-bolder">Order Management Dashboard 📝</h2>
    
    <?php if (count($orders) > 0): ?>
        <div class="accordion accordion-flush" id="ordersAccordion">
            <?php foreach ($orders as $order): ?>
                <div class="accordion-item mb-4 shadow-lg rounded-3 order-item-card">
                    <h2 class="accordion-header" id="heading<?= $order['id'] ?>">
                        <button class="accordion-button collapsed order-header-button px-4 py-3" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse<?= $order['id'] ?>" aria-expanded="false"
                                aria-controls="collapse<?= $order['id'] ?>">
                            <div class="d-flex align-items-center w-100 flex-wrap flex-sm-nowrap">
                                <div class="me-4 text-start order-id-display d-none d-sm-block">
                                    <span class="d-block text-muted small">Order ID</span>
                                    <span class="fw-bold fs-5 text-dark">#<?= $order['id'] ?></span>
                                </div>
                                <div class="me-auto text-start customer-info-display px-3 border-start border-end">
                                    <span class="d-block text-muted small">Customer</span>
                                    <span class="fw-medium text-dark-emphasis"><?= htmlspecialchars($order['customer_name']) ?></span>
                                </div>

                                <?php
                                    $statusClass = match($order['status']) {
                                        'Pending' => 'bg-warning text-dark',
                                        'Confirmed' => 'bg-info text-white',
                                        'Delivered' => 'bg-success text-white',
                                        'Undelivered' => 'bg-danger text-white',
                                        default => 'bg-secondary text-white'
                                    };
                                ?>
                                <span class="badge rounded-pill status-pill-badge me-4 <?= $statusClass ?>"><?= htmlspecialchars($order['status']) ?></span>

                                <div class="text-end order-date-display d-none d-md-block">
                                    <span class="d-block text-muted small">Order Date</span>
                                    <small class="text-dark fw-medium"><?= date('d-M-Y H:i', strtotime($order['created_at'])) ?></small>
                                </div>
                            </div>
                        </button>
                    </h2>

                    <div id="collapse<?= $order['id'] ?>" class="accordion-collapse collapse"
                        aria-labelledby="heading<?= $order['id'] ?>" data-bs-parent="#ordersAccordion">
                        <div class="accordion-body p-4 details-body-bg">
                            
                            <div class="row mb-4 text-dark-emphasis border-bottom pb-3">
                                <div class="col-md-6 mb-3">
                                    <h5 class="fw-bold mb-2 text-primary-emphasis">Shipping Details</h5>
                                    <p class="mb-1 text-break"><strong>Address:</strong> <?= htmlspecialchars($order['address']) ?>, <?= htmlspecialchars($order['city']) ?>, <?= htmlspecialchars($order['state']) ?> - <?= htmlspecialchars($order['pincode']) ?></p>
                                    <p class="mb-1"><strong>Phone:</strong> <?= htmlspecialchars($order['phone']) ?></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h5 class="fw-bold mb-2 text-primary-emphasis">Payment & Delivery</h5>
                                    <p class="mb-1"><strong>Payment Method:</strong> <span class="badge bg-light text-dark border payment-badge"><?= htmlspecialchars($order['payment_method']) ?></span></p>
                                    <p class="mb-0"><strong>Expected Delivery:</strong> <?= $order['expected_delivery_date'] ? date('d-M-Y', strtotime($order['expected_delivery_date'])) : 'Not set' ?></p>
                                </div>
                            </div>

                            <h5 class="fw-bold mb-3 text-secondary">Products Ordered</h5>
                            <?php
                            // PHP Code for fetching items remains here. Assuming $conn is available.
                            $itemQuery = "
                            SELECT oi.*, p.name, p.image1
                            FROM order_items oi
                            JOIN tbl_product p ON oi.product_id = p.id
                            WHERE oi.order_id = ?";
                            $stmt = $conn->prepare($itemQuery);
                            $stmt->bind_param("i", $order['id']);
                            $stmt->execute();
                            $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                            ?>

                            <div class="table-responsive mb-4 rounded-3 border">
                                <table class="table table-hover table-striped align-middle mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Product</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-end">Price</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $grand = 0; foreach ($items as $it):
                                            $grand += $it['total'];
                                            $img = !empty($it['image1']) ? '../admin/uploads/products/'.$it['image1'] : '../assets/img/food/default.jpg';
                                        ?>
                                        <tr>
                                            <td>
                                                <img src="<?= $img ?>" alt="Product" class="product-thumb-img me-3">
                                                <?= htmlspecialchars($it['name']) ?>
                                            </td>
                                            <td class="text-center fw-medium"><?= $it['quantity'] ?></td>
                                            <td class="text-end text-success fw-medium">₹<?= number_format($it['price'],2) ?></td>
                                            <td class="text-end fw-bold text-dark">₹<?= number_format($it['total'],2) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <tr class="table-primary-subtle border-top border-primary">
                                            <td colspan="3" class="text-end fw-bolder fs-5 text-dark">Grand Total:</td>
                                            <td class="text-end fw-bolder fs-5 text-dark">₹<?= number_format($grand,2) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h5 class="fw-bold mb-3 text-secondary">Update Order Status</h5>
                            <form method="post" class="status-update-form p-3 border rounded-3 bg-light">
                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold text-dark">Status</label>
                                        <select name="status" class="form-select status-select">
                                            <option value="Pending" <?= $order['status']=='Pending'?'selected':''; ?>>Pending</option>
                                            <option value="Confirmed" <?= $order['status']=='Confirmed'?'selected':''; ?>>Confirmed</option>
                                            <option value="Delivered" <?= $order['status']=='Delivered'?'selected':''; ?>>Delivered</option>
                                            <option value="Undelivered" <?= $order['status']=='Undelivered'?'selected':''; ?>>Undelivered</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold text-dark">Expected Delivery Date</label>
                                        <input type="date" name="expected_delivery_date" class="form-control"
                                                value="<?= $order['expected_delivery_date'] ?>">
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">💾 Update Order</button>
                                    </div>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center py-5 rounded-3 shadow-sm">
            <h4 class="alert-heading">No Orders Found! 📦</h4>
            <p class="mb-0">There are no orders to display at this moment. Check back later!</p>
        </div>
    <?php endif; ?>
</div>

<style>
/* --- General Styling --- */
/* General Body & Container */
body {
    font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    background-color: #f8f9fa; /* Light background for the whole page */
    color: #343a40;
}

.order-management-panel {
    max-width: 1200px;
    margin: 3rem auto;
    padding: 2rem;
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
}

h2.mb-5 {
    color: #2c3e50; /* Darker blue for headings */
    font-size: 2.5rem;
    position: relative;
    padding-bottom: 15px;
}

h2.mb-5::after {
    content: '';
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    bottom: 0;
    width: 80px;
    height: 4px;
    background-color: #007bff; /* Primary color accent */
    border-radius: 2px;
}

/* Accordion Item & Header */
.order-item-card {
    border: none;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07);
}

.order-item-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    transform: translateY(-3px);
}

.accordion-button {
    background-color: #e9f7fe; /* Light blue header background */
    color: #2c3e50;
    border: none;
    font-weight: 600;
    padding: 1.25rem 1.5rem;
    transition: background-color 0.3s ease;
}

.accordion-button:not(.collapsed) {
    background-color: #d0efff; /* Slightly darker when open */
    color: #0056b3;
    box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.125);
}

.accordion-button:focus {
    box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
    border-color: #86b7fe;
}

.order-header-button .d-block.text-muted {
    font-size: 0.75rem;
    margin-bottom: 3px;
    color: #6c757d !important;
}

.order-header-button .fw-bold.fs-5 {
    color: #007bff !important; /* Primary color for Order ID */
}

.order-header-button .fw-medium {
    color: #495057 !important;
}

/* Status Badges */
.status-pill-badge {
    padding: 0.5em 0.9em;
    font-size: 0.85rem;
    font-weight: 600;
    min-width: 90px;
    text-align: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.status-pill-badge.bg-warning {
    background-color: #ffc107 !important;
    color: #343a40 !important;
}
.status-pill-badge.bg-info {
    background-color: #17a2b8 !important;
    color: #fff !important;
}
.status-pill-badge.bg-success {
    background-color: #28a745 !important;
    color: #fff !important;
}
.status-pill-badge.bg-danger {
    background-color: #dc3545 !important;
    color: #fff !important;
}
.status-pill-badge.bg-secondary {
    background-color: #6c757d !important;
    color: #fff !important;
}

/* Accordion Body */
.details-body-bg {
    background-color: #fefefe;
    border-top: 1px solid #e0e0e0;
}

.details-body-bg .text-dark-emphasis {
    color: #343a40 !important;
}

h5.text-primary-emphasis {
    color: #007bff !important;
    font-size: 1.3rem;
    margin-bottom: 1rem;
}

h5.text-secondary {
    color: #495057 !important;
    font-size: 1.3rem;
    margin-bottom: 1rem;
}

.payment-badge {
    background-color: #e2f0ff !important;
    color: #0056b3 !important;
    border: 1px solid #a8d7ff !important;
    font-weight: 500;
    padding: 0.4em 0.7em;
}

/* Product Table */
.product-thumb-img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.table-responsive {
    border-radius: 10px !important;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.table {
    --bs-table-bg: #fdfdfd;
    --bs-table-hover-bg: #f5fafd;
    --bs-table-striped-bg: #f9fcff;
}

.table-dark th {
    background-color: #2c3e50;
    color: #ffffff;
    border-color: #3f5872;
    padding: 1rem 1.2rem;
}

.table tbody tr td {
    padding: 0.8rem 1.2rem;
    vertical-align: middle;
}

.table-primary-subtle {
    background-color: #e0f2ff !important;
}

.table-primary-subtle td {
    color: #0056b3 !important;
}

/* Status Update Form */
.status-update-form {
    background-color: #f8f9fa !important;
    border: 1px solid #e0e0e0 !important;
    padding: 1.5rem !important;
    border-radius: 10px !important;
}

.status-update-form .form-label {
    font-size: 0.9rem;
    color: #495057;
    margin-bottom: 0.5rem;
}

.form-select, .form-control {
    border-radius: 8px;
    padding: 0.75rem 1rem;
    border: 1px solid #ced4da;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.form-select:focus, .form-control:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    border-radius: 8px;
    transition: background-color 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
    transform: translateY(-1px);
}

/* No Orders Alert */
.alert-info {
    background-color: #e0f2f7;
    color: #0d6efd;
    border-color: #bee5eb;
}

.alert-heading {
    color: #0a58ca;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .order-management-panel {
        padding: 1rem;
        margin: 1rem auto;
    }

    h2.mb-5 {
        font-size: 2rem;
    }

    .order-header-button .d-flex {
        flex-wrap: wrap;
    }

    .order-header-button .me-4.text-start.d-none.d-sm-block {
        width: 100%;
        margin-bottom: 10px;
        border-bottom: 1px solid rgba(0,0,0,0.1);
        padding-bottom: 5px;
    }

    .order-header-button .me-auto.text-start.px-3 {
        width: calc(100% - 100px); /* Adjust based on badge width */
        border-left: none !important;
        border-right: none !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    .status-pill-badge {
        margin-left: auto;
        margin-right: 0 !important;
    }

    .order-header-button .text-end.d-none.d-md-block {
        display: none !important;
    }

    .status-update-form .col-md-4 {
        margin-bottom: 1rem;
    }

    .status-update-form .col-md-4:last-child {
        margin-bottom: 0;
    }
}

@media (max-width: 576px) {
    .accordion-button .d-flex {
        flex-direction: column;
        align-items: flex-start !important;
    }
    .order-header-button .me-4.text-start.d-none.d-sm-block,
    .order-header-button .me-auto.text-start.px-3 {
        width: 100%;
        margin-bottom: 0.5rem;
        padding-bottom: 0.5rem;
        border-bottom: none !important;
        padding-left: 0 !important;
    }
    .status-pill-badge {
        width: auto;
        align-self: flex-start;
        margin-top: 0.5rem;
    }
}
</style>
<?php include 'include/footer-file.php'; ?>

<!-- JS Files -->
<script src="vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
<script src="vendor/select2-3.5.2/select2.min.js"></script>
<!-- App scripts -->
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="vendor/sweetalert/lib/sweet-alert.css" />
<script src="vendor/sweetalert/lib/sweet-alert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).on('click', '.demo3', function() {
        var path = $(this).attr('path');

        swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!"
            },
            function() {
                window.location.href = path
            });
    });
</script>



<!--<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.0.3.js"></script>-->




<script>
    $(function() {



        $("#form_2").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3
                },
                username: {
                    required: true,
                    minlength: 5
                },
                url: {
                    required: true,
                    url: true
                },
                number: {
                    required: true,
                    number: true
                },
                last_name: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                number: {
                    required: "(Please enter your phone number)",
                    number: "(Please enter valid phone number)"
                },
                last_name: {
                    required: "This is custom message for required",
                    minlength: "This is custom message for min length"
                }
            },
            submitHandler: function(form) {
                form.submit();
            },
            errorPlacement: function(error, element) {
                $(element)
                    .closest("form")
                    .find("label[for='" + element.attr("id") + "']")
                    .append(error);
            },
            errorElement: "span",
        });


    });
</script>
<!-- DataTables -->
<script src="vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="vendor/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- DataTables buttons scripts -->
<script src="vendor/pdfmake/build/pdfmake.min.js"></script>
<script src="vendor/pdfmake/build/vfs_fonts.js"></script>
<script src="vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="vendor/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>

<script>
    $(function() {

        // Initialize Example 1
        $('#example1').dataTable({
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [{
                    extend: 'copy',
                    className: 'btn-sm'
                },
                {
                    extend: 'csv',
                    title: 'ExampleFile',
                    className: 'btn-sm'
                },
                {
                    extend: 'pdf',
                    title: 'ExampleFile',
                    className: 'btn-sm'
                },
                {
                    extend: 'print',
                    className: 'btn-sm'
                }
            ]
        });

        // Initialize Example 2
        $('#example2').dataTable();

    });
</script>
<!-- ================== -->
<script>
    $(function() {

        $('#datepicker').datepicker();
        $("#datepicker").on("changeDate", function(event) {
            $("#my_hidden_input").val(
                $("#datepicker").datepicker('getFormattedDate')
            )
        });

        $('#datapicker2').datepicker();
        $('.input-group.date').datepicker({});
        $('.input-daterange').datepicker({});

        $("#demo1").TouchSpin({
            min: 0,
            max: 100,
            step: 0.1,
            decimals: 2,
            boostat: 5,
            maxboostedstep: 10,
        });

        $("#demo2").TouchSpin({
            verticalbuttons: true
        });

        $("#demo3").TouchSpin({
            postfix: '%'
        });

        $("#demo4").TouchSpin({
            postfix: "a button",
            postfix_extraclass: "btn btn-default"
        });

        $(".js-source-states").select2();
        $(".js-source-states-2").select2();

        //turn to inline mode
        $.fn.editable.defaults.mode = 'inline';

        //defaults
        $.fn.editable.defaults.url = '#';

        //editables
        $('#username').editable({
            url: '#',
            type: 'text',
            pk: 1,
            name: 'username',
            title: 'Enter username'
        });

        $('#firstname').editable({
            validate: function(value) {
                if ($.trim(value) == '') return 'This field is required';
            }
        });

        $('#sex').editable({
            prepend: "not selected",
            source: [{
                    value: 1,
                    text: 'Male'
                },
                {
                    value: 2,
                    text: 'Female'
                }
            ],
            display: function(value, sourceData) {
                var colors = {
                        "": "gray",
                        1: "green",
                        2: "blue"
                    },
                    elem = $.grep(sourceData, function(o) {
                        return o.value == value;
                    });

                if (elem.length) {
                    $(this).text(elem[0].text).css("color", colors[value]);
                } else {
                    $(this).empty();
                }
            }
        });

        $('#dob').editable();

        $('#event').editable({
            placement: 'right',
            combodate: {
                firstItem: 'name'
            }
        });

        $('#comments').editable({
            showbuttons: 'bottom'
        });

        $('#fruits').editable({
            pk: 1,
            limit: 3,
            source: [{
                    value: 1,
                    text: 'banana'
                },
                {
                    value: 2,
                    text: 'peach'
                },
                {
                    value: 3,
                    text: 'apple'
                },
                {
                    value: 4,
                    text: 'watermelon'
                },
                {
                    value: 5,
                    text: 'orange'
                }
            ]
        });

        $('#user .editable').on('hidden', function(e, reason) {
            if (reason === 'save' || reason === 'nochange') {
                var $next = $(this).closest('tr').next().find('.editable');
                if ($('#autoopen').is(':checked')) {
                    setTimeout(function() {
                        $next.editable('show');
                    }, 300);
                } else {
                    $next.focus();
                }
            }
        });

        // ClockPicker
        $('.clockpicker').clockpicker({
            autoclose: true
        });

        // DateTimePicker
        $('#datetimepicker1').datetimepicker();

    });
</script>