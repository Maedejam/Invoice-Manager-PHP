<?php
    require "data.php";
    require "functions.php";

    $errors = [];
    $invoice= [];
    
    if($_SERVER['REQUEST_METHOD'] === "POST"){

        $invoice = sanitize($_POST);
        $errors= validate($invoice);


        if(empty($errors)){
            updateInvoice($invoice);
            header("Location: index.php");
            exit;
        }
    }else if(isset($_GET['id'])){
        $sql = "SELECT * FROM invoices WHERE number = :number";
        $stmt = $db->prepare($sql);
        $stmt->execute([':number' => $_GET['id']]);
        $invoice = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$invoice){
            header("Location: index.php");
            exit;
        }
    }else{
        header("Location: index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Invoice</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Invoice Manager</h1>
    <p>Update the invoice: </p>
    <section class="container">
        <a class="new" href="index.php">Back</a>
    </section>
    
    <section class="form">
        <form method="post" action="update.php" enctype="multipart/form-data">
        <input type="hidden" name="number" value="<?php echo $invoice['number']; ?>">
        
        <div class="form-group">
            <label for="client" class="form-detail">Client Name:  </label>
            <input type="text" name='client' required value="<?php echo $invoice['client']; ?>">
            <div class="error text-danger"><?php echo $errors['client'] ?? ''; ?></div>
        </div>

        <div class="form-group">
            <label for="email">Client Email:  </label>
            <input type="text" name="email" required value="<?php echo $invoice['email']; ?>">
            <div class="error text-danger"><?php echo $errors['email'] ?? ''; ?></div>
        </div>

        <div class="form-group">
            <label for="amount">Invoice Amount:  </label>
            <input type="amount" name="amount" required value="<?php echo $invoice['amount']; ?>">
            <div class="error text-danger"><?php echo $errors['amount'] ?? ''; ?></div>
        </div>

        <div class="form-group">
            <label for="status_id">Invoice Status:  </label>
            <select name="status_id" required>
                <option value="">Please select...</option>
                <?php foreach($statuses as $status) : ?>
                    <option value="<?php echo $status['id']; ?>"
                        <?php if($invoice['status_id'] === $status['id']): ?> selected <?php endif ?>>
                        <?php echo $status['status']; ?>
                    </option>
                <?php endforeach ?>
            </select>
            <div class="error text-danger"><?php echo $errors['status_id'] ?? ''; ?></div>
        </div>
        <div class="form-group">
                <label for="form">Upload PDF:</label>
                <input type="file" name="form" accept=".pdf">
            </div>

        <div class="form-group">
            <button class='submit'>UPDATE</button>
        </div>
        </form>    
    </section>

   
</body>
</html>