<?php
	class DbService{
		//--Connect database
		function connectDb(){
			global $mysqli;
			$configDb = array(
				"host"=>"127.0.0.1",
				"username"=>"root",
				"password"=>"",
				"dbName"=>"sob2",
				"charset"=>"utf8"
			);

			$mysqli = mysqli_connect($configDb["host"], $configDb["username"], $configDb["password"], $configDb["dbName"]);
			$mysqli->set_charset($configDb["charset"]);

			if(mysqli_connect_error()){
				die("<b>Connect error</b>: ".mysqli_connect_errno()."<br><b>Parse error</b>: ".mysqli_connect_error());
				exit();
			}else
				return true;
		}
		
		//--Query sql command
		function getQuery($sqlCmd){
			global $mysqli;

			if($mysqli->multi_query($sqlCmd))
				return true;
			else
				return false;
		}

		//--Get object item
		function getObj($sqlCmd){
			global $mysqli;
			
			$query = $mysqli->query($sqlCmd) 
				or die("<b>SQL error</b>: \"".$sqlCmd."\"<br><b>Parse error</b>: ".$mysqli->error);

			$item = $query->fetch_assoc();

			return $item;
		}

		//--Get array item
		function getListObj($sqlCmd){
			global $mysqli;
			$itemList = array();
			
			$query = $mysqli->query($sqlCmd) 
				or die("<b>SQL error</b>: \"".$sqlCmd."\"<br><b>Parse error</b>: ".$mysqli->error);

			while($item = $query->fetch_assoc()){
				array_push($itemList, $item);
			}

			return $itemList;
		}

		//--Get fieldname on table
		function getFieldName($tblName){
			global $mysqli;
			$itemList = array();

			$sqlCmd = "SELECT * FROM $tblName LIMIT 1";
			$query = $mysqli->query($sqlCmd) 
				or die("<b>SQL error</b>: \"".$sqlCmd."\"<br><b>Parse error</b>: ".$mysqli->error);

			while($item = $query->fetch_field()){
				array_push($itemList, $item);
			}

			return $itemList;
		}

		//--Parse arabic number to thai number
		function parseArabicToThaiNum($arabicNum){
			switch($arabicNum){
				case 0: return '๐'; break;
				case 1: return '๑'; break;
				case 2: return '๒'; break;
				case 3: return '๓'; break;
				case 4: return '๔'; break;
				case 5: return '๕'; break;
				case 6: return '๖'; break;
				case 7: return '๗'; break;
				case 8: return '๘'; break;
				case 9: return '๙'; break;
				default: $arabicNum;
			}
		}

		//--Parse arabic number to thai number for sql command
		function parseArabicToThaiNumForSQL($sqlCmd){
			$sqlCmd = "CASE ".$sqlCmd." ";
			$sqlCmd .= "WHEN '0' THEN '๐' ";
			$sqlCmd .= "WHEN '1' THEN '๑' ";
			$sqlCmd .= "WHEN '2' THEN '๒' ";
			$sqlCmd .= "WHEN '3' THEN '๓' ";
			$sqlCmd .= "WHEN '4' THEN '๔' ";
			$sqlCmd .= "WHEN '5' THEN '๕' ";
			$sqlCmd .= "WHEN '6' THEN '๖' ";
			$sqlCmd .= "WHEN '7' THEN '๗' ";
			$sqlCmd .= "WHEN '8' THEN '๘' ";
			$sqlCmd .= "WHEN '9' THEN '๙' ";
			$sqlCmd .= "ELSE '๐' ";
			$sqlCmd .= "END";

			return $sqlCmd;
		}

		//--Parse arabic number to thai month for sql command
		function parseArabicToThaiMonthForSQL($sqlCmd){
			$sqlCmd = "CASE ".$sqlCmd." ";
			$sqlCmd .= "WHEN '01' THEN 'มกราคม' ";
			$sqlCmd .= "WHEN '02' THEN 'กุมภาพันธ์' ";
			$sqlCmd .= "WHEN '03' THEN 'มีนาคม' ";
			$sqlCmd .= "WHEN '04' THEN 'เมษายน' ";
			$sqlCmd .= "WHEN '05' THEN 'พฤษภาคม' ";
			$sqlCmd .= "WHEN '06' THEN 'มิถุนายน' ";
			$sqlCmd .= "WHEN '07' THEN 'กรกฎาคม' ";
			$sqlCmd .= "WHEN '08' THEN 'สิงหาคม' ";
			$sqlCmd .= "WHEN '09' THEN 'กันยายน' ";
			$sqlCmd .= "WHEN '10' THEN 'ตุลาคม' ";
			$sqlCmd .= "WHEN '11' THEN 'พฤศจิกายน' ";
			$sqlCmd .= "WHEN '12' THEN 'ธันวาคม' ";
			$sqlCmd .= "END";

			return $sqlCmd;
		}

		//--Insert data function
		function insertData($tblName, $dataArr){
			global $mysqli;

			foreach($dataArr as $data){
				$status = false;
				$fields = "";
				$values = "";
				$fieldIndex = 1;

				foreach($data as $key=>$val){
					if($fieldIndex != 1){
						$fields .= ", ";
						$values .= ", ";
					}
					$fields .= "$key";
					$values .= "'$val'";
					$fieldIndex++;
				}

				$sqlCmd = "INSERT INTO $tblName($fields) VALUES($values)";
				$status = $mysqli->query($sqlCmd);
			}

			if($status)
				return true;
			else
				return false;
		}

		//--Insert data for sub table function
		function insertDataSubTable($tblName, $dataArr){
			global $mysqli;

			foreach($dataArr as $data){
				$status = false;
				$subStatus = false;
				$fields = "";
				$values = "";
				$fieldIndex = 1;
				$subTableList = array();

				foreach($data as $key=>$val){
					if(is_array($val))
						array_push($subTableList, $val);
					else{
						if($fieldIndex != 1){
							$fields .= ", ";
							$values .= ", ";
						}
						$fields .= "$key";
						$values .= "'$val'";
						$fieldIndex++;
					}
				}

				$sqlCmd = "INSERT INTO $tblName($fields) VALUES($values)";
				$status = $mysqli->query($sqlCmd);
				$lastInsertID = $mysqli->insert_id;

				if(count($subTableList) > 0){
					foreach($subTableList as $subTable){
						$subTblName = $subTable["tblName"];
						$foreignKey = $subTable["foreignKey"];
						$subDataArr = $subTable["data"];

						foreach($subDataArr as $subData){
							$subFields = "";
							$subValues = "";
							$subFieldIndex = 1;

							foreach($subData as $subKey=>$subVal){
								if($subFieldIndex != 1){
									$subFields .= ", ";
									$subValues .= ", ";
								}
								$subFields .= "$subKey";
								$subValues .= "'$subVal'";
								$subFieldIndex++;
							}

							$subSqlCmd = "INSERT INTO $subTblName($subFields, $foreignKey) VALUES($subValues, '$lastInsertID')";
							$subStatus = $mysqli->query($subSqlCmd);
						}
					}
				}
			}

			if(count($subTableList) > 0){
				if($status && $subStatus)
					return true;
				else
					return false;
			}else{
				if($status)
					return true;
				else
					return false;
			}
		}

		//--Update data function
		function updateData($tblName, $dataArr){
			global $mysqli;

			foreach($dataArr as $data){
				$status = false;
				$update = "";
				$fieldIndex = 1;
				
				foreach($data as $key=>$val){
					if($key == "condition")
						continue;
					else{
						if($fieldIndex != 1)
							$update .= ", ";

						if($key == "updated")
							$update .= "$key = CURRENT_TIMESTAMP";
						else
							$update .= "$key = '$val'";

						$fieldIndex++;
					}
				}

				$sqlCmd = "UPDATE $tblName SET $update WHERE ".$data["condition"];
				$status = $mysqli->query($sqlCmd);
			}

			if($status)
				return true;
			else
				return false;
		}

		//--Update data for sub table function
		function updateDataSubTable($tblName, $dataArr){
			global $mysqli;

			foreach($dataArr as $data){
				$status = false;
				$subStatus = false;
				$update = "";
				$fieldIndex = 1;
				$subTableList = array();
				$pathUpload = "../ActivitiesImages/";
				
				foreach($data as $key=>$val){
					if($key == "condition")
						continue;
					else{
						if(is_array($val))
							array_push($subTableList, $val);
						else{
							if($fieldIndex != 1)
								$update .= ", ";

							if($key == "updated")
								$update .= "$key = CURRENT_TIMESTAMP";
							else
								$update .= "$key = '$val'";

							$fieldIndex++;
						}
					}
				}

				if(!empty($update)){
					$sqlCmd = "UPDATE $tblName SET $update WHERE ".$data["condition"];
					$status = $mysqli->query($sqlCmd);
				}else
					$status = true;

				if(count($subTableList) > 0){
					foreach($subTableList as $subTable){
						$subTblName = $subTable["tblName"];
						$foreignKey = $subTable["foreignKey"];
						$subDataArr = $subTable["data"];

						foreach($subDataArr as $subData){
							$subUpdate = "";
							$subFieldIndex = 1;

							foreach($subData as $subKey=>$subVal){
								if($subKey == "condition")
									continue;
								else{
									if($subFieldIndex != 1)
										$subUpdate .= ", ";

									if($subKey == "updated")
										$subUpdate .= "$subKey = CURRENT_TIMESTAMP";
									else
										$subUpdate .= "$subKey = '$subVal'";
									
									$subFieldIndex++;
								}
							}

							$subSqlCmd = "UPDATE $subTblName SET $subUpdate WHERE ".$subData["condition"];
							$subStatus = $mysqli->query($subSqlCmd);
						}
					}
				}
			}

			if(count($subTableList) > 0){
				if($status && $subStatus)
					return true;
				else
					return false;
			}else{
				if($status)
					return true;
				else
					return false;
			}
		}

		//--Delete data function
		function deleteData($tblName, $condition){
			global $mysqli;

			$sqlCmd = "DELETE FROM $tblName WHERE $condition";

			if($mysqli->query($sqlCmd))
				return true;
			else
				return false;
		}

		//--Delete file in folder
		function deleteFile($pathFile, $itemList){
			$status = false;

			foreach($itemList as $item){
				foreach($item as $key=>$val){
					$status = unlink($pathFile.$val);
				}
			}

			if($status)
				return true;
			else
				return false;
		}

		//--Get message status 
		function messageInfo($status){
			$itemList = array(
				"successLogin"=>array(
					"status"=>true,
					"msg"=>"บัญชีผู้ใช้ถูกต้อง",
					"classIcon"=>"glyphicon glyphicon-ok",
					"classMsg"=>"text-success"
				),
				"errorLogin"=>array(
					"status"=>false,
					"msg"=>"บัญชีผู้ใช้ไม่ถูกต้อง",
					"classIcon"=>"glyphicon glyphicon-remove",
					"classMsg"=>"text-danger"
				),
				"successRegister"=>array(
					"status"=>true,
					"msg"=>"สมัครสมาชิกเรียบร้อย",
					"classIcon"=>"glyphicon glyphicon-ok",
					"classMsg"=>"text-success"
				),
				"errorRegister"=>array(
					"status"=>false,
					"msg"=>"ไม่สามารถสมัครสมาชิกได้",
					"classIcon"=>"glyphicon glyphicon-remove",
					"classMsg"=>"text-danger"
				),
				"errorUsernameAlready"=>array(
					"status"=>false,
					"msg"=>"ชื่อผู้ใช้ซ้ำ กรุณากรอกใหม่",
					"classIcon"=>"glyphicon glyphicon-remove",
					"classMsg"=>"text-danger"
				),
				"errorNameAlready"=>array(
					"status"=>false,
					"msg"=>"ชื่อที่ใช้แสดงซ้ำ กรุณากรอกใหม่",
					"classIcon"=>"glyphicon glyphicon-remove",
					"classMsg"=>"text-danger"
				),
				"errorEmailAlready"=>array(
					"status"=>false,
					"msg"=>"ชื่ออีเมล์ซ้ำ กรุณากรอกใหม่",
					"classIcon"=>"glyphicon glyphicon-remove",
					"classMsg"=>"text-danger"
				),
				"successInsert"=>array(
					"status"=>true,
					"msg"=>"บันทึกข้อมูลเรียบร้อย",
					"classIcon"=>"glyphicon glyphicon-ok",
					"classMsg"=>"text-success"
				),
				"errorInsert"=>array(
					"status"=>false,
					"msg"=>"ไม่สามารถบันทึกข้อมูลได้",
					"classIcon"=>"glyphicon glyphicon-remove",
					"classMsg"=>"text-danger"
				),
				"successUpdate"=>array(
					"status"=>true,
					"msg"=>"แก้ไขข้อมูลเรียบร้อย",
					"classIcon"=>"glyphicon glyphicon-ok",
					"classMsg"=>"text-success"
				),
				"errorUpdate"=>array(
					"status"=>false,
					"msg"=>"ไม่สามารถแก้ไขข้อมูลได้",
					"classIcon"=>"glyphicon glyphicon-remove",
					"classMsg"=>"text-danger"
				),
				"successDelete"=>array(
					"status"=>true,
					"msg"=>"ลบข้อมูลเรียบร้อย",
					"classIcon"=>"glyphicon glyphicon-ok",
					"classMsg"=>"text-success"
				),
				"errorDelete"=>array(
					"status"=>false,
					"msg"=>"ไม่สามารถลบข้อมูลได้",
					"classIcon"=>"glyphicon glyphicon-remove",
					"classMsg"=>"text-danger"
				)
			);

			return $itemList[$status];
		}

		//--Create and get session
		function getSession(){
			$session = array();

			if(!isset($_SESSION))
				session_start();

			if(isset($_SESSION["user_id"])){
				$session["user_id"] = $_SESSION["user_id"];
				$session["username"] = $_SESSION["username"];
				$session["name"] = $_SESSION["name"];
			}else{
				$session["user_id"] = "";
				$session["username"] = "";
				$session["name"] = "";
			}

			return $session;
		}

		//--Destroy session
		function destroySession(){
			if(!isset($_SESSION))
				session_start();

			if(isset($_SESSION["user_id"])){
				unset($_SESSION["user_id"]);
				unset($_SESSION["username"]);
				unset($_SESSION["name"]);
			}
		}
	}
?>