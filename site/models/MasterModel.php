<?php
	
	class MasterModel{

		//Module view All
		public static function get_all_from(){

			$sql_query = " SELECT * FROM List as l ";

			$results = mysqli_query(Database::$dbc,$sql_query);

			if(!$results){
				return die("Query {$sql_query}\n<br/> MYSQL Error:".mysqli_error(Database::$dbc));
			}
			else{
				
				while($data = mysqli_fetch_array($results,MYSQLI_ASSOC)){
					$row[]=$data;
				}
				if(!empty($row)){
					return $row;
				}

			}
			
		}

		public function insert_list($list){

			$query = " 	INSERT INTO List (Name, Start_Day, End_Day, Status_ID ) 
        				VALUES ( '" .$list["name"]. "', '" .$list["start_day"]. "', '" .$list["end_day"]. "', '" .$list["status"]. "')";

        	$results = mysqli_query( Database::$dbc, $query );

        	if(!$results){
        		return die("Query {$query}\n<br/> MYSQL Error:".mysqli_error(Database::$dbc));
        	}
        	else{
        		return $results;
        	}

		}

		//Module View Single
		public function update_list($id, $list) {

			intval($id);

			$query = " 	UPDATE List 
					   	SET Name = '" .$list["name"]. "', Start_Day = ".$list["start_day"] .", End_Day = ".$list["end_day"] .", Status_ID = " . $list["status"] . " 
					   	WHERE List_ID = " . $id;

        	$results = mysqli_query( Database::$dbc, $query );


        	if(!$results){
        		return die("Query {$query}\n<br/> MYSQL Error:".mysqli_error(Database::$dbc));
        	}
        	else{
        		return TRUE;
        	}
		}

		public function delete_list($id) {

			intval($id);

			$query = "	DELETE FROM List
						WHERE List_ID = ". $id;

			$results = mysqli_query( Database::$dbc, $query );


        	if(!$results){
        		return die("Query {$query}\n<br/> MYSQL Error:".mysqli_error(Database::$dbc));
        	}
        	else{
        		return TRUE;
        	}

		}
		
	}