<?php
	class AdminAPI{
		function __construct(){
			require_once("DBService.php");
			$DbService = new DbService();
			$this->DbService = $DbService;
			$this->DbService->connectDb();

			$data = json_decode(file_get_contents("php://input"), true);
			$this->$data["funcName"]($data["param"]);
		}

		function getSession(){
			$itemList = array();

			$itemList = $this->DbService->getSession();

			echo json_encode($itemList, JSON_UNESCAPED_UNICODE);
		}

		function login($param){
			$itemList = array();

			$sqlCmd = "SELECT user_id, username, name ";
			$sqlCmd .= "FROM users ";
			$sqlCmd .= "WHERE username = '".$param["username"]."' ";
			$sqlCmd .= "AND password = '".$param["password"]."'";
			$item = $this->DbService->getObj($sqlCmd);

			if(count($item) != 0){
				if(!isset($_SESSION))
					session_start();

				$_SESSION["user_id"] = $item["user_id"];
				$_SESSION["username"] = $item["username"];
				$_SESSION["name"] = $item["name"];
				$itemList = $this->DbService->messageInfo("successLogin");
			}else{
				$itemList = $this->DbService->messageInfo("errorLogin");
			}

			echo json_encode($itemList, JSON_UNESCAPED_UNICODE);
		}

		function checkUserAlready($param){
			$itemList = array();
			$status = false;

			$sqlCmd = "SELECT ".$param["field"]." ";
			$sqlCmd .= "FROM users ";
			$sqlCmd .= "WHERE ".$param["field"]." = '".$param["value"]."'";

			$itemList = $this->DbService->getListObj($sqlCmd);

			if(count($itemList) > 0){
				$itemList = $this->DbService->messageInfo($param["messageInfo"]);
			}

			echo json_encode($itemList, JSON_UNESCAPED_UNICODE);
		}

		function register($param){
			$itemList = array();
			$status = false;

			$tblName = $param["tblName"];
			$dataArr = $param["data"];

			$status = $this->DbService->insertData($tblName, $dataArr);

			if($status){
				$sqlCmd = "SELECT menu_id ";
				$sqlCmd .= "FROM menu";
				$itemList = $this->DbService->getListObj($sqlCmd);

				$sqlCmd = "SELECT user_id ";
				$sqlCmd .= "FROM users ";
				$sqlCmd .= "ORDER BY user_id DESC ";
				$sqlCmd .= "LIMIT 1";
				$lastUserID = $this->DbService->getObj($sqlCmd);

				foreach($itemList as $item){
					$data = array(
						"user_id"=>$lastUserID["user_id"],
						"menu_id"=>$item["menu_id"],
						"perm_status_id"=>"3"
					);
					
					array_push($dataArr, $data);
				}

				$status = $this->DbService->insertData("permission", $dataArr);

				if($status){
					$itemList = $this->DbService->messageInfo("successRegister");
				}else{
					$itemList = $this->DbService->messageInfo("errorRegister");
				}

				echo json_encode($itemList, JSON_UNESCAPED_UNICODE);
			}
		}

		function logout(){
			$itemList = array();

			$this->DbService->destroySession();

			echo json_encode($itemList, JSON_UNESCAPED_UNICODE);
		}
	}

	$self = new AdminAPI();
?>