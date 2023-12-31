<?php
// *************************************************************************
//  This file is part of MostActive sourcemod plugin.
//
//  Copyright (C) 2017 MostActive Dev Team 
//  https://github.com/Franc1sco/MostActive/graphs/contributors
//
//  This program is free software: you can redistribute it and/or modify
//  it under the terms of the GNU General Public License as published by
//  the Free Software Foundation, per version 3 of the License.
//
//  This program is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//  GNU General Public License for more details.
//
//  You should have received a copy of the GNU General Public License
//  along with this program. If not, see <http://www.gnu.org/licenses/>.
//
//  This file is based off work(s) covered by the following copyright(s):
//
//   Stamm 2.28 Final
//   Copyright (C) 2012-2014 David <popoklopsi> Ordnung
//   Licensed under GNU GPL version 3, or later.
//   Page: https://github.com/popoklopsi/Stamm-Webinterface &
//         https://forums.alliedmods.net/showthread.php?p=1338942
//
// *************************************************************************

include_once("inc/config.php");

include_once("inc/function.php");

include_once("inc/SteamID.php"); //https://github.com/xPaw/SteamID.php
?>

<!DOCTYPE html>
<html data-ng-app="app">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>Time played</title>
		
		<!-- Bootstrap Theme CSS -->
		<?php echo '<link href="'.$stylesheet.'" rel="stylesheet">'; ?>
		
		<!-- Custom Theme CSS -->
		<link href="theme.css" rel="stylesheet">
		
		<!-- FavIcon -->
		<link rel="icon" href="cs2.ico">
		
		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		
		<!-- Bootstrap Core JavaScript -->
		<script src="js/bootstrap.js"></script>
		
		<!-- rowlink JavaScript -->
		<script src="js/rowlink.js"></script>
	</head>
	
	<?php
	if ($background != "")
	{
		echo'<body data-ng-controller="demoController as vm" style="background: url(' .$background. '); background-repeat: no-repeat; background-attachment: fixed; background-size:100%;">';
	}
	else
	{
		echo'<body data-ng-controller="demoController as vm">';
	}
	?>
	
		<!-- NAV BAR -->
		<?php
			include("navbar.php");
		?>
		
		<main class="container">
			<data-uib-accordion data-close-others="true" class="bootstrap-css">
			
			<?php
				if (!extension_loaded('bcmath'))
				{
					if (!dl('bcmath.so'))
					{
						echo '<div class="alert alert-danger" role="alert">Failed to load php extensions <strong>bcmath</strong></div>';
					}
				}
				if (!extension_loaded('GMP'))
				{
					echo '<div class="alert alert-danger" role="alert">Failed to load php extensions <strong>GMP</strong></div>';
				}
			?>
				
				<div>
				<?php
					
					// SQL class
					$sql_k4times = new SQL($k4times_dbHost, $k4times_dbUser, $k4times_dbPass, $k4times_dbName);
					
					// Get page and search
					$currentSite = (isset($_GET["page"])) ? $_GET["page"] : 1;
					$searchTyp = (isset($_GET['type'])) ? $_GET['type'] : "";
					$search = (isset($_GET['search'])) ? $_GET['search'] : "";
					
					// Site to int
					if (isset($currentSite)) 
					{
						settype($currentSite, "integer");
					}
					else
					{
						$currentSite = 1;
					}
					
					// Check valid
					if ($currentSite < 1)
					{
						$currentSite = 1;
					}
					
					// Get Config 
					$usersPerPage = $usersPerPage;
					
					// WHERE clause
					$sqlSearch = "WHERE `all` >= $k4times_minSec";
					
					// Search?
					$site = "?";
					
					if (($searchTyp == "name" || $searchTyp == "steam_id") && $search != "")
					{
						// Escape Search
						$search = $sql_k4times->escape($search);
						
						// Append to where clause
						if ($searchTyp == "steam_id")
						{
							try
							{
								$steamid = new SteamID($search);
								
								if( $steamid->GetAccountType() !== SteamID :: TypeIndividual )
								{
									throw new InvalidArgumentException( 'We only support individual SteamIDs.' );
								}
								else if( !$steamid->IsValid() )
								{
									throw new InvalidArgumentException( 'Invalid SteamID.' );
								}
								
								$steamid->SetAccountInstance( SteamID :: DesktopInstance );
								$steamid->SetAccountUniverse( SteamID :: UniversePublic );
							}
							catch( InvalidArgumentException $e )
							{
								echo $e->getMessage();
							}
							
							$steamid3 = $steamid->RenderSteam2().PHP_EOL;
							$steamid3 = preg_replace('/\s+/', '', $steamid3);
							
							$sqlSearch .= " AND `steam_id` LIKE '%" .$steamid3."%'";
						}
						else
						{
							$sqlSearch .= " AND `name` LIKE '%" .$search. "%'";
						}
						// Site
						$site .= "type=$searchTyp&amp;search=$search&amp;";
					}
					
					$nameTable = '<a href="index.php' .$site. 'page=' .$currentSite. '&amp;type=name&amp;sort=desc"><strong>Name</strong></a>';
					$allTable = '<a href="index.php' .$site. 'page=' .$currentSite. '&amp;type=all&amp;sort=desc"><strong>Total</strong></a>';
					$CTTable = '<a href="index.php' .$site. 'page=' .$currentSite. '&amp;type=ct&amp;sort=desc"><strong>CT Time</strong></a>';
					$TTable = '<a href="index.php' .$site. 'page=' .$currentSite. '&amp;type=t&amp;sort=desc"><strong>T Time</strong></a>';
					$SpecTable = '<a href="index.php' .$site. 'page=' .$currentSite. '&amp;type=spec&amp;sort=desc"><strong>Spec Time</strong></a>';
					
					// Sorting
					if (isset($_GET["type"]) && isset($_GET["sort"]))
					{
						if ($_GET["sort"] == "asc")
						{
							$sort = "ASC";
							$op = "desc";
							$sortImg = "<span class='dropup'><span class='caret'></span></span>";
						}
						else
						{
							$sort = "DESC";
							$op = "asc";
							$sortImg = "<span class='caret'></span> ";
						}
						
						if ($_GET["type"] == "name")
						{
							$sqlSearch .= " ORDER by `name`";
							$nameTable = '<a href="index.php' .$site. 'page=' .$currentSite. '&amp;type=name&amp;sort=' .$op. '"><strong>Name</strong></a>' .$sortImg;
							$site .= "type=name&amp;";
						}
						else if ($_GET["type"] == "all")
						{
							$sqlSearch .= " ORDER by `all`";
							$allTable = '<a href="index.php' .$site. 'page=' .$currentSite. '&amp;type=all&amp;sort=' .$op. '"><strong>Total</strong></a>' .$sortImg;
							$site .= "type=all&amp;";
						}
						else if ($_GET["type"] == "ct")
						{
							$sqlSearch .= " ORDER by `ct`";
							$CTTable = '<a href="index.php' .$site. 'page=' .$currentSite. '&amp;type=ct&amp;sort=' .$op. '"><strong>CT Time</strong></a>' .$sortImg;
							$site .= "type=ct&amp;";
						}
						else if ($_GET["type"] == "t")
						{
							$sqlSearch .= " ORDER by `t`";
							$TTable = '<a href="index.php' .$site. 'page=' .$currentSite. '&amp;type=t&amp;sort=' .$op. '"><strong>T Time</strong></a>' .$sortImg;
							$site .= "type=t&amp;";
						}
						else if ($_GET["type"] == "spec")
						{
							$sqlSearch .= " ORDER by `spec`";
							$SpecTable = '<a href="index.php' .$site. 'page=' .$currentSite. '&amp;type=spec&amp;sort=' .$op. '"><strong>Spec Time</strong></a>' .$sortImg;
							$site .= "type=spec&amp;";
						}
						else
						{
							$sqlSearch .= " ORDER by `all`";
							$allTable = '<a href="index.php' .$site. 'page=' .$currentSite. '&amp;type=all&amp;sort=' .$op. '"><strong>Total</strong></a>' .$sortImg;
							$site .= "type=all&amp;";
						}
						
						if ($_GET["sort"] == "asc")
						{
							$site .= "sort=asc&amp;";
						}
						else
						{
							$site .= "sort=desc&amp;";
						}
						
						$sqlSearch .= " " .$sort;
					}
					else
					{
						$sqlSearch .= " ORDER by `all` DESC";
						$allTable = '<a href="index.php' .$site. 'page=' .$currentSite. '&amp;type=all&amp;sort=asc"><strong>Total</strong></a> <span class="caret"></span> ';
					}
					
					// Calculate Entrys
					$allEntrys = $sql_k4times->getRows($sql_k4times->query("SELECT COUNT(`name`) FROM `k4times` $sqlSearch"));
					$allEntrys = (int)$allEntrys[0];
					
					// Pages
					$allPages = $allEntrys / $usersPerPage;
					
					// Check again current site
					if ($currentSite > ceil($allPages))
					{
						$currentSite = 1;
					}
					
					// Calculate first item
					$firstItem = $currentSite * $usersPerPage - $usersPerPage;
				?>
				
				<div class="content">
					<div class="row">
					
					<!-- SEARCH PANEL -->
					
						<div class="col-lg-4">
							<div class="panel panel-default">
								<div class="panel-heading">
									Search
								</div>
								<div class="panel-body">Player<?php 
									
									// Show player count
									if (($allEntrys - $firstItem) < $usersPerPage) 
									{
										$endEntry = $allEntrys;
									}
									else
									{ 
										$endEntry = ($firstItem + $usersPerPage);
									}
									
									// More than one player?
									if ($endEntry - $firstItem != 1)
									{
										echo 's ';
									}
									else
									{
										echo ' ';
									}
									
									if ($allEntrys == "0")
									{
										echo $firstItem;
									}
									else
									{
										echo $firstItem+1;
									}
									
									echo " to ";
									echo $endEntry;
									echo " of ";
									echo $allEntrys;
									
								?>
								<br /> <br />
								<form action="index.php" method="get" class="bs-component">
									<div class="input-group">
										<span class="input-group-btn" style="width: 102px">
											<select class="form-control"  name="type" id="type" value="Name">
												<option value="name">Name</option>
												<option value="steam_id">SteamID</option>
											</select>
										</span>
										<input class="form-control" type="text" name="search" id="search" value="<?php echo $search; ?>"/>
										<span class="input-group-btn">
											<button class="btn btn-default" type="submit" value="Search">Search</button>
										</span>
									</div>
								</form>
								</div>
							</div>
						</div>
					</div>
					<br />
					
					<!-- MAIN TABLE -->
					
					<div class="panel panel-default">
						
						<div class="panel-heading"></div>
						<div class="panel-body">
							<div class="table-responsive"><table class="table table-striped table-hover table-outside-bordered" data-link="row">
								<?php
									// Get entrys
									$result = $sql_k4times->query("SELECT * FROM `k4times` $sqlSearch LIMIT $firstItem, $usersPerPage");
									
									// Have any entrys?
									if ($sql_k4times->foundData($result))
									{
										$index = ($currentSite - 1) * $usersPerPage + 1;
										$cur = 1;
										
										// Table Layout
										echo '
										<thead><th style="width: 2%; padding-left: 3px; ">#</th>
										<th style="width: 20%; padding-left: 3px; ">' .$nameTable. '</th>
										<th style="width: 20%; padding-left: 3px; ">' .$allTable. '</th>
										<th style="width: 20%; padding-left: 3px; ">'. $CTTable. '</th>
										<th style="width: 20%; padding-left: 3px; ">' .$TTable. '</th>
										<th style="width: 16%; padding-left: 3px; ">' .$SpecTable. '</th>
										<th style="width: 2%; "></th></thead>';
										
										// Loop through query
										while ($row = $sql_k4times->getArray($result))
										{
											$name = str_replace("{", "", $row['name']);
											$name = str_replace("}", "", $name);
											$name = str_replace("<", "&lt;", $name);
											$name = str_replace("&", "&amp;", $name);
											$name = substr($name, 0, 22);
											
											$steamid = new SteamID($row['steam_id']);
											$steam3 = $steamid->RenderSteam3().PHP_EOL;
											$steam64 = $steamid->ConvertToUInt64().PHP_EOL;
											$steam3 = preg_replace('/\s+/', '', $steam3);
											$steam64 = preg_replace('/\s+/', '', $steam64);
											
											if(($search == $steam3 || $search == $steam64 || $search == $row['steam_id'] || $search == $name) && $search != "")
											{
												echo '<tr class="success">';
											}
											else
											{
												echo '<tr>';
											}
											
											echo '
											<td>' .$index. '</td>
											<td>';
											
											echo '
											<b><a href="http://steamcommunity.com/profiles/' .$steamid->ConvertToUInt64() . PHP_EOL. '" >' .$name. '</a></b></td>
											
											<td>' .secondsToTime($row['all'], $time_format). '</td>
											<td>' .secondsToTime($row['ct'], $time_format).'</td>
											<td>' .secondsToTime($row['t'], $time_format).'</td>
											<td>' .secondsToTime($row['spec'], $time_format). '</td>
											
											<td><a href="http://steamcommunity.com/profiles/' .$steamid->ConvertToUInt64() . PHP_EOL. '" target="_blank"><img src="./img/steam.png"; style="width:auto; height:25px; padding-right: 4px;padding-top: 4px;"></a></td>
											</tr>';
											
											$index++;
											$cur++;
										}
									}
									else 
									{
										echo '
										<div class="alert alert-danger" role="alert"><strong>Couldn\'t find any Results</strong></div>
										';
									}
								?>
							</table>
							</div>
						</div>
					</div>
					
					<!-- PAGINATION -->
					
					<nav>
						<ul class="pagination">
							<?php 
								
								if ($currentSite == 1)
								{
									$leftLimit = $currentSite - 1;
									$rightLimit = $currentSite + 9;
								}
								else
								
								// To we need to append << and < ?
								if ($currentSite == 2)
								{
									
									$leftLimit = $currentSite - 2;
									$rightLimit = $currentSite + 8;
								}
								else
								if ($currentSite == 3)
								{
									
									$leftLimit = $currentSite - 3;
									$rightLimit = $currentSite + 7;
								}
								else
								if ($currentSite == 4)
								{
									
									$leftLimit = $currentSite - 4;
									$rightLimit = $currentSite + 6;
								}
								else
								if ($currentSite == 5)
								{
									
									$leftLimit = $currentSite - 5;
									$rightLimit = $currentSite + 5;
								}
								else
								if ($currentSite >= 6)
								{
									$leftLimit = $currentSite - 4;
									$rightLimit = $currentSite + 4;
									echo '&nbsp;<li><a href="index.php' .$site. 'page=1">First</a>&nbsp;<a href="index.php' .$site. 'page=' .($currentSite-1). '">Previous</a></li>&nbsp;';
								}
								
								// Only one page?
								if ($allPages <= 1)
								{
									echo '&nbsp;<li class="active"><a>1</a></li>';
								}
								else
								{
									// Loop through all pages
									for ($i=0; $i < $allPages; $i++)
									{
										$current = $i + 1;
										
										// Check if current page
										if ($current == $currentSite)
										{
											echo '&nbsp;<li class="active"><a>' .$current. '</a></li>';
										}
										else
										{
											if (($current > $leftLimit) && ($current < $rightLimit))
											{
												echo '&nbsp;<li><a href="index.php' .$site. 'page=' .$current. '">' .$current. '</a></li>';
											}
										}
									}
								}
								
								// To we need to append >> and < ?
								if ($currentSite < ($allPages - 10))
								{
									echo '&nbsp;<li><a href="index.php' .$site. 'page=' .($currentSite+1). '">Next</a>&nbsp;<a href="index.php' .$site. 'page=' .ceil($allPages). '">Last</a></li>';
								}
								
							?>
							
						</ul>
					</nav>
					
					<!-- FOOTER -->
					<?php
						include("footer.php");
					?>
					
				</div>
			</data-uib-accordion>
		</main>
	</body>
</html>
