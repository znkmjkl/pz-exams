<?php
	ob_start();
	include_once("lib/Lib.php");
	
	function finish() {
		include("html/End.php");
		ob_end_flush();
	}
	
	$title = "$appName - Strona admina";
	include("html/Begin.php");
	
	if (!isset($_SESSION['USER']) || $_SESSION['USER'] == "") {
		echo "<div class=\"alert alert-danger\"><b>Strona widoczna jedynie dla zalogowanych użytkowników.</b> Za 3 sekundy zostaniesz przeniesiony na stronę główną.</div>";
		header("refresh: 3; url=index.php");
		include("html/End.php");
		
		ob_end_flush();
		return;
	}
	
	$user = unserialize($_SESSION['USER']);
	
	if (!$user->getRight()=="administrator") {
		echo "<div class=\"alert alert-danger\"><b>Brak uprawnień</b> Za 3 sekundy zostaniesz przeniesiony na stronę główną.</div>";
		header("refresh: 3; url=index.php");
		include("html/End.php");
		
		ob_end_flush();
		return;
	}
	
	include("html/AdminPanel.php");
	
	$user = unserialize($_SESSION['USER']);
	
	echo "<h2>Statystki portalu $appName</h2>";
	echo "<p>W tym miejscu możesz przejrzeć szczegółowe statystki całego systemu.</p>";
	echo "<hr />";
	
	// Pobieranie statystyk z bazy danych
	$sql = "Select COUNT(ID) From Exams";

	$result = DatabaseConnector::getConnection()->query($sql);
	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	$ExamsNum = $row[0];

	$ExamsAct = ExamUnitDatabase::adminCountOpenExams(1);
	$ExamsNact = ExamUnitDatabase::adminCountOpenExams(0);

	$StudentsN = RecordDatabase::adminCountUserStudents();
	$StudentsSignedN = RecordDatabase::adminCountUserStudentsSingedToExams(); 
?>

<div class="row">
	<div class="col-md-4">
		<table style="font-size:17px; " class="table">
			<tr class="success">
				<th colspan="2" style="font-size:21px;">Statystyki Systemu</th>
			</tr>
			<tr>
				<td>Ilość egzaminów</td>	
				<td style="color:green; font-weight:bold; text-align:right;"><?php echo $ExamsNum; ?></td>
			</tr>
			<tr>
				<td>Ilość aktywnych egzaminów</td>
				<td style="color:blue; font-weight:bold; text-align:right;"><?php echo $ExamsAct; ?></td>
			</tr>
			<tr>
				<td>Ilość nieaktywnych egzaminów</td>
				<td style="color:red;font-weight:bold; text-align:right;"><?php echo $ExamsNact; ?></td>
			</tr>
			<tr>
				<td>Liczba wprowadzonych studentów</td>
				<td style="color:purple; font-weight:bold; text-align:right;"><?php echo $StudentsN; ?></td>
			</tr>
			<tr>
				<td>Liczba zapisanych studentów</td>
				<td style="font-weight:bold; text-align:right;"><?php echo $StudentsSignedN; ?></td>
			</tr>
		</table>
	</div>
</div>

<?php
	finish();
?>