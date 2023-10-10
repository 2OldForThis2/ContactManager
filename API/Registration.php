<?php
    $input = json_decode(file_get_contents('php://input'), true);
    
    $conn = new mysqli("localhost", "nstuh", "COP4331Contact", "COP4331");

    //If there is an error connecting return a connection error to front end.
    if( $conn->connect_error )
	{
		returnWithError( $conn->connect_error );
	}
    else
    {
        $stmt = $conn->prepare("SELECT * FROM Users WHERE Username = ?");
        $stmt->bind_param("s", $input["username"]);
        $stmt->execute();

        $result = $stmt->get_result();
        $rowCount = mysqli_num_rows($result);

        if($rowCount == 0){
            $stmt = $conn->prepare("INSERT INTO Users (FirstName, LastName, Username, Password) VALUES (?,?,?,?)");
            $stmt->bind_param("ssss", $input["firstname"], $input["lastname"], $input["username"], $input["password"]);
            $stmt->execute();
            $id = $stmt->insert_id;
            returnWithInfo($id);
        }
        else{
            returnWithError("Username Already Exists");
        }
        
    }






    //Sends json string to front end.
    function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
    
    //returns an error to the front end
    function returnWithError( $err )
	{
		$retValue = '{"id":0,"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}


    //compile data into json format and return info to the front end
    function returnWithInfo($id )
	{
		$retValue = '{"id":' . $id . ',"error":""}';
		sendResultInfoAsJson( $retValue );
	}





?>