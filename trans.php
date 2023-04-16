<?php
// Establish a connection to the database
$pid=$_GET['id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname ="srms";


$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$course_credits=[];
$course_grades=[];
// Prepare the SQL query
?>


<!DOCTYPE html>
<html>
<head>
	<title>Transcript Page</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f5f5f5;

		}

		.container {
			max-width: 800px;
			margin: 0 auto;
			padding: 20px;
			background-color: #fff;
			box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
		}

		h1 {
			text-align: center;
			margin-top: 0;
			margin-bottom: 20px;
		}

		.school {
			font-size: 24px;
			font-weight: bold;
			margin-bottom: 10px;
			text-align: center;

		}

		.student {
			font-size: 18px;
			margin-bottom: 20px;
		}

		table {
			border-collapse: collapse;
			width: 100%;
		}

		th, td {
			text-align: left;
			padding: 8px;
			border: 1px solid #ddd;
		}

		th {
			background-color: #4CAF50;
			color: white;
		}

		tr:nth-child(even) {
			background-color: #f2f2f2;
		}

		.download-button {
			display: block;
			margin-top: 20px;
			text-align: center;
		}

		.download-button a {
			display: inline-block;
			padding: 10px;
			background-color: #4CAF50;
			color: white;
			text-decoration: none;
			border-radius: 5px;
			box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
		}
		img{
    position: center;
    height: 190px;
    border-radius: 5pc
}
	</style>
</head>
<body>
	<div class="container">
		<h1>Transcript </h1>
		<div class="school">PLATEAU STATE UNIVERSITY BOKKOS</div>
		<center><img src="plasu.png">   </center>
		<div class="student">
<?php $sql = "SELECT `StudentId`, `StudentName`, `RollId`, `StudentEmail`, `Gender`, `DOB`, `ClassId`, `RegDate`, `UpdationDate`, `Status`
        FROM `tblstudents`
        WHERE `RollId` = '".$pid."'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) { ?>


			<div>Student Name: <?php echo$row['StudentName']?></div>
			<div>GENDER : <?php echo$row['StudentName']?></div>
			<div>Mat NO: <?php echo$row['RollId']?></div>
			<div>Course of Study: Computer Science</div>

	<?php	}?>
		</div>

		<div>Character review: He have been deeply committed to his academics and have maintained a strong GPA.<wbr> He also have had the opportunity to develop the communication and teamwork skills, as well as contribute to meaningful projects that benefit the community have no bad behaviour<br></div><hr>
		<table>
			<tr>
				<th>Course</th>
				
				<th>Grade</th>
				<th>Credits</th>
			</tr>

			<?php 
			  $sql = "SELECT s.StudentId, s.StudentName, s.RollId, s.StudentEmail, s.Gender, s.DOB, r.ClassId, r.SubjectId, su.SubjectName, su.SubjectCode, r.marks, r.PostingDate, r.UpdationDate, su.Creationdate, su.UpdationDate
        FROM tblstudents s
        JOIN tblresult r ON s.StudentId = r.StudentId
        JOIN tblsubjects su ON r.SubjectId = su.id
        WHERE s.RollId = '".$pid."'";

// Execute the query
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
   
echo "<td>" . $row["SubjectName"] . "</td>";

echo "<td>" . $row["marks"] . "</td>";


 if ($row["marks"] >= 70) {
    $grade = "A";
} elseif ($row["marks"] >= 69) {
    $grade = "B";
} elseif ($row["marks"] >= 59) {
    $grade = "C";
} elseif ($row["marks"] >= 49) {
    $grade = "D";
} else {
    $grade = "F";
}
array_push($course_grades,$grade); // An example of corresponding grades obtained

echo "<td>" .$grade. "</td>";

 if ($grade == "A") {
    $cs = 5.0;
} elseif ($grade == "B") {
    $cs = 4.0;
} elseif ($grade >= "C") {
    $cs = 3.0;
} elseif ($grade >= "D") {
    $cs = 2.0;
} else {
    $cs = 1.0;
}
array_push($course_credits,$cs); // An example with four courses taken
echo "</tr>";
}
echo "</table>";

// Close the connection
mysqli_close($conn);
?>
			
		</table>
		<?php
// Define an array of grades
$grades = array(
	"A" => 5.0,
	"B" => 4.0,
	"C" => 3.0,
	"D" => 2.0,
	"F" => 1.0
);

// Define an array of course credits and grades obtained
// $course_credits = array(3, 4, 4, 3);
 // An example with four courses taken
// $course_grades = array("B", "A", "B", "C"); 
// An example of corresponding grades obtained

// Calculate total credits and quality points
$total_credits = 0;
$total_quality_points = 0;

for ($i = 0; $i < count($course_credits); $i++) {
	$total_credits += $course_credits[$i];
	$total_quality_points += ($grades[$course_grades[$i]] * $course_credits[$i]);
}

// Calculate GPA
$gpa = $total_quality_points / $total_credits;

// Output the result
echo "<br>Total Credits: " . $total_credits . "<hr>";
echo "Total Quality Points: " . $total_quality_points . "<hr>";
echo "GPA: " . number_format($gpa, 2); // Round the GPA to two decimal places
?>

		<div class="download-button">
			<a href="#" onclick="downloadPDF()">Download Transcript as PDF</a>
		</div>
		<div>Date: March 25, 2023</div>
	</div>

	<script>
		function downloadPDF() {
			const element = document.querySelector(".container");
			html2pdf()
				.from(element)
				.save('transcript.pdf');
		}
	</script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
</body>
</html>