<?php 
// session_start();

// $currentValue = 10; // ตัวอย่างค่าปัจจุบัน

// if(isset($_POST['inputValue'])){
//   $inputValue = $_POST['inputValue'];
//   if($inputValue < $currentValue){
//     $_SESSION['alert'] = true;
//   }
// }

// if(isset($_SESSION['alert']) && $_SESSION['alert']){
//   echo "<script>alert('ค่าที่คุณใส่น้อยกว่าค่าปัจจุบัน')</script>";
//   $_SESSION['alert'] = false;
// }

// session_start();

// $currentValue = 10; // ตัวอย่างค่าปัจจุบัน

// if(isset($_POST['inputValue'])){
//   $inputValue = $_POST['inputValue'];
//   if($inputValue != $currentValue){
//     // กรอกค่าไม่เท่ากับค่าปัจจุบัน
//     // ทำสิ่งที่ต้องการเมื่อกรอกค่าที่ไม่เท่ากับค่าปัจจุบัน
//   } else {
//     // กรอกค่าเท่ากับค่าปัจจุบัน
//     // ทำสิ่งที่ต้องการเมื่อกรอกค่าเท่ากับค่าปัจจุบัน
//   }
//   // อัพเดทค่าปัจจุบัน
//   $currentValue = $inputValue;
// }

// // ตัวอย่างอัพเดทค่าปัจจุบันโดยการสุ่มเลขใหม่
// $currentValue = rand(1, 100);

$current_day = date("d");
echo "Today is the " . $current_day . "th day of the month.";
// if (isset($_POST["my-date-input"])) {
//   $selected_date = $_POST["my-date-input"];
//   $selected_day = date("d", strtotime($selected_date));
//   echo "You selected day " . $selected_day . " of the month.";
// }
echo $current_datetime = date("Y-m-d H:i:s");


?>
<!-- <form method="post" action="test2.php">
  <label for="my-date-input">Select a date:</label>
  <input type="date" id="my-date-input" name="my-date-input">
  <input type="submit" value="Submit">
</form> -->
