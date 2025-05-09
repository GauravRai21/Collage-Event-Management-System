<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Sanchalana2k20</title>
    <?php require 'utils/styles.php'; ?>
</head>
<body>
    <?php require 'utils/header.php'; ?>
    <div class="content">
        <div class="container">
            <div class="col-md-6 col-md-offset-3">
                <form method="POST" action="">
                    <label>Student USN:</label><br>
                    <input type="text" name="usn" class="form-control" required><br><br>

                    <label>Student Name:</label><br>
                    <input type="text" name="name" class="form-control" required><br><br>

                    <label>Branch:</label><br>
                    <input type="text" name="branch" class="form-control" required><br><br>

                    <label>Semester:</label><br>
                    <input type="text" name="sem" class="form-control" required><br><br>

                    <label>Email:</label><br>
                    <input type="email" name="email" class="form-control" required><br><br>

                    <label>Phone:</label><br>
                    <input type="text" name="phone" class="form-control" required><br><br>

                    <label>College:</label><br>
                    <input type="text" name="college" class="form-control" required><br><br>

                    <button type="submit" name="update" class="btn btn-primary">Submit</button><br><br>

                    <a href="usn.php"><u>Already registered?</u></a>
                </form>
            </div>
        </div>
    </div>
    <?php require 'utils/footer.php'; ?>

    <?php
    if (isset($_POST["update"])) {
        $usn = $_POST["usn"];
        $name = $_POST["name"];
        $branch = $_POST["branch"];
        $sem = $_POST["sem"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $college = $_POST["college"];

        if (!empty($usn) && !empty($name) && !empty($branch) && !empty($sem) && !empty($email) && !empty($phone) && !empty($college)) {
            include 'classes/db1.php';

            // Check for duplicate USN first
            $check = $conn->prepare("SELECT usn FROM participent WHERE usn = ?");
            $check->bind_param("s", $usn);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
                echo "<script>
                    alert('Already registered with this USN.');
                    window.location.href='usn.php';
                </script>";
            } else {
                // Insert securely using prepared statements
                $stmt = $conn->prepare("INSERT INTO participent (usn, name, branch, sem, email, phone, college) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssss", $usn, $name, $branch, $sem, $email, $phone, $college);

                if ($stmt->execute()) {
                    echo "<script>
                        alert('Registered Successfully!');
                        window.location.href='usn.php';
                    </script>";
                } else {
                    echo "<script>
                        alert('Error during registration.');
                        window.location.href='register.php';
                    </script>";
                }

                $stmt->close();
            }

            $conn->close();
        } else {
            echo "<script>
                alert('All fields are required');
                window.location.href='register.php';
            </script>";
        }
    }
    ?>
</body>
</html>
