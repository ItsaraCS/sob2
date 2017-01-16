<?php
	class AdminManageAPI{
		function __construct(){
			require_once("DBService.php");
			$DbService = new DbService();
			$this->DbService = $DbService;
			$this->DbService->connectDb();

			if(isset($_POST["funcName"]))
				$this->$_POST["funcName"]($_FILES, $_POST);
			else{
				$data = json_decode(file_get_contents("php://input"), true);
				$this->$data["funcName"]($data["param"]);
			}
		}

		function getDataUserPermission($userID){
			$itemList = array();
			$usersData = array();
			$permissionData = array();

			$sqlCmd = "SELECT perm_id, p.user_id, p.menu_id, p.perm_status_id, ";
			$sqlCmd .= "m.menu_name, ps.perm_status, ps.perm_status_name ";
			$sqlCmd .= "FROM permission p ";
			$sqlCmd .= "INNER JOIN users u ";
			$sqlCmd .= "ON p.user_id = u.user_id ";
			$sqlCmd .= "INNER JOIN menu m ";
			$sqlCmd .= "ON p.menu_id = m.menu_id ";
			$sqlCmd .= "INNER JOIN permission_status ps ";
			$sqlCmd .= "ON p.perm_status_id = ps.perm_status_id ";
			$sqlCmd .= "WHERE p.user_id = '".$userID."' ";
			$sqlCmd .= "ORDER BY perm_id";
			$itemList = $this->DbService->getListObj($sqlCmd);

			echo json_encode($itemList, JSON_UNESCAPED_UNICODE);
		}

		function getCategoryList(){
			$itemList = array();

			$sqlCmd = "SELECT category_id, category_name ";
			$sqlCmd .= "FROM categories ";
			$sqlCmd .= "ORDER BY category_id";
			$itemList = $this->DbService->getListObj($sqlCmd);

			echo json_encode($itemList, JSON_UNESCAPED_UNICODE);
		}

		function getActivityList($categoryID){
			$itemList = array();

			$sqlCmd = "SELECT activity_id, activity_name ";
			$sqlCmd .= "FROM activities ";
			$sqlCmd .= "WHERE category_id = '".$categoryID."' ";
			$sqlCmd .= "ORDER BY activity_id";
			$itemList = $this->DbService->getListObj($sqlCmd);

			echo json_encode($itemList, JSON_UNESCAPED_UNICODE);
		}

		function getDataUpdate($activityID){
			$itemList = array(
				"activitiesData"=>array(),
				"activitiesImagesData"=>array()
			);
			$activitiesData = array();
			$activitiesImagesData = array();

			$year = "SUBSTRING(activity_date, 1, 4)";
			$month = "SUBSTRING(activity_date, 6, 2)";
			$date = "SUBSTRING(activity_date, 9, 2)";
			$activity_date = "CONCAT(".$date.", '/', ".$month.", '/', ".$year.") AS activity_date";

			$sqlCmd = "SELECT activity_id, activity_name, activity_description, ".$activity_date.", category_id, category_id AS update_category_id ";
			$sqlCmd .= "FROM activities ";
			$sqlCmd .= "WHERE activity_id = '".$activityID."' ";
			$sqlCmd .= "ORDER BY activity_id";
			$activitiesData = $this->DbService->getObj($sqlCmd);

			$sqlCmd = "SELECT activity_image_id, activity_image_url, activity_id ";
			$sqlCmd .= "FROM activities_images ";
			$sqlCmd .= "WHERE activity_id = '".$activityID."' ";
			$sqlCmd .= "ORDER BY activity_image_id";
			$activitiesImagesData = $this->DbService->getListObj($sqlCmd);

			$itemList["activitiesData"] = $activitiesData;
			$itemList["activitiesImagesData"] = $activitiesImagesData;

			echo json_encode($itemList, JSON_UNESCAPED_UNICODE);
		}

		function getNameUserList(){
			$itemList = array();

			$sqlCmd = "SELECT user_id, name ";
			$sqlCmd .= "FROM users ";
			$sqlCmd .= "ORDER BY user_id";
			$itemList = $this->DbService->getListObj($sqlCmd);

			echo json_encode($itemList, JSON_UNESCAPED_UNICODE);
		}

		function getPermissionStatusList(){
			$itemList = array();

			$sqlCmd = "SELECT perm_status_id, perm_status_name ";
			$sqlCmd .= "FROM permission_status ";
			$sqlCmd .= "ORDER BY perm_status_id";
			$itemList = $this->DbService->getListObj($sqlCmd);

			echo json_encode($itemList, JSON_UNESCAPED_UNICODE);
		}

		function getDataSetting($userID){
			$itemList = array(
				"usersData"=>array(),
				"permissionData"=>array()
			);
			$usersData = array();
			$permissionData = array();

			$sqlCmd = "SELECT user_id, username, password, name, email, phone, position, user_id AS setting_user_id ";
			$sqlCmd .= "FROM users ";
			$sqlCmd .= "WHERE user_id = '".$userID."'";
			$usersData = $this->DbService->getObj($sqlCmd);

			$sqlCmd = "SELECT perm_id, p.user_id, p.menu_id, p.perm_status_id, ";
			$sqlCmd .= "m.menu_name, ps.perm_status, ps.perm_status_name ";
			$sqlCmd .= "FROM permission p ";
			$sqlCmd .= "INNER JOIN users u ";
			$sqlCmd .= "ON p.user_id = u.user_id ";
			$sqlCmd .= "INNER JOIN menu m ";
			$sqlCmd .= "ON p.menu_id = m.menu_id ";
			$sqlCmd .= "INNER JOIN permission_status ps ";
			$sqlCmd .= "ON p.perm_status_id = ps.perm_status_id ";
			$sqlCmd .= "WHERE p.user_id = '".$userID."' ";
			$sqlCmd .= "ORDER BY perm_id";
			$permissionData = $this->DbService->getListObj($sqlCmd);

			$itemList["usersData"] = $usersData;
			$itemList["permissionData"] = $permissionData;

			echo json_encode($itemList, JSON_UNESCAPED_UNICODE);
		}

		function insertActivities($file, $post){
			$itemList = array();
			$status = false;

			$tblName = $post["tblName"];
			$dataArr = json_decode($post["data"], true);
			$fileArr = $file;

			$status = $this->insertDataSubTable($tblName, $dataArr, $fileArr);

			if($status)
				$itemList = $this->DbService->messageInfo("successInsert");
			else
				$itemList = $this->DbService->messageInfo("errorInsert");

			echo json_encode($itemList, JSON_UNESCAPED_UNICODE);
		}

		function updateActivities($file, $post){
			$itemList = array();
			$status = false;

			$tblName = $post["tblName"];
			$dataArr = json_decode($post["data"], true);
			$fileArr = $file;

			$status = $this->updateDataSubTable($tblName, $dataArr, $fileArr);

			if($status)
				$itemList = $this->DbService->messageInfo("successUpdate");
			else
				$itemList = $this->DbService->messageInfo("errorUpdate");

			echo json_encode($itemList, JSON_UNESCAPED_UNICODE);
		}

		function insertDataSubTable($tblName, $dataArr, $fileArr){
			global $mysqli;

			foreach($dataArr as $data){
				$status = false;
				$subStatus = false;
				$subStatusUpload = false;
				$fields = "";
				$values = "";
				$index = 1;
				$fieldIndex = 1;
				$subTableList = array();
				$pathUpload = "../ActivitiesImages/";

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
						$lastInsert = 1;
						$fileName = "";

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
								$fileName = "activity-".$lastInsertID."-".$lastInsert.".".explode(".", $subVal)[count($subVal)];

								if($subFields == "activity_image_url")
									$subValues .= "'$fileName'";
								else
									$subValues .= "'$subVal'";
									
								$subFieldIndex++;
							}

							$subSqlCmd = "INSERT INTO $subTblName($subFields, $foreignKey) VALUES($subValues, '$lastInsertID')";
							$subStatus = $mysqli->query($subSqlCmd);

							if($subStatus)
								$subStatusUpload = move_uploaded_file($fileArr["activity-".$index."-".$lastInsert.""]["tmp_name"], $pathUpload.$fileName);
							
							$lastInsert++;
						}
					}
				}
				$index++;
			}

			if(count($subTableList) > 0){
				if($status && $subStatus && $subStatusUpload)
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

		function deleteActivities($activityID){
			$itemList = array();
			$status = false;
			$pathFile = "../ActivitiesImages/";

			$sqlCmd = "SELECT activity_image_url ";
			$sqlCmd .= "FROM activities_images ";
			$sqlCmd .= "WHERE activity_id = '".$activityID."'";

			$itemList = $this->DbService->getListObj($sqlCmd);
			$status = $this->DbService->deleteFile($pathFile, $itemList);

			$sqlCmd = "DELETE FROM activities_images ";
			$sqlCmd .= "WHERE activity_id = '".$activityID."'; ";
			$sqlCmd .= "DELETE FROM activities ";
			$sqlCmd .= "WHERE activity_id = '".$activityID."'";

			$condition = "activity_id = '".$activityID."'";
			$status = $this->DbService->deleteData("activities_images", $condition);

			if($status)
				$status = $this->DbService->deleteData("activities", $condition);

			if($status)
				$itemList = $this->DbService->messageInfo("successDelete");
			else
				$itemList = $this->DbService->messageInfo("errorDelete");

			echo json_encode($itemList, JSON_UNESCAPED_UNICODE);
		}

		function updateDataSubTable($tblName, $dataArr, $fileArr){
			global $mysqli;

			foreach($dataArr as $data){
				$status = false;
				$subStatus = false;
				$subStatusUpload = false;
				$update = "";
				$fieldIndex = 1;
				$subTableList = array();
				$pathUpload = "../ActivitiesImages/";
				
				foreach($data as $key=>$val){
					if($key == "condition")
						continue;
					else{
						if(is_array($val))
							$subTableList[$key] = $val;
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
					if(isset($subTableList["activityImageOriginUpdateList"])){
						foreach($subTableList["activityImageOriginUpdateList"] as $subTable){
							$subSqlCmd = "DELETE FROM activities_images ";
							$subSqlCmd .= "WHERE activity_image_id = '".$subTable["activity_image_id"]."'";
							$subStatus = $mysqli->query($subSqlCmd);
							
							if($subStatus)
								$subStatusUpload = unlink($pathUpload.$subTable["activity_image_url"]);
						}
					}

					if(isset($subTableList["tbl_activities_images"])){
						$subTblName = $subTableList["tbl_activities_images"]["tblName"];
						$foreignKey = $subTableList["tbl_activities_images"]["foreignKey"];
						$foreignKeyID = $subTableList["tbl_activities_images"]["foreignKeyID"];
						$subDataArr = $subTableList["tbl_activities_images"]["data"];
						$fileName = "";

						$subSqlCmd = "SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(activity_image_url, '-', -1), '.', 1) AS activity_image_url ";
						$subSqlCmd .= "FROM activities_images ";
						$subSqlCmd .= "WHERE activity_id = '".$foreignKeyID."' ";
						$subSqlCmd .= "ORDER BY activity_image_id DESC ";
						$subSqlCmd .= "LIMIT 1";
						$subSqlCmdQuery = $mysqli->query($subSqlCmd);
						$fetchQuery = mysqli_fetch_assoc($subSqlCmdQuery);
						$lastUpdate = $fetchQuery["activity_image_url"];
						$fileUpdate = 1;

						foreach($subDataArr as $subData){
							$subFields = "";
							$subValues = "";
							$subFieldIndex = 1;

							foreach($subData as $subKey=>$subVal){
								if($subFieldIndex != 1){
									$subFields .= ", ";
									$subValues .= ", ";
								}
								$fileName = "activity-".$foreignKeyID."-".($lastUpdate + 1).".".explode(".", $subVal)[count($subVal)];
								$subFields .= "$subKey";

								if($subFields == "activity_image_url")
									$subValues .= "'$fileName'";
								else
									$subValues .= "'$subVal'";
									
								$subFieldIndex++;
							}

							$subSqlCmd = "INSERT INTO $subTblName($subFields, $foreignKey) VALUES($subValues, '".$foreignKeyID."')";
							$subStatus = $mysqli->query($subSqlCmd);

							if($subStatus)
								$subStatusUpload = move_uploaded_file($fileArr["activity-".$foreignKeyID."-".$fileUpdate.""]["tmp_name"], $pathUpload.$fileName);
							
							$lastUpdate++;
							$fileUpdate++;
						}
					}
				}
			}

			if(count($subTableList) > 0){
				if($status && $subStatus && $subStatusUpload)
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

		function checkUserAlready($param){
			$itemList = array();
			$status = false;

			$sqlCmd = "SELECT ".$param["field"]." ";
			$sqlCmd .= "FROM users ";
			$sqlCmd .= "WHERE ".$param["field"]." = '".$param["value"]."' ";
			$sqlCmd .= "AND user_id != '".$param["userID"]."'";

			$itemList = $this->DbService->getListObj($sqlCmd);

			if(count($itemList) > 0){
				$itemList = $this->DbService->messageInfo($param["messageInfo"]);
			}

			echo json_encode($itemList, JSON_UNESCAPED_UNICODE);
		}

		function deleteSetting($userID){
			$itemList = array();
			$status = false;

			$condition = "user_id = '".$userID."'";
			$status = $this->DbService->deleteData("permission", $condition);

			if($status)
				$status = $this->DbService->deleteData("users", $condition);

			if($status)
				$itemList = $this->DbService->messageInfo("successDelete");
			else
				$itemList = $this->DbService->messageInfo("errorDelete");

			echo json_encode($itemList, JSON_UNESCAPED_UNICODE);
		}

		function updateSetting($param){
			$itemList = array();
			$status = false;

			$tblName = $param["tblName"];
			$dataArr = $param["data"];

			$status = $this->DbService->updateDataSubTable($tblName, $dataArr);

			if($status)
				$itemList = $this->DbService->messageInfo("successUpdate");
			else
				$itemList = $this->DbService->messageInfo("errorUpdate");

			echo json_encode($itemList, JSON_UNESCAPED_UNICODE);
		}
	}

	$self = new AdminManageAPI();
?>