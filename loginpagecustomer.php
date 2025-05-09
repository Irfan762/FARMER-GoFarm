

<?php
// Start session


// Database connection - Connect to your existing database
$servername = "localhost";
$username = "root";  // Change to your database username if needed
$password = "";      // Change to your database password if needed
$dbname = "farmer";  // Your existing database name

// Create connection to your existing database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define variables and initialize with empty values
$name = $email = $password = "";
$name_err = $email_err = $password_err = $login_err = "";
$registration_success = "";

// Processing registration form data
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    
    // Validate name
    if(empty(trim($_POST["reg_name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["reg_name"]);
    }
    
    // Validate email
    if(empty(trim($_POST["reg_email"]))) {
        $email_err = "Please enter an email.";
    } else {
        // Prepare a select statement to check if email already exists
        $sql = "SELECT id FROM user WHERE email = ?";
        
        if($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["reg_email"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()) {
                // Store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1) {
                    $email_err = "This email is already taken.";
                } else {
                    $email = trim($_POST["reg_email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Validate password
    if(empty(trim($_POST["reg_password"]))) {
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["reg_password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["reg_password"]);
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($email_err) && empty($password_err)) {
        
        // Prepare an insert statement
        $sql = "INSERT INTO user (name, email, password) VALUES (?, ?, ?)";
         
        if($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sss", $param_name, $param_email, $param_password);
            
            // Set parameters
            $param_name = $name;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute()) {
                $registration_success = "Registration successful! You can now login.";
            } else {
                echo "Error: " . $stmt->error; // Show the specific SQL error
            }

            // Close statement
            $stmt->close();
        } else {
            echo "Error in prepare statement: " . $conn->error; // Show error in prepare statement
        }
    }
}

// Processing login form data
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    
    // Check if email is empty
    if(empty(trim($_POST["email"]))) {
        $email_err = "Please enter email.";
    } else {
        $email = trim($_POST["email"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($email_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, name, email, password FROM user WHERE email = ?";
        
        if($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()) {
                // Store result
                $stmt->store_result();
                
                // Check if email exists, if yes then verify password
                if($stmt->num_rows == 1) {                    
                    // Bind result variables
                    $stmt->bind_result($id, $name, $email, $hashed_password);
                    if($stmt->fetch()) {
                        if(password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["name"] = $name;
                            $_SESSION["email"] = $email;                            
                            
                            // Redirect user to welcome page
                            header("location: cosumerWeb.php");
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid email or password.";
                        }
                    }
                } else {
                    // Email doesn't exist, display a generic error message
                    $login_err = "Invalid email or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoFarm - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .animate-fade {
            animation: fadeIn 1.2s ease-in-out;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
    </style>
</head>
<body class="bg-gradient-to-b from-green-100 to-white flex items-center justify-center min-h-screen py-8">

<div class="bg-white shadow-lg rounded-3xl p-10 w-full max-w-md animate-fade">
    <div class="text-center">
        <h2 class="text-3xl font-bold text-red-500 mt-4">🌾GO<span class="text-blue-600">FaRm</span></h2>
        <p class="text-sm text-gray-500 mb-6">SMART FARMING FOR ALL</p>
    </div>

    <!-- Tab Navigation -->
    <div class="flex border-b mb-6">
        <button id="login-tab" class="px-4 py-2 w-1/2 font-medium text-center border-b-2 border-green-500 text-green-600 focus:outline-none">Login</button>
        <button id="register-tab" class="px-4 py-2 w-1/2 font-medium text-center text-gray-500 focus:outline-none">Register</button>
    </div>

    <?php if(!empty($login_err)): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><?php echo $login_err; ?></div>
    <?php endif; ?>
    
    <?php if(!empty($registration_success)): ?>
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4"><?php echo $registration_success; ?></div>
    <?php endif; ?>

    <!-- Login Form -->
    <div id="login-content" class="tab-content active">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Email<span class="text-red-500">*</span></label>
                <input type="email" name="email" placeholder="Enter your email address" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-500 outline-none <?php echo (!empty($email_err)) ? 'border-red-500' : ''; ?>" value="<?php echo $email; ?>">
                <span class="text-red-500 text-xs"><?php echo $email_err; ?></span>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Password<span class="text-red-500">*</span></label>
                <input type="password" name="password" placeholder="Enter your password" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-500 outline-none <?php echo (!empty($password_err)) ? 'border-red-500' : ''; ?>">
                <span class="text-red-500 text-xs"><?php echo $password_err; ?></span>
            </div>

            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center">
                    <input type="checkbox" id="remember" class="h-4 w-4 text-green-600 rounded">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
                </div>
                <a href="#" class="text-sm text-green-600 hover:text-blue-600 transition">Forgot password?</a>
            </div>

            <button type="submit" name="login" class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-blue-600 transition shadow-lg">
                Sign in
            </button>
        </form>
    </div>

    <!-- Register Form -->
    <div id="register-content" class="tab-content">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Name<span class="text-red-500">*</span></label>
                <input type="text" name="reg_name" placeholder="Enter your name" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                <span class="text-red-500 text-xs"><?php echo $name_err; ?></span>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Email<span class="text-red-500">*</span></label>
                <input type="email" name="reg_email" placeholder="Enter your email address" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                <span class="text-red-500 text-xs"><?php echo $email_err; ?></span>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Password<span class="text-red-500">*</span></label>
                <input type="password" name="reg_password" placeholder="Enter your password" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                <span class="text-red-500 text-xs"><?php echo $password_err; ?></span>
                <span class="text-xs text-gray-500">Password must be at least 6 characters</span>
            </div>

            <button type="submit" name="register" class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-blue-600 transition shadow-lg mt-4">
                Create Account
            </button>
        </form>
    </div>
</div>

<script>
    // Tab switching functionality
    document.getElementById('login-tab').addEventListener('click', function() {
        document.getElementById('login-tab').classList.add('border-green-500', 'text-green-600');
        document.getElementById('register-tab').classList.remove('border-green-500', 'text-green-600');
        document.getElementById('login-content').classList.add('active');
        document.getElementById('register-content').classList.remove('active');
    });

    document.getElementById('register-tab').addEventListener('click', function() {
        document.getElementById('register-tab').classList.add('border-green-500', 'text-green-600');
        document.getElementById('login-tab').classList.remove('border-green-500', 'text-green-600');
        document.getElementById('register-content').classList.add('active');
        document.getElementById('login-content').classList.remove('active');
    });
</script>

</body>
</html>