<?php
      
    $conn = new PDO('mysql:host=localhost;dbname=IMDstagram', "root", "root");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    /*$insert = $conn->query("SELECT * FROM posts");	
    echo json_encode($data);*/
    // Need to output JSON headers and try to prevent caching.
    session_cache_limiter('nocache');
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Content-type: application/json');
    // Our JSON array to return
    //   - flagged would be 1 = success, 0 = failure
    //   - count would return the # flags, with -1 no return #
    //   - error code, see comments for description
    $json = array('flagged'=>0,'count'=>-1,'error'=>0);
    // Your logged in check code goes here 
    // you don't want non-logged in people doing this
    // Here, however you test to find out if someone is logged in,
    // check and return a -1 error to redirect the login.  
    session_start();
    if(!empty($_SESSION['user']))
    {
        // error -1 = not logged in, redirect browser
        $json['error'] = -1;
        exit(echo(json_encode($json)));
    }
    // Your mysql connection code goes here
    $reportFlag = mysql_real_escape_string($_GET['reportFlag']);
    if (empty($reportFlag) || !is_numeric($reportFlag)) 
    {
        // error 1 = comment id not found
        $json['error'] = 1;
    } 
    else 
    {
        $result = mysql_query("UPDATE reports SET flags = flags+1 WHERE pictureId = $reportFlag");
        if (!$result) 
        {
            $json['flagged'] = 0;
            // error 2 = update error
            $json['error'] = 2;
        } 
        else 
        {
            $json['flagged'] = 1;
            $count = mysql_query("SELECT flags FROM reports WHERE pictureId = $reportFlag LIMIT 0, 1");
            if ($count) 
            {
                $query = mysql_fetch_assoc($count);
                $json['count'] = $query['count'];
            } 
            else 
            {
                // error 3 = updated but did not get count
                $json['error'] = 3;
            }
        }
    }
    echo json_encode($json);
           
?>
