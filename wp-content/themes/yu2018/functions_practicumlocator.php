<?php
  
  
function isMobileDevice() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}


// [csv_data]


function csv_data_function(){
	if(isMobileDevice()){
	?>
		<div>City: <input id="input_city" type="text" placeholder="Search.." size="30" style="width: 200px;display: initial;" value=""><!--<button id="city_search" onclick="LoadCity()" style="background:yellow; border: 2px solid;width:80px;height: 40px;">Search</button>--></div>
		<div>Province: <input id="input_province" type="text" placeholder="Search.." size="25" style="width: 200px;display: initial;" value=""><!--<button id="province_search" onclick="LoadCity()" style="background:yellow;border: 2px solid;width:80px;height: 40px;">Search</button>--></div>
		<div>Postal: <input id="input_postal" type="text" placeholder="Search.." size="15" style="width: 200px;display: initial;" value=""><button id="postal_search" onclick="LoadCity()" style="background:yellow;border: 2px solid;width:80px;height: 40px;">Search</button></div>
         <br />    
	<?php
	}
	else{
	?>
		<div class="grid-x">
			<div class="columns small-4">City: <input id="input_city" type="text" placeholder="Search.." size="30" style="width: 200px;display: initial;" value=""><!--<button id="city_search" onclick="LoadCity()" style="background:yellow; border: 2px solid;width:80px;height: 40px;">Search</button>--></div>
			<div class="columns small-4">Province: <input id="input_province" type="text" placeholder="Search.." size="25" style="width: 200px;display: initial;" value=""><!--<button id="province_search" onclick="LoadProvince()" style="background:yellow;border: 2px solid;width:80px;height: 40px;">Search</button>--></div>
			<div class="columns small-4">Postal: <input id="input_postal" type="text" placeholder="Search.." size="15" style="width: 200px;display: initial;" value="">&nbsp;&nbsp;&nbsp;<button id="postal_search" onclick="LoadCity()" style="background:yellow;border: 2px solid;width:80px;height: 40px;">Search</button></div>
		</div>
    <?php
	}
	?>
	
	<script type="text/javascript">
	function LoadCity() {
		
		var row_number = 1;
		
		
		while (document.getElementById('row_'.concat(row_number.toString())) !== null){
			
			var this_row_data = document.getElementById('row_'.concat(row_number.toString())); 
			
			var city_search_word = document.getElementById('input_city').value; 
			var province_search_word = document.getElementById('input_province').value; 
			var postal_search_word = document.getElementById('input_postal').value; 
			
			
			//alert(this_row_data.cells[2].innerHTML);
			//alert(city_search_word);
			//alert(this_row_data.cells[3].innerHTML);
			//alert(province_search_word);
			//alert(this_row_data.cells[5].innerHTML);
			//alert(postal_search_word);
			if  ((city_search_word == "") && (province_search_word == "") && (postal_search_word == "")) {
				
				this_row_data.style.display = "table-row";
			}
			else if  ((city_search_word == "") && (province_search_word == "")) {
		
				if (this_row_data.cells[5].innerHTML.toLowerCase().includes(postal_search_word.toLowerCase())) {
					this_row_data.style.display = "table-row";
				}
				else {
					this_row_data.style.display = "none";
				}
			}
			else if  ((city_search_word == "") && (postal_search_word == "")) {
		
				if (this_row_data.cells[3].innerHTML.toLowerCase().includes(province_search_word.toLowerCase())) {
					this_row_data.style.display = "table-row";
				}
				else {
					this_row_data.style.display = "none";
				}
			}
			else if  ((province_search_word == "") && (postal_search_word == "")) {
	
				if (this_row_data.cells[2].innerHTML.toLowerCase().includes(city_search_word.toLowerCase())) {
					this_row_data.style.display = "table-row";
				}
				else {
					this_row_data.style.display = "none";
				}
			}
			else if  (city_search_word == "") {
				
				if ((this_row_data.cells[3].innerHTML.toLowerCase().includes(province_search_word.toLowerCase())) && (this_row_data.cells[5].innerHTML.toLowerCase().includes(postal_search_word.toLowerCase()))) {
					this_row_data.style.display = "table-row";
				}
				else {
					this_row_data.style.display = "none";
				}
			}
			else if  (province_search_word == "") {

				if ((this_row_data.cells[2].innerHTML.toLowerCase().includes(city_search_word.toLowerCase())) && (this_row_data.cells[5].innerHTML.toLowerCase().includes(postal_search_word.toLowerCase()))) {
					this_row_data.style.display = "table-row";
				}
				else {
					this_row_data.style.display = "none";
				}
			}
			else if  (postal_search_word == "") {

				if ((this_row_data.cells[2].innerHTML.toLowerCase().includes(city_search_word.toLowerCase())) && (this_row_data.cells[3].innerHTML.toLowerCase().includes(province_search_word.toLowerCase()))) {
					this_row_data.style.display = "table-row";
				}
				else {
					this_row_data.style.display = "none";
				}
			}
			else if ((this_row_data.cells[2].innerHTML.toLowerCase().includes(city_search_word.toLowerCase())) && (this_row_data.cells[3].innerHTML.toLowerCase().includes(province_search_word.toLowerCase())) && (this_row_data.cells[5].innerHTML.toLowerCase().includes(postal_search_word.toLowerCase()))) {

				this_row_data.style.display = "table-row";
			}
			else{

				this_row_data.style.display = "none";
			}
			
			row_number = row_number + 1;
		}
		
	}	

	</script>
	
	<script type="text/javascript">
	function LoadProvince() {
		
		var row_number = 1;
		
		
		while (document.getElementById('row_'.concat(row_number.toString())) !== null){
			
			var this_row_data = document.getElementById('row_'.concat(row_number.toString())); 
			
			var city_search_word = document.getElementById('input_city').value; 
			var province_search_word = document.getElementById('input_province').value; 
			var postal_search_word = document.getElementById('input_postal').value; 
			
			
			if (this_row_data.cells[2].innerHTML.includes(city_search_word)) {
				this_row_data.style.display = "table-row";
			}
			else if (this_row_data.cells[3].innerHTML.includes(province_search_word)) {
				this_row_data.style.display = "table-row";
			}
			
			if (this_row_data.cells[4].innerHTML.includes(postal_search_word)) {
				this_row_data.style.display = "table-row";
			}
			else{
				this_row_data.style.display = "none";
			}
			
			row_number = row_number + 1;
		}
		
	}	

	</script>
	<script type="text/javascript">
	function LoadPostal() {
		
		var row_number = 1;
		
		
		while (document.getElementById('row_'.concat(row_number.toString())) !== null){
			
			var this_row_data = document.getElementById('row_'.concat(row_number.toString())); 
			
			var city_search_word = document.getElementById('input_city').value; 
			var province_search_word = document.getElementById('input_province').value; 
			var postal_search_word = document.getElementById('input_postal').value; 
			
			if (this_row_data.cells[2].innerHTML.includes(city_search_word)) {
				this_row_data.style.display = "table-row";
			}
			else if (this_row_data.cells[3].innerHTML.includes(province_search_word)) {
				this_row_data.style.display = "table-row";
			}
			
			if (this_row_data.cells[4].innerHTML.includes(postal_search_word)) {
				this_row_data.style.display = "table-row";
			}
			else{
				this_row_data.style.display = "none";
			}
			
			row_number = row_number + 1;
		}
		
	}	

	</script>
	
	<?php
	$form_id = 1;  // live server
	// $form_id = 2;  // test server

	$upload_path = GFFormsModel::get_upload_path( $form_id );
	$upload_url = GFFormsModel::get_upload_url( $form_id );
    
	$exact_upload_path = $upload_path.'/'.date("Y").'/'.date("m")."/";
	//var_dump($exact_upload_path);
	$open_time = 0;
	//var_dump($upload_url.'/'.date("Y").'/'.date("m")."/");
  
	//var_dump(is_dir($exact_upload_path));
	// Open a directory, and read its contents
	if (is_dir($exact_upload_path)){
		
		if ($dh = opendir($exact_upload_path)){
		while (($file = readdir($dh)) !== false){
			
				//var_dump($file);
				$ext = pathinfo($file, PATHINFO_EXTENSION);
				
				
				//var_dump($ext);
				if ($ext == 'csv') {

					$csvfile = fopen($exact_upload_path."/".$file, 'r');
					
					$csv_headers=array("﻿sitename","address","city","province","country","postal","website","lastname","firstname","email","phone"); 
				    if(isMobileDevice()){}
					else{
					$open_time = $open_time + 1;
					if ($open_time > 1){exit;}
					?>				
					<table id="<?php echo 'table_'.$open_time; ?>">
					<tr style="border: 3px solid;"><td>Sitename</td><td>Address</td><td>City</td><td>Province</td><td>Country</td><td>Postal</td><td>Website</td><td>Lastname</td><td>Firstname</td><td>Email</td><td>Phone</td></tr>
					<?php 
					}
					$ii = 0;
					
					$row_pointer = 0;
					while (($line = fgetcsv($csvfile)) !== FALSE) {
						
						if ($ii == 0){$ii = 1; continue;}
						else {
							
						$row_pointer = $row_pointer + 1;
						//$line is an array of the csv elements
						//var_dump($line);
						$csv_headers=array("﻿sitename","address","city","province","country","postal","website","lastname","firstname","email","phone"); 
						if(isMobileDevice()){
						
						?>
						<!--<div class="card" id="<?php echo "row_".$row_pointer;?>"> <ul class="list-group list-group-flush">
						<div class="card-header">Data Info</div>-->
						<div class="grid-x" style="background-color:beige;">
							<div class="cell">Data Info</div>
							
						</div>
						<?php
						}
						else{
							?>
							<tr id="<?php echo "row_".$row_pointer;?>" style="border: 3px solid;">
							<?php 
						}
						
						$ii = 1;
						foreach ($line as $line_el){
                            if (in_array($line_el, $csv_headers)){}
							else {
								if(isMobileDevice()){
							?>
							<!--<li class="list-group-item">-->
							<div class="grid-x" style="background-color: aliceblue;">
							 <?php echo $csv_headers[$ii-1].":"."&nbsp;".$line_el; ?></div>
							</div>
							<?php
								
							//echo($csv_headers[$ii-1].":"."&nbsp;".$line_el);
							$ii = $ii + 1;
								}
								else{
									?>
									<td><?php echo $line_el;?></td>
							<?php
								}
							?>
							</li>
							<?php
							}
						}
						if(isMobileDevice()){
						?>
						<!--</div>-->
						<br />
				
						<?php
						}
						else {
						?>
						</tr>
						<?php
						}
						}
					}
					fclose($csvfile);
					if(isMobileDevice()){}
					else{
					?>
					</table>
					<?php 
					}
				}
			}
		closedir($dh);
		}
	}
	

  
}
add_shortcode( 'csv_data', 'csv_data_function' );

add_action( 'gform_after_submission_2', 'remove_form_entry' );
function remove_form_entry( $entry ) {
	global $wpdb;
	 $site_id = "21"; // live server
	 $form_id = "1";   // live server
	 //$site_id = "16";  // local server
	 //$form_id = "2";   // local server
	
    $query_get_entries = "SELECT id FROM wp_".$site_id."_rg_lead WHERE form_id = ".$form_id;
	$get_entries = $wpdb->get_results($query_get_entries);
	array_pop($get_entries);
	foreach ($get_entries as $get_per_entry){
		$delete_previous_entries = "DELETE FROM wp_".$site_id."_rg_lead WHERE id=".$get_per_entry->id;
		$get_last_entry = $wpdb->get_results($delete_previous_entries);
	}
}

