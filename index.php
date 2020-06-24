<?php

	session_start();
	
	$error = "";
	
	if(array_key_exists("submit",$_POST))
	{
		 $link = mysqli_connect("localhost","root","","forum");
		
		if(mysqli_connect_error())
		{
			die("does not connect to database");
		}
		
				if(!$_POST['email'])
				{
					$error .= "<p>Email address is required</p>";
				}
				
				if(!$_POST['password'])
				{
					$error .= "<p>Password is required</p>";
				}
				
				if(!$_POST['name'])
				{
					$error .= "<p>Name is required</p>";
				}
				
				if(!$_POST['year'])
				{
					$error .= "<p>Pursuing year is required</p>";
				}
				
				if(!$_POST['branch'])
				{
					$error .= "<p>Branch is required</p>";
				}
				
				if(!$_POST['userid'])
				{
					$error .= "<p>User Id is required</p>";
				}
				
				if($error != "")
				{
					$error = "<p>There is/are some error(s)</p>".$error;
				}
				
	
		else
		{
			if($_POST['signUp'] == '1')
			{
				
				
				$query = "SELECT id FROM users WHERE email = '".mysqli_real_escape_string($link,$_POST['email'])."'LIMIT 1";
				
				$result = mysqli_query($link,$query);
				
				if(mysqli_num_rows($result)>0)
				{
					$error = "Email address already exists";
				}
				else
				{
					
					$query = "INSERT INTO users (email,password,name,year,branch,userid) VALUES ('".mysqli_real_escape_string($link,$_POST['email'])."','".mysqli_real_escape_string($link,$_POST['password'])."','".mysqli_real_escape_string($link,$_POST['name'])."','".mysqli_real_escape_string($link,$_POST['year'])."','".mysqli_real_escape_string($link,$_POST['branch'])."','".mysqli_real_escape_string($link,$_POST['userid'])."')";
			
					if(!mysqli_query($link,$query))
					{
						$error = "<p>There is error while signing up - please try again later</p>";
					}
					else
					{
						$query = "UPDATE users SET password = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id = ".mysqli_insert_id($link);
				
						$result = mysqli_query($link,$query);
								
						$_POST['id'] = mysqli_insert_id($link);
	
					}
				}
			}
			else
			{
				if(!$_POST['userid'])
				{
					$error .= "<p>User Id is required</p>";
				}
				
				if(!$_POST['password'])
				{
					$error .= "<p>Password is required</p>";
				}
				
				$query = "SELECT * FROM users WHERE userid = '".mysqli_real_escape_string($link,$_POST['userid'])."'";
				
				$result = mysqli_query($link,$query);
				
				$row = mysqli_fetch_array($result);
				
				if(isset($row))
				{
					$hashedPassword = md5(md5($row['id']).$_POST['password']);
					
					if($hashedPassword == $row['password'])
					{
						$_POST['id'] = $row['id'];
						
					}
					else
					{
						$error = "That email/password combination could not found.";
					}
				}
				else
				{
					$error = "That email/password combination could not found.";
				}
			}
		}
	}	

?>

<!DOCTYPE html>
<html>
<head>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Forum Name</title>  
    
    <link rel="stylesheet" type="text/css" href="project.css">
    
    <script type="text/javascript" src="jquery.min.js"></script>
	
	<script src="jquery-ui/jquery-ui.js"></script>
		
	<link href="jquery-ui/jquery-ui.css" rel="stylesheet">
	
	<style type="text/css">
	
		#error{
			background:none;
			color:red;
		}
		
		
	
	</style>
      
</head>
    
