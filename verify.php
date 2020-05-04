<?php
	// check duration time (for testing it is 10 seconds)
	session_start();
	include("duration.php");
	if(isset($_SESSION['did'])){
		if($_SESSION['did']!='admin'){
			echo "<script>alert('You\'re not authorized!');
	    window.location.href='https://www-student.cse.buffalo.edu/CSE442-542/2020-spring/cse-442t/account/login.php';
	    </script>";
		}

		if(checkLoginExpired()) {
			header("Location: logout.php?session_expired=1");
		}
	}else{
    echo "<script>alert('You\'re not logged-in!');
    window.location.href='https://www-student.cse.buffalo.edu/CSE442-542/2020-spring/cse-442t/account/login.php';
    </script>";
  }

  //$id=$_SESSION['did'];
  $mysqli = new mysqli("tethys.cse.buffalo.edu:3306", "yingyinl", "50239602", "cse442_542_2020_spring_teamt_db");
  if ($conn->connect_error) {
    exit("Something is wrong. Please try again");
  }


  /*****************************************************************************************************************/
  if(isset($_POST['verify'])){
			if(!empty($_POST['check_list'])){
				foreach($_POST['check_list'] as $box){
					// echo $box."</br>";
					// echo "<script>alert('$box');</script>";
          $box = json_decode($box, true);
          // echo $box['verify'];
          if($box['verify']==0){
            if($box['lat']==0 && $box['lon']==0 ){
              $location=$box['location'];
              $stmt = $mysqli->prepare("UPDATE construction SET verify=? WHERE location= ?");
              if ($stmt === false) {
                trigger_error($this->mysqli->error, E_USER_ERROR);
                return;
              }
			        $verify=1;
              $stmt->bind_param("is", $verify,$location);
              $stmt->execute();
              $stmt->close();

            }else{
              $lat=$box['lat'];
              $lon=$box['lon'];
              $stmt = $mysqli->prepare("UPDATE construction SET verify=? WHERE (lat= ? AND lon= ?)");
              if ($stmt === false) {
                trigger_error($this->mysqli->error, E_USER_ERROR);
                return;
              }
			        $verify=1;
              $stmt->bind_param("idd", $verify,$lat,$lon);
              $stmt->execute();
              $stmt->close();
            }
          }
				}
			}
      header("Location: inbox.php");
      exit();
		}
?>