/* 
	Js functions for search a ticker in the database. 
	All functions return the result in the specific file, where it is called.
*/

/* 
	Function: showResult(str).
	Parameter:  str - String, which is searched in the db.
	Usage: called in SeachTicker.php.
	Called everytime a user type a letter in the search field (searchTicker.php).
	Return the result as table.
*/
function showResult(str) {
				// display all tickers on empty string
				if (str.length==0) { 
					showResult("%");				
					return;
				}
				// create new HTTP request
				if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				} else {  // code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				// called after change of state
				xmlhttp.onreadystatechange=function() {
					//  called this function after finish typing 
					if (this.readyState==4 && this.status==200) {
					// parse the resuling text from the db search
					var resultArray =  JSON.parse(this.responseText);
					// cut the lenght of the result
					if(resultArray.length > 100){
						document.getElementById("moreResults").innerHTML="There are "+(resultArray.length-100)+" more entries";
						var resultArray = resultArray.slice(0,100);
					}else{
						document.getElementById("moreResults").innerHTML="";
					}
					// create the resulting table
					var html = "";
						for (var row = 0; row < resultArray.length; row++) {
							html+="<tr>";
							for(var col = 0; col < 3; col++){
								if(col == 0){
									html+='<td><a href="index.php?action=displayTicker&ticker='+resultArray[row][col]+'">'+resultArray[row][col]+"</a></td>";
								}else{
									html+="<td>"+resultArray[row][col]+"</td>";
								}
							}
							html+="</tr>";
						}	
					// add the resulting table on the file (searchTicker.php)					
					document.getElementById("livesearch").innerHTML=html;
					document.getElementById("livesearch").style.border="1px solid #A5ACB2";
					}
				}
				// call the liveSearch.php for get results form the db.
				xmlhttp.open("GET","content/livesearch.php?q="+str,true);
				xmlhttp.send();
			}
/* 
	Function: searchTicker1(str).
	Parameter:  str - String, which is searched in the db.
	Usage: called in compareTwoTickers.php and oneAgainstAll.php.
	Called everytime a user type a letter in the search field for ticker 1 (compareTwoTickers.php & oneAgainstAll.php).
	Return the result as div.
*/
function searchTicker1(str) {
				// display all tickers on empty string
				if (str.length==0) { 
					showResult("%");	
				}
				// create new HTTP request
				if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				} else {  // code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				// called after change of state
				xmlhttp.onreadystatechange=function() {
					//  called this function after finish typing 
					if (this.readyState==4 && this.status==200) {
					// parse the resuling text from the db search
					var resultArray =  JSON.parse(this.responseText);
					// create the resulting div
					var html = "";
					html+="<select>";
					for (var row = 0; row < resultArray.length; row++) {		
						html+='<option value="'+resultArray[row][0]+'">'+resultArray[row][0]+"</option>";
					}						
					html+="</select>";
					// add the resulting div on the file
					document.getElementById("livesearch1").innerHTML=html;
					document.getElementById("livesearch1").style.border="1px solid #A5ACB2";
					}
				}
				// call the liveSearch.php for get results form the db.
				xmlhttp.open("GET","content/livesearch.php?q="+str,true);
				xmlhttp.send();
}
/* 
	Function: searchTicker1(str).
	Parameter:  str - String, which is searched in the db.
	Usage: called in compareTwoTickers.php and oneAgainstAll.php.
	Called everytime a user type a letter in the search field for ticker 2 (compareTwoTickers.php & oneAgainstAll.php).
	Return the result as div.
*/
function searchTicker2(str) {
				// display all tickers on empty string
				if (str.length==0) { 
					showResult("%");
				}
				// create new HTTP request
				if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				} else {  // code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				// called after change of state
				xmlhttp.onreadystatechange=function() {
					//  called this function after finish typing 
					if (this.readyState==4 && this.status==200) {
					// parse the resuling text from the db search
					var resultArray =  JSON.parse(this.responseText);
					// create the resulting div
					var html = "";
					html+="<select>";
					for (var row = 0; row < resultArray.length; row++) {		
						html+='<option value="'+resultArray[row][0]+'">'+resultArray[row][0]+"</option>";
					}						
					html+="</select>";
					// add the resulting div on the file
					document.getElementById("livesearch2").innerHTML=html;
					document.getElementById("livesearch2").style.border="1px solid #A5ACB2";
					}
				}
				// call the liveSearch.php for get results form the db.
				xmlhttp.open("GET","content/livesearch.php?q="+str,true);
				xmlhttp.send();
}