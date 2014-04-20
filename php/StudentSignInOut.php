<?php
	
	include_once("../lib/Lib.php");
	$arrLocales = array('pl_PL', 'pl','Polish_Poland.28592');
	setlocale( LC_ALL, $arrLocales );
	
	if(isset($_POST['action']) && !empty($_POST['action'])) {
	$action = $_POST['action'];
		switch($action) {
			case 'stepOut' : stepOut($_POST['exam'],$_POST['student']);break;
			case 'step1' : step1($_POST['exam']);break;
			case 'step2' : step2($_POST['exam'],$_POST['examDate']);break;
			case 'stepF1' : stepF1();break;
			case 'stepF2' : stepF2();break;
		}
	}

	function stepOut($examID,$studentID)
	{
		$exam = ExamDatabase::getExam($examID);
		$response = '<div class="no-rec">not found</div>';
		$header = "<span><b>Aktualnie jesteś zapisany na egzamin:</b></span><br>";
		$header = $header."<span>".$exam->getName()."</span><br>";

		$id = RecordDatabase::getRecordID($examID,$studentID);
		$record = RecordDatabase::getRecord($id);
		$examunit = ExamUnitDatabase::getExamUnit($record->getExamUnitID());
		$body = "<span><b>Dnia:</b></span><br>";
		$body = $body."<span>".$examunit->getDay()." (".iconv("ISO-8859-2","UTF-8",ucfirst(strftime('%A',strtotime($examunit->getDay())))).")</span><br>";
		$footer = "<span><b>Na godzinę:</b></span><br>";
		$timeFrom = $examunit->getDay()." ".$examunit->getTimeFrom();
		$footer = $footer."<span>".strftime("%H:%M",strtotime($timeFrom))."</span><hr>";

		$response = $header.$body.$footer;
		$html = $response;
	
		echo $html;
	}
	
	function step1($exam)
	{
		$examDays = ExamUnitDatabase::getExamDays($exam);
		$uniqeDays = array_unique($examDays);
		$response = '<div class="no-rec">not found</div>';
		$header = "<table class=\"table table-hover\"><tbody>";
		$rows = "";
		foreach ($uniqeDays as $day){
			if (date_create($day) >= new DateTime("now")) {
				$rows = $rows."<tr><td>";
				$rows = $rows."<a class=\"btn btn-block btn-primary btn-lg\" href=\"#\" role=\"button\" name=\"date\" id=\"date\" data-target=\"#signIn2Modal\" title=\"$day\" examDate=\"".$day."\">".$day." (".iconv("ISO-8859-2","UTF-8",ucfirst(strftime('%A',strtotime($day)))).")</a>";
				$rows = $rows."</td></tr>";
			}
		}
		$footer = "<tbody></table>";
		$response = $header.$rows.$footer;
		$html = $response;
	
		echo $html;
	}
	
	function step2($exam,$examDate)
	{
		//echo "Chosen Exam is on: ".$examDate;
		$examUnitIDs = ExamUnitDatabase::getExamUnitIDListDay($exam,$examDate);
		//echo '<pre>'; print_r($examIDs); echo '</pre>';
		//echo $examIDs." ".$examDate;
		
		$response = '<div class="no-rec">not found</div>';
		$header = "<table class=\"table table-condensed table-bordered table-hover\">";
		$rows = "<thead>
					<tr>
						<th>Godziny</th>
						<th>Student</th>
						<th></th>
					</tr>
				</thead><tbody>";
		$i = 1;
		foreach ($examUnitIDs as $id){
			$examunit = ExamUnitDatabase::getExamUnit($id);
			$record = RecordDatabase::getRecordFromUnit($examunit->getID());
			if(($record) != null){
				$student = StudentDatabase::getStudentByID($record->getStudentID());
			}else{
				$student = new Student();
				$student->setFirstName("---");
				$student->setSurName("");
			}
			$rows = $rows."<tr>";
			$rows = $rows."<td>";
			$timeFrom = $examunit->getDay()." ".$examunit->getTimeFrom();
			$timeTo = $examunit->getDay()." ".$examunit->getTimeTo();
			$rows = $rows.strftime("%H:%M",strtotime($timeFrom))." - ".strftime("%H:%M",strtotime($timeTo));
			$rows = $rows."</td>";
			$rows = $rows."<td>";
			$rows = $rows.$student->getFirstName()." ".$student->getSurName();
			$rows = $rows."</td>";
			$rows = $rows."<td style=\"vertical-align:middle\">";
			if($examunit->getState() == 'locked'){
				$rows = $rows."<div class=\"radio\"><label><input type=\"radio\" disabled=disabled name=\"diabled$i\" id=\"optionsRadios$i\" value=\"$id\" checked>Zajęty</label></div>";
			}else{
				$rows = $rows."<div class=\"radio\"><label><input type=\"radio\" name=\"optionsRadios\" id=\"optionsRadios\" value=\"$id\">Zapisz się</label></div>";
			}
			$rows = $rows."</td>";
			$rows = $rows."</tr>";
			$i++;
		}
		$footer = "<tbody></table><span class=\"help-block\" id=\"error-message\"></span>";
		$response = $header.$rows.$footer;
		$html = $response;
	
		echo $html;
	}
	
	function stepF1()
	{
		echo "<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Zamknij</button>";
	}
	
	function stepF2()
	{
		echo "<a class=\"btn btn-primary\" href=\"#\" role=\"button\" id=\"back\" name=\"back\">Cofnij</a>"."<button type=\"submit\" class=\"btn btn-success\" name=\"signIn\" value=\"submit\">Zapisz</button>"."<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Zamknij</button>";
	}
	
	
	if (isset($_POST['signIn']) == true) {
		//echo "StudentID ".$_POST['innerIStudentID'];//setInnerExamID($examID, $id);
		//echo " | ExamID ".$_POST['innerIExamID'];
		//echo " | StudentCode ".$_POST['innerIStudentCode'];
		//echo " | Exam Unit ".$_POST['optionsRadios'];

		$examunit = ExamUnitDatabase::getExamUnit($_POST['optionsRadios']);
		//echo "| Unit got";
		$id = RecordDatabase::getRecordID($_POST['innerIExamID'],$_POST['innerIStudentID']);
		//echo "| Id got =". $id;
		$record = RecordDatabase::getRecord($id);
		//echo "| Record got ". $record->getID();
		$record->setExamUnitID($_POST['optionsRadios']);
		$examunit->setState('locked');

		if(RecordDatabase::updateRecord($record)){
		//	echo " updateRecord Succes";
			if(ExamUnitDatabase::updateExamUnit($examunit)){
		//		echo " updateExamUnit Succes";
			}else{
		//		echo " updateExamUnit Fail";
			}
		}else{
			echo " updateRecord Fail";
		}
	
		header('Location: ../StudentExams.php?code='.$_POST['innerIStudentCode']); 
	}
	
	
	if (isset($_POST['signOut']) == true) {
		// TEST CODE
		//echo "StudentID ".$_POST['innerStudentID'];
		//echo " ExamID ".$_POST['innerExamID'];
		//echo " StudentCode ".$_POST['innerStudentCode'];
		$examUnitID = RecordDatabase::getExamUnitID($_POST['innerExamID'],$_POST['innerStudentID']);
		$id = RecordDatabase::getRecordID($_POST['innerExamID'],$_POST['innerStudentID']);
		//echo "| Id got =". $examUnitID;
		$examunit = ExamUnitDatabase::getExamUnit($examUnitID);
		//echo "| Unit got";
		$record = RecordDatabase::getRecord($id);
		//echo "| Record got ". $record->getID();
		$record->setExamUnitID(0);
		//echo "| Record set";
		$examunit->setState('unlocked');
		//echo "| State set";
		if(RecordDatabase::updateRecord($record)){
		//	echo " updateRecord Succes";
			if(ExamUnitDatabase::updateExamUnit($examunit)){
		//		echo " updateExamUnit Succes";
			}else{
		//		echo " updateExamUnit Fail";
			}
		}else{
			echo " updateRecord Fail";
		}
	
		header('Location: ../StudentExams.php?code='.$_POST['innerStudentCode']); 
	}
?>