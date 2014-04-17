<?php
	
	include_once("../lib/Lib.php");

	if(isset($_POST['action']) && !empty($_POST['action'])) {
	$action = $_POST['action'];
		switch($action) {
			case 'step1' : step1($_POST['exam']);break;
			case 'step2' : step2($_POST['examDate']);break;
		}
	}

	function step1($exam)
	{
		$examDays = ExamUnitDatabase::getExamDays($exam);
		$uniqeDays = array_unique($examDays);
		$uniqeDays[0]="2014-26-11";
		$response = '<div class="no-rec">not found</div>';
		$header = "<table class=\"col-md-12 \"><tbody class=\"table-hover\">";
		$rows = "";
		foreach ($uniqeDays as $day){
		//echo $day." | ";
			$rows = $rows."<tr><td>";
			//$rows = $rows."<button type=\"submit\" class=\"btn btn-block btn-primary btn-lg\" id=\"date\" name=\"date\" examDate=".$day."\">".$day."</button>";// data-toggle=\"modal\" 
			$rows = $rows."<a class=\"btn btn-block btn-primary btn-lg\" href=\"#\" role=\"button\" name=\"date\" id=\"date\" data-target=\"#signIn2Modal\" title=\"$day\" examDate=".$day."\">".$day."</a>";
			$rows = $rows."</td></tr>";
		}
		$footer = "<tbody></table>";
		$response = $header.$rows.$footer;
		$html = $response;

        echo $html;
	}

	function step2($examDate)
	{
		echo "Chosen Exam is on: ".$examDate;
	}
	
	/*
	if (isset($_POST['date']) == true) {
		echo "StudentID".$_POST['innerIStudentID'];//setInnerExamID($examID, $id);
		echo " ExamID".$_POST['innerIExamID'];
		echo " StudentCode".$_POST['innerIStudentCode'];
		echo " SessionExamID".$_SESSION['innerIExamID'];

		//header('Location: ../../StudentExams.php?id='.$_POST['innerIStudentCode']); 
	}
	*/
	
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

		header('Location: ../../StudentExams.php?id='.$_POST['innerStudentCode']); 
	}
?>