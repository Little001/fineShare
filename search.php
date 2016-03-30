		<?php include 'header.php'; ?>
		<!-- CONTENT -->
        <div class="content">
            <div class="searchUploadComponent">
                <ul>
                    <li id="all"><span class="fa fa-repeat"></span>Vše</li>
                    <li id="video"><span class="fa fa-film"></span>Video</li>
                    <li id="audio"><span class="fa fa-music"></span>Audio</li>
                    <li id="images"><span class="fa fa-picture-o"></span>Obrázky</li>
                    <li id="documents"><span class="fa fa-file"></span>Dokumenty</li>
					<li id="virtualImages"><span class="fa fa-floppy-o"></span>Image</li>
                    <li id="archives"><span class="fa fa-file-archive-o"></span>Zabalené</li>
                </ul>
                <div class="searchUpload">
					<div class="search"> 	
						<div class="input-group">
							<input type="text" id="serchInput" class="form-control searchTextBox" placeholder="Zadejte co hledáte...">
							<span class="input-group-btn">
								<button class="myButton" id="searchButton">
									<span class="fa fa-search"></span>
									<div class="buttonLine"></div>
									<div class="buttonTextSearch">Hledat</div>
								</button> 
							</span>
						</div>  	            
					</div>	
					<div class="upload">	
						<button class="myButton" onClick="window.location.href = 'upload.php';">
							<span class="fa fa-upload"></span>
							<div class="buttonLine"></div>
							<div class="buttonText">Nahrát soubor</div>
						</button>  
					</div>	
                </div>
            </div>
            <div class="filter">
				<div class="sortFilter">
					<div class="form-group">
						<select class="form-control" id="sortInput">
							<option value="latest">Nejnovější</option>
							<option value="famous">Nejoblibenější</option>
							<option value="biggest">Největší</option>
							<option value="smallest">Nejmenší</option>
						</select>
					</div>
				</div>
                <div class="contentLine"></div>
            </div>
			<?php 
				 function formatSizeUnits($bytes){
			        if ($bytes >= 1073741824)
			        {
			            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
			        }
			        elseif ($bytes >= 1048576)
			        {
			            $bytes = number_format($bytes / 1048576, 2) . ' MB';
			        }
			        elseif ($bytes >= 1024)
			        {
			            $bytes = number_format($bytes / 1024, 2) . ' KB';
			        }
			        elseif ($bytes > 1)
			        {
			            $bytes = $bytes . ' bytes';
			        }
			        elseif ($bytes == 1)
			        {
			            $bytes = $bytes . ' byte';
			        }
			        else
			        {
			            $bytes = '0 bytes';
			        }
			        return $bytes;
				}
				function Scan($dir) {
				    $tree = glob(rtrim($dir, '/') . '/Simp.jpg');
				    if (is_array($tree)) {
				        foreach($tree as $file) {
				            echo $file . formatSizeUnits(filesize($file)). '<br/>';
				        }
				    }
				}
				Scan('uploads');	
				
			?>
	
			
            <ul class="list">
				<?php
					$search_text = (isset($_GET['search']) ? "'%" . $_GET['search'] . "%'" : '');	
					$category = (isset($_GET['category']) ? $_GET['category'] : '');	
					$sort = (isset($_GET['sort']) ? $_GET['sort'] : '');	

					switch($sort){
						case "latest": $sql_sort = 'Order by date DESC';
							break;
						case "famous": $sql_sort = 'Order by likes';
							break;
						case "biggest": $sql_sort = 'Order by size DESC';
							break;
						case "smallest": $sql_sort = 'Order by size';
							break;  
						default: $sql_sort = "latest";
					}
						
					switch($category){
						case "audio": $category = 'audio';
							break;
						case "video": $category = 'video';
							break;
						case "images": $category = 'images';
							break;
						case "archives": $category = 'archives';
							break;
						case "documents": $category = 'documents';
							break;
						case "virtualImages": $category = 'virtualImages';
							break;
					}

					if($category == ''){
						if($search_text == ''){
							$sql = "SELECT * FROM archives UNION SELECT * FROM audio UNION SELECT * FROM documents UNION SELECT * FROM images UNION SELECT * FROM video UNION SELECT * FROM virtualImages " . $sql_sort;	
						}
						else{
							$sql = "SELECT * FROM archives WHERE name LIKE ". $search_text ." UNION SELECT * FROM audio WHERE name LIKE ". $search_text ." 
							UNION SELECT * FROM documents WHERE name LIKE ". $search_text ." UNION SELECT * FROM images WHERE name LIKE ". $search_text ." 
							UNION SELECT * FROM video WHERE name LIKE ". $search_text ." UNION SELECT * FROM virtualImages WHERE name LIKE ". $search_text . " " .$sql_sort;
						}			 
					}
					else{
						if($search_text == ''){
							$sql = "SELECT * FROM " .$category . " " .$sql_sort;
						}
						else{
							$sql = "SELECT * FROM " .$category . " WHERE name LIKE ". $search_text . " " .$sql_sort;	
						}
						
					}
					
					include ('paginate.php'); //include of paginat page
					$show_page=1;
					$per_page = 24;         // number of results to show per page
					$result = $conn->query($sql);
					$total_results = $result->num_rows;
					$total_pages = ceil($total_results / $per_page);//total pages we going to have
					
					//-------------if page is setcheck------------------//
					if (isset($_GET['page'])) {
					    $show_page = $_GET['page'];             //it will telles the current page
					    if ($show_page > 0 && $show_page <= $total_pages) {
					        $start = ($show_page - 1) * $per_page;
					        $end = $start + $per_page;
					    } else {
					        // error - show first set of results
					        $start = 0;              
					        $end = $per_page;
					    }
					} else {
					    // if page isn't set, show first set of results
					    $start = 0;
					    $end = $per_page;
					}
					// display pagination
					
					if (!isset($_GET['page']))
					{
						$page=1; 
					}
					else
					{
						$page = intval($_GET['page']); 
					}
						$tpages=$total_pages;
						
				?>
				
				<?php
                    $reload = $_SERVER['PHP_SELF'] . "?tpages=" . $tpages;
                   
                    // loop through results of database query, displaying them in the table 
                    for ($i = $start; $i < $end; $i++) {
                        // make sure that PHP doesn't try to show results that don't exist
						$row = $result->fetch_assoc();
                        if ($i == $total_results) {
                            break;
                        }
                        $html = "";
						$html .= "<li class='col-xs-12 col-sm-6 col-sm-offset-0 col-md-3 col-md-offset-0 col-lg-2 col-lg-offset-0'>";
						$html .= "	<ul class='item'>";
						$html .="		<div data-toggle='modal' data-target='#myModal' data-id_file='" .$row["ID"]. "' data-category_file='" .$row["category"]. "' data-name_file='" .$row["name"]. "' data-size_file='" .formatSizeUnits($row["size"])."'>";
						$html .= "			<li><img src='Images/image.png' class='img-rounded img-responsive'></li>";
						$html .= "			<li><p>".$row["name"]."</p></li>";
						$html .= "			<li>";
						$html .= "				<div class='like'>" .$row["likes"]. "</div>";
						$html .= "				<div class='visited'><span class='fa fa-film'></span>" .formatSizeUnits($row["size"]). "</div>";
						$html .= "			</li>";
						$html .= "		</div>";
						$html .= "	</ul>";
						$html .= "</li>";	
						echo $html;
                    }       
            // pagination
            ?>
            </ul>
			
			<div class="filter">
                <?php 
				 if ($total_pages > 1) {
                        echo paginate($reload, $show_page, $total_pages);
                }	
				?>
				<div class="buttonUpScroll">
					<span>Nahoru</span>
					<button class="buttonUpScroll"><span class="fa fa-arrow-up"></span></button>
				</div>
            </div>
        </div>
		
<!-- Modal window for download -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel"></h2>
		<br>
		<h4 class="modal-size"></h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
		<form action="download.php" method="post">
			<input type="hidden" name="category" value="" id="category_file"/>
			<input type="hidden" name="id" value="" id="id_file"/>
			<input type="submit" value="Download" name="download" id="downloadClick"/>
		</form>    
      </div>
    </div>
  </div>
</div>
<!-- FOOTER -->
<?php include 'footer.php'; ?>