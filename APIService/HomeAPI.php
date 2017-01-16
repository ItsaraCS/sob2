<?php
	class HomeAPI{
		function __construct(){
			require_once("DBService.php");
			$connectDb = new DbService();
			$this->connectDb = $connectDb;
			$this->connectDb->connectDb();

			$data = json_decode(file_get_contents("php://input"), true);
			$this->$data["funcName"]($data["param"]);
		}

		function getActivityList(){
			global $mysqli;
			$itemList = array();

			$dateFirstDigit = $this->connectDb->parseArabicToThaiNumForSQL("SUBSTRING(activity_date, 9, 1)");
			$dateSecondDigit = $this->connectDb->parseArabicToThaiNumForSQL("SUBSTRING(activity_date, 10, 1)");
			$dateFormat = $dateFirstDigit.", ".$dateSecondDigit;
			$monthFormat = $this->connectDb->parseArabicToThaiMonthForSQL("SUBSTRING(activity_date, 6, 2)");
			$year = "SUBSTRING(activity_date, 1, 4) + 543";
			$yearFirstDigit = $this->connectDb->parseArabicToThaiNumForSQL("SUBSTRING(".$year.", 1, 1)");
			$yearSecondDigit = $this->connectDb->parseArabicToThaiNumForSQL("SUBSTRING(".$year.", 2, 1)");
			$yearThirdDigit = $this->connectDb->parseArabicToThaiNumForSQL("SUBSTRING(".$year.", 3, 1)");
			$yearFourthDigit = $this->connectDb->parseArabicToThaiNumForSQL("SUBSTRING(".$year.", 4, 1)");
			$yearFormat = $yearFirstDigit.", ".$yearSecondDigit.", ".$yearThirdDigit.", ".$yearFourthDigit;
			$activity_date = "CONCAT(".$dateFormat.", ' ', ".$monthFormat.", ' ', ".$yearFormat.") AS activity_date";

			$sqlCmd = "SELECT a.activity_id, a.category_id, activity_name, activity_description, ".$activity_date.", ";
			$sqlCmd .= "c.category_name, ai.activity_image_id, ai.activity_image_url ";
			$sqlCmd .= "FROM activities a ";
			$sqlCmd .= "INNER JOIN categories c ";
			$sqlCmd .= "ON a.category_id = c.category_id ";
			$sqlCmd .= "INNER JOIN activities_images ai ";
			$sqlCmd .= "ON a.activity_id = ai.activity_id ";
			$sqlCmd .= "GROUP BY activity_id ";
			$sqlCmd .= "ORDER BY activity_id DESC ";
			$sqlCmd .= "LIMIT 7";
			$query = $mysqli->query($sqlCmd)
				or die("<b>SQL error</b>: \"".$sqlCmd."\"<br><b>Parse error</b>: ".$mysqli->error);

			while($data = $query->fetch_assoc()){
				if(in_array("activity_image_url", array_keys($data))){
					$sqlCmdSub = "SELECT activity_image_url ";
					$sqlCmdSub .= "FROM activities_images ";
					$sqlCmdSub .= "WHERE activity_id = '".$data["activity_id"]."' ";
					$sqlCmdSub .= "ORDER BY activity_image_id";

					$data["activity_image_url_list"] = $this->connectDb->getListObj($sqlCmdSub);
				}
				array_push($itemList, $data);
			}

			echo json_encode($itemList, JSON_UNESCAPED_UNICODE);
		}
	}

	$self = new HomeAPI();
?>