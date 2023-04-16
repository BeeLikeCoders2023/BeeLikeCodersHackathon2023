<?php

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// Get the form data
	$name = $_POST["name"];
	$email = $_POST["email"];
	$age = $_POST["age"];
	$height = $_POST["height"];
	$weight = $_POST["weight"];
	$gender = $_POST["gender"];
	$allergies = $_POST["allergies"];

	
	// Validate the form data
	$errors = [];

	if (empty($name)) {
		$errors[] = "Name is required";
	}

	if (empty($email)) {
		$errors[] = "Email is required";
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors[] = "Invalid email format";
	}

	if (empty($age)) {
		$errors[] = "Age is required";
	}

	if (empty($height)) {
		$errors[] = "Height is required";
	}
	
	if (empty($weight)) {
		$errors[] = "Weight is required";
	}

	if (empty($gender)) {
		$errors[] = "Gender is required";
	}

	if (empty($allergies)) {
		$errors[] = "Allergies is required";
	}

	// If there are no errors, send the email
	if (empty($errors)) {


		$servername = "localhost";
		$username = "admin";
		$password = "secret";
		$dbname = "user_info";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);

		// Check connection
		if ($conn->connect_error) {
    		die("Connection failed: " . $conn->connect_error);
		}


		// Calculate BMI
		$bmi = $weight / (($height / 100) * ($height / 100));

		// Insert values into database
		$sql = "INSERT INTO user_info (name, email, age, height, weight, gender, allergies) VALUES ('$name', '$email', '$age', '$height', '$weight', '$gender', '$allergies', )";

		if ($conn->query($sql) === TRUE) {
    		echo "New record created successfully";
    		
    		
    		$to = $email;
			$subject = "Welcome to Eat Healthy! $name";
			$body = "You have signed up succesfully for Eat Healthy! \n Name: $name\nEmail: $email\n Age: $age\n Height: $height\n Weight: $weight\n Gender: $gender\n Allergies: $allergies";

			// Send the email
			if (mail($to, $subject, $body)) {
				echo "Thank you for signing up!";
			} else {
				echo "Sorry, there was an error signing up. Please try again later.";
			}
    		
    		
    		
		} else {
    		echo "Error: " . $sql . "<br>" . 
    
    		$conn->error;
		}
		$conn->close();

	} else {

		// Display the errors
		foreach ($errors as $error) {
			echo "<p>$error</p>";
		}

	}

}

?>

