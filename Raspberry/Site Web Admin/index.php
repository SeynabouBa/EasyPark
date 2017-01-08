<!DOCTYPE html>
<html>
	<head>
	  <meta charset="utf-8" />
	  <link rel="stylesheet" href="style.css" />
	  <title>EasyPark Nodes management</title>
	</head>
	<body>
		<form>
			<label for="new_node_id">Node ID</label>  <input type="text" id="id" class="champ" />
			<label for="new_node_latitude">Latitude</label> <input type="text" id="latitude" class="champ" />
			<label for="new_node_longitude">Longitude</label> <input type="text" id="longitude" class="champ" />
			<input type="submit" id="add" value="Add Node" onclick="return addButton();" />
			<input type="reset" id="reset" value="Reset" onclick="return resetButton();" />
		</form>

		<p>
			Table:	<input type="button" id="refresh" value="Refresh Table" onclick="return refreshButton();" />
			<table id="table">
			</table>
		</p>
	
		<script>
		// show all contents in MySQL database
		selectRequest();
		
		function addButton(){
			var node_id = document.getElementById('id').value;
			var node_latitude = document.getElementById('latitude').value;
			var node_longitude = document.getElementById('longitude').value;

			if(node_id!==""&&node_latitude!==""&&node_longitude!==""){
				insertRequest(node_id, node_latitude, node_longitude);
			}else{
				alert("Something is missing!");
			}
		}

		function resetButton(){
			$champ.css({ // on remet le style des champs comme on l'avait défini dans le style CSS
				borderColor : '#ccc',
				color : '#555'
			});
			$erreur.css('display', 'none'); // on prend soin de cacher le message d'erreur
		}
		
		function deleteButton(currentRow){
			var node_id = document.getElementById('table').rows[currentRow].cells[0].innerHTML;
			var result = confirm("Are you resure to delete the node?");

			if(result){
				deleteRequest(node_id);
			}
		}
		
		function refreshButton(){
			selectRequest();
		}
		
		function insertRequest(node_id, node_latitude, node_longitude){
			var ajaxurl = 'nodes.php';
			var params = 'action=insert&node_id='+node_id+'&node_latitude='+node_latitude+'&node_longitude='+node_longitude;

			var xhr = new XMLHttpRequest();
			xhr.open('POST', ajaxurl, true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.openreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					alert(http.responseText);
				}
			}
			xhr.send(params);
		}
		
		function deleteRequest(node_id){
			var ajaxurl = 'nodes.php';
			var params = 'action=delete&node_id='+node_id;

			var xhr = new XMLHttpRequest();
			xhr.open('POST', ajaxurl, true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.openreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					alert(http.responseText);
				}
			}
			xhr.send(params);
		}
		
		function selectRequest(node_id){
			var ajaxurl = 'nodes.php';
			var xhr = new XMLHttpRequest();
			
			xhr.onreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					document.getElementById('table').innerHTML = this.responseText;
				}
			}
			if(node_id!==undefined){
				xhr.open('GET', ajaxurl+'?node_id='+node_id, true);
			}else{
				xhr.open('GET', ajaxurl, true);
			}
			xhr.send(null);
		}
		</script>
	</body>
</html>