function showResult(str) {
				if (str.length==0) { 
					showResult("%");				
					return;
				}
				if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				} else {  // code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=function() {
					if (this.readyState==4 && this.status==200) {
					var resultArray =  JSON.parse(this.responseText);
					if(resultArray.length > 100){
						document.getElementById("moreResults").innerHTML="There are "+(resultArray.length-100)+" more entries";
						var resultArray = resultArray.slice(0,100);
					}else{
						document.getElementById("moreResults").innerHTML="";
					}
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
					document.getElementById("livesearch").innerHTML=html;
					document.getElementById("livesearch").style.border="1px solid #A5ACB2";
					}
				}
				xmlhttp.open("GET","content/livesearch.php?q="+str,true);
				xmlhttp.send();
			}
			
function searchTicker1(str) {
				if (str.length==0) { 
					showResult("%");
					
				}
				if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				} else {  // code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=function() {
					if (this.readyState==4 && this.status==200) {
					var resultArray =  JSON.parse(this.responseText);
					var html = "";
					html+="<select>";
					for (var row = 0; row < resultArray.length; row++) {		
						html+='<option value="'+resultArray[row][0]+'">'+resultArray[row][0]+"</option>";
					}						
					html+="</select>";
					document.getElementById("livesearch1").innerHTML=html;
					document.getElementById("livesearch1").style.border="1px solid #A5ACB2";
					}
				}
				xmlhttp.open("GET","content/livesearch.php?q="+str,true);
				xmlhttp.send();
}

function searchTicker2(str) {
				if (str.length==0) { 
					showResult("%");
					
				}
				if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				} else {  // code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=function() {
					if (this.readyState==4 && this.status==200) {
					var resultArray =  JSON.parse(this.responseText);
					var html = "";
					html+="<select>";
					for (var row = 0; row < resultArray.length; row++) {		
						html+='<option value="'+resultArray[row][0]+'">'+resultArray[row][0]+"</option>";
					}						
					html+="</select>";
					document.getElementById("livesearch2").innerHTML=html;
					document.getElementById("livesearch2").style.border="1px solid #A5ACB2";
					}
				}
				xmlhttp.open("GET","content/livesearch.php?q="+str,true);
				xmlhttp.send();
}