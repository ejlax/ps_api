<h3>
	<p>CSV Import tool</p>
</h3>
<form method='post' action="import.php" enctype='multipart/form-data'>
	Account:&nbsp<input type='text' name='account' placeholder='Account'></input><br>
	Access Token:&nbsp<input type='text' name='token' placeholder='Token'></input><br>
	Canvas Domain:&nbsp<input type='text' name='domain'></input><br>
	<!--  Canvas URL:&nbsp<input type='text' name='url'></input><br>  -->
	CSV File:&nbsp<input type="file" name='inputFile'></input>
	<button type='submit' name='submit'>Submit</button>
</form>

