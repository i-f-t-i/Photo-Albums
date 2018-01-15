<?php
/*
UserSpice 4
An Open Source PHP User Management System
by the UserSpice Team at http://UserSpice.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php require_once 'init.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'users/includes/header.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'users/includes/navigation.php'; ?>

<?php if (!securePage($_SERVER['PHP_SELF'])){die();} ?>
<?php

  $db = DB::getInstance();

$usersAlbumsQ = $db->query("SELECT user_no,album_name FROM album ORDER BY user_no ASC");
$album_info = $usersAlbumsQ->results(true);

?>
<div id="page-wrapper">

  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
      <div class="col-sm-12">
        
        <!-- Left Column -->
        <div class="class col-sm-3"></div>

        <!-- Main Center Column -->
        <div class="class col-sm-6">
          <!-- Content Goes Here. Class width can be adjusted -->

			<form name='adminPermissions' action='<?=$_SERVER['PHP_SELF']?>' method='post'>
			  <h2>Albums by Users</h2>
			  

			  <br>
			  <table class='table table-hover table-list-search'>
				<tr>
				  <th>Users</th><th>Albums</th>
				</tr>

				<?php
				//List each permission level
				foreach ($album_info as $Data) {
				  ?>
				  <tr>
					<td><?=$Data[user_no]?></a></td>
					<td><?=$Data[album_name]?></a></td>
				  </tr>
				  <?php
				  
				}
				?>

			  </table>


			  
			</form>

          <!-- End of main content section -->
        </div>

        <!-- Right Column -->
        <div class="class col-sm-1"></div>
      </div>
    </div>
	</div>
	</div>

    <!-- /.row -->

    <!-- footers -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

<!-- Place any per-page javascript here -->
<script src="js/search.js" charset="utf-8"></script>

<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>

