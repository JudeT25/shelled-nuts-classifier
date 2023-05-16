<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"]) && is_uploaded_file($_FILES["image"]["tmp_name"])) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $newFileName = "imageToBePredicted.png";
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));


    // Check if the uploaded file is an image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        echo "Error: File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists,if so delete
    if (file_exists($targetFile)) {
	    if (unlink($targetFile)) {
	        echo "Existing file deleted.";
	    } else {
	        echo "Error: Unable to delete existing file.";
	        $uploadOk = 0;
	    }
	}

	if (rename($targetFile, $newFileName)) {
        echo "File renamed successfully.";
    }


    // Check file size (optional)
    if ($_FILES["image"]["size"] > 500000) {
        echo "Error: File is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats (e.g., JPEG, PNG)
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
        echo "Error: Only JPG, JPEG, and PNG files are allowed.";
        $uploadOk = 0;
    }

    // If no errors, move the uploaded file to the target directory
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            echo "The file ".basename($_FILES["image"]["name"])." has been uploaded.";
        } else {
            echo "Error: There was an error uploading the file.";
        }
    }
} else {
	echo "No file found, upload a file";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Image Upload</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/*">
        <input type="submit" value="Upload">
    </form>
</body>
</html>
