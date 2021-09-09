<?php
	//กำหนดค่า Access-Control-Allow-Origin ให้ เครื่อง อื่น ๆ สามารถเรียกใช้งานหน้านี้ได้
header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset=UTF-8");

header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");

header("Access-Control-Max-Age: 3600");

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	//ตั้งค่าการเชื่อมต่อฐานข้อมูล
$link = mysqli_connect('localhost', 'root', '', 'pts_hrm');

mysqli_set_charset($link, 'utf8');

$requestMethod = $_SERVER["REQUEST_METHOD"];

	//ตรวจสอบหากใช้ Method GET
if($requestMethod == 'GET'){
		//ตรวจสอบการส่งค่า STAFFID
	if(isset($_GET['STAFFID']) && !empty($_GET['STAFFID'])){

		$STAFFID = $_GET['STAFFID'];

			//คำสั่ง SQL กรณี มีการส่งค่า STAFFID มาให้แสดงเฉพาะข้อมูลของ STAFFID นั้น
		$sql = "SELECT * FROM tbl_staff WHERE STAFFID = $STAFFID";

	}else{
			//คำสั่ง SQL แสดงข้อมูลทั้งหมด
		$sql = "SELECT * FROM tbl_staff";
	}

	$result = mysqli_query($link, $sql);

		//สร้างตัวแปร array สำหรับเก็บข้อมูลที่ได้
	$arr = array();

	while ($row = mysqli_fetch_assoc($result)) {

		$arr[] = $row;
	}

	echo json_encode($arr);
}

	//อ่านข้อมูลที่ส่งมาแล้วเก็บไว้ที่ตัวแปร data
$data = file_get_contents("php://input");

	//แปลงข้อมูลที่อ่านได้ เป็น array แล้วเก็บไว้ที่ตัวแปร result
$result = json_decode($data,true);

	//ตรวจสอบการเรียกใช้งานว่าเป็น Method POST หรือไม่
if($requestMethod == 'POST'){

	if(!empty($result)){

		$firstName = $result['first_name'];
		$lastName = $result['last_name'];
		$emailAddress = $result['email_address'];

			//คำสั่ง SQL สำหรับเพิ่มข้อมูลใน Database
		$sql = "INSERT INTO tbl_staff (STAFFID,first_name,last_name,email_address) VALUES (NULL,'$firstName','$lastName','$emailAddress')";

		$result = mysqli_query($link, $sql);

		if ($result) {
			echo json_encode(['status' => 'ok','message' => 'Insert Data Complete']);
		} else {
			echo json_encode(['status' => 'error','message' => 'Error']);	
		}
	}

}

	//ตรวจสอบการเรียกใช้งานว่าเป็น Method PUT หรือไม่
if($requestMethod == 'PUT'){

		//ตรวจสอบว่ามีการส่งค่า STAFFID มาหรือไม่
	if(isset($_GET['STAFFID']) && !empty($_GET['STAFFID'])){

		$STAFFID = $_GET['STAFFID'];

		$firstName = $result['first_name'];
		$lastName = $result['last_name'];
		$emailAddress = $result['email_address'];

			//คำสั่ง SQL สำหรับแก้ไขข้อมูลใน Database โดยจะแก้ไขเฉพาะข้อมูลตามค่า STAFFID ที่ส่งมา
		$sql = "UPDATE tbl_staff SET first_name = '$firstName' , last_name = '$lastName' , email_address = '$emailAddress' WHERE STAFFID = $STAFFID";

		$result = mysqli_query($link, $sql);

		if ($result) {
			echo json_encode(['status' => 'ok','message' => 'Update Data Complete']);
		} else {
			echo json_encode(['status' => 'error','message' => 'Error']);	
		}
		
	}

}

	//ตรวจสอบการเรียกใช้งานว่าเป็น Method DELETE หรือไม่
if($requestMethod == 'DELETE'){

		//ตรวจสอบว่ามีการส่งค่า STAFFID มาหรือไม่
	if(isset($_GET['STAFFID']) && !empty($_GET['STAFFID'])){

		$STAFFID = $_GET['STAFFID'];

			//คำสั่ง SQL สำหรับลบข้อมูลใน Database ตามค่า STAFFID ที่ส่งมา
		$sql = "DELETE FROM tbl_staff WHERE STAFFID = $STAFFID";

		$result = mysqli_query($link, $sql);

		if ($result) {
			echo json_encode(['status' => 'ok','message' => 'Delete Data Complete']);
		} else {
			echo json_encode(['status' => 'error','message' => 'Error']);	
		}
		
	}

}