<body>
    
    <div class="header">
        
        <div id="date"></div>
         
        <div id="title">
            
            <img src="#" id="logo">
            
            <h1>Project Name</h1>
            
        </div>
    
    </div>
    
    <div class="main-content">
        
					 <div id="error">
				
					<?php if($error != ""){
						echo $error;	
					}?>
					
				</div>
	   
                <div class="split left">

                    <h1>Sign Up</h1>
                    <span id="sign-up" ><img src="Images/arrow1.png"></span> 
                    
                </div>

                <div class="split right">

                     <h1>Login</h1>
                     <span id="login" ><img src="Images/arrow2.png"></span> 
                    
                </div>
             
				
			 
                <div id="split-right" >

                    <img src="Images/arrow3.png" id="back-to-login">
					
					<form method="post">

                    <div id="sign-up-form">
					
						<p>Sign-Up Form</p>
						
							<label for="name">Name :</label>
							<input type="text" name="name" placeholder="eg.Sanket Deone">
							
							<label for="email">Email :</label>
							<input type="email" name="email" placeholder="eg.sanketsd@gmail.com">
							
							<label name="year" for="years">Class :</label>

								<select name="year" >
								  <option value="0">Choose a year :</option>
								  <option value="FE">First Year</option>
								  <option value="SE">Second Year</option>
								  <option value="TE">Third Year</option>
								  <option value="BE">Last Year</option>
								</select>
														
							<label name="branch" for="branches">Branch :</label>
							<input list="branches" name="branch" >
								<select name="branch" >
								  <option value="0">Choose a branch :</option>
								  <option value="CSE">Computer Engg</option>
								  <option value="ME">Mechanical Engg</option>
								  <option value="EE">Electrical Engg</option>
								  <option value="PE">Printing Engg</option>
								  <option value="CE">Civil Engg</option>
								  <option value="ENTC">Electronics & Telecommunication</option>
								  <option value="IT">Information & Technology</option>
								</select>
							
							<label for="userid">User ID : </label>
							<input name="userid" type="text" placeholder="User Id">
							
							<label for="password">Password :</label>
							<input name="password" type="password" placeholder="Password">
							
							<input type="hidden" name="signUp" value="1">
							
							<input type="submit" name="submit" value="Sign Up">
						  
						<p><a  id="goToLogIn" >Log In</a></p>
					
					</div>
					
					</form>
	
                </div> 
        
                  <div id="split-left" >

                       <img src="Images/arrow4.png" id="back-to-sign-up">
					   
					   
					   <form method="post">

							<div id="login-form">
								
								<p>Login Form</p>
								
									<label for="userid">User ID </label>
									<input name="userid" type="text" placeholder="User Id">
									
									<label for="password">Password</label>
									<input name="password" type="password" placeholder="Password"><br>
									
									<input type="hidden" name="signUp" value="0">
								  
									<input type="submit" name="submit" value="Login">
									
									<p><a  id="goToSignUp" >Sign Up</a></p>
							
							</div>
							
						</form>
						
					</div> 
				
				
        
      </div>
      
    <div class="footer">
        
                <p>&copy;<span id="copyright">copyright text</span></p>
        
    </div>
    
    <!--------------------------------------------------Javascript Section---------------------------------------------------------->
    
    <script type="text/javascript">
  
                n =  new Date();
                var day = n.getDay();
                var daylist = ["Sunday","Monday","Tuesday","Wednesday ","Thursday","Friday","Saturday"];
                y = n.getFullYear();
                m = n.getMonth() + 1;
                d = n.getDate();
                document.getElementById("date").innerHTML = daylist[day] + " " +d + "/" + m + "/" + y;
        
        
                $(document).ready(function() {
         
                            
                                 $('.left').click(function() {

                                        $('#split-right').toggle("slide");  
                                            
                                  });
                    
                                 $('.right').click(function() {

                                        $('#split-left').toggle("slide");                 

                                  });
                              
                                  $('#back-to-login').click(function() {

                                      $('#split-right').css("display","none");       
                            
                                 });
                    
                                 $('#back-to-sign-up').click(function() {

                                        $('#split-left').css("display","none");              

                                 });
								 
								 $('#goToLogIn').click(function(){
										
										
								});
                   
                 }); 
        
    </script>
        
</body>
    
</html> 
