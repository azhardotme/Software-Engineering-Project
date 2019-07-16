<div id="content">
        	<div>
        		<img src="images/logo.jpg" width="400" height="500" style="float:left; margin-left:"/>
        	</div>
        	<div id="form2">
        	    <form action="" method="post">
                     <h1>Registration Here!</h1>
                     <table>
                         <tr>
                             <td align="right"><strong>Name:</strong></td>
                             <td><input type="text" name="u_name" required="required" placeholder="Enter your name"/></td> 
                         </tr>

                          <tr>
                             <td align="right"><strong>Email:</strong></td>
                             <td><input type="email" name="u_email" required="required" placeholder="Enter your email"/></td> 
                         </tr>

                          <tr>
                             <td align="right"><strong>Password:</strong></td>
                             <td><input type="password" name="u_pass" required="required" placeholder="Enter your password"/></td> 
                         </tr>

                          <tr>
                             <td align="right"><strong>Blood Group:</strong></td>
                             <td>
                                 <select name="u_blood_group">
                                    <option>select a blood group</option>
                                    <option>A+</option>
                                    <option>A-</option>
                                    <option>B+</option>
                                    <option>B-</option>
                                    <option>O-</option>
                                    <option>O+</option>
                                    <option>AB+</option>
                                    <option>AB-</option>
                                 </select>
                             </td> 
                         </tr>

                          <tr>
                             <td align="right"><strong>Gender:</strong></td>
                             <td>
                                 <select name="u_gender">
                                     <option>select a Gender</option>
                                     <option>Male</option>
                                     <option>Female</option>
                                 </select>
                             </td> 
                         </tr>

                          <tr>
                             <td align="right"><strong>Birthday:</strong></td>
                             <td><input type="date" name="u_birthday" required="required"/></td> 
                         </tr>

                         <tr>
                            <td colspan="7">
                                <button name="sign_up">Sign Up</button>
                            </td>
                         </tr>
 
                     </table>  
        	    </form>
                 <?php 
                 include("insert_user.php");
                 ?>	
        	</div>
            
        </div>
    </div>
          
</body>
</html>