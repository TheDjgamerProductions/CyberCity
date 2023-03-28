<?php include "template.php";
/** @var $conn */ ?>

    <h1>Contact Us</h1>

    <h1 class='text-primary'>Please fill out the form below, so we can get in contact with you.</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="container-fluid">
            <div class="row">
                <!--Customer Details-->

                <div class="col-md-12">
                    <h2>Personal Details</h2>

                    <p>Email<input type="text" name="email" class="form-control" required="required"></p>
                    <p>Username<input type="text" name="username" class="form-control" required="required"></p>
                </div>
            </div>
        </div>
        <input type="submit" name="formSubmit" value="Submit">
    </form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //takes username and email from form above.
    $username = sanitise_data($_POST['username']);
    $email = sanitise_data($_POST['email']);
    //will connect to the server.
    $query = $conn->query("SELECT COUNT(*) as count FROM ContactUs WHERE `Email` ='$email'");
    $data = $query->fetch();
    $complaintInProgress = (int)$data[0];

        if ($complaintInProgress > 0) {
            //if the username is already in the complaint table do not allow them to send another one.
            echo "You have already tried to get in contact with us, please wait while we get in contact with you.";
        } else {
            // will insert into a new user table under complaints and will also contain a text box to hold the complaint
            $sql = "INSERT INTO ContactUs (Username, Email) VALUES (:newUsername, :newEmail)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':newUsername', $username);
            $stmt->bindValue(':newEmail', $email);
            $stmt->execute();

        }

}

?>