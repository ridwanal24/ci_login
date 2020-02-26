              <!-- Begin Page Content -->
              <div class="container-fluidid">

              	<!-- Page Heading -->
              	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

              	<div class="row">
              		<div class="col-lg">
              			<a class="btn btn-primary mb-3" href="#" data-toggle="modal" data-target="#addSubMenuModal">Add New Sub Menu</a>
              			<?= form_error('title', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
              			<?= form_error('menu_id', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
              			<?= form_error('url', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
              			<?= form_error('icon', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
              			<?= $this->session->flashdata('message'); ?>
              			<table class="table table-hover">
              				<thead>
              					<tr>
              						<th scope="col">No</th>
              						<th scope="col">Title</th>
              						<th scope="col">Menu</th>
              						<th scope="col">Url</th>
              						<th scope="col">Icon</th>
              						<th scope="col"></th>
              						<th scope="col">Active</th>
              						<th scope="col">Action</th>
              					</tr>
              				</thead>
              				<tbody>
              					<?php $i = 1; ?>
              					<?php foreach ($submenu as $sm) : ?>
              						<?php $id = $sm['id']; ?>
              						<tr>
              							<th scope="row"><?= $i; ?></th>
              							<td><?= $sm['title']; ?></td>
              							<td><?= $sm['menu']; ?></td>
              							<td><?= $sm['url']; ?></td>
              							<td><i class="<?= $sm['icon'] ?>"></i></td>
              							<td><?= $sm['icon']; ?></td>
              							<td><?= $sm['is_active']; ?></td>
              							<td>
              								<a class="badge badge-success" href="#">Edit</a>

              								<a class="badge badge-danger" href="<?= base_url('menu/delete/') . $id; ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
              							</td>
              						</tr>
              						<?php $i++; ?>
              					<?php endforeach; ?>
              				</tbody>
              			</table>

              		</div>
              	</div>

              </div>
              <!-- /.container-fluid -->

          </div>
          <!-- End of Main Content -->

          <!-- Add New Menu Modal -->
          <div class="modal fade" id="addSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          	<div class="modal-dialog" role="document">
          		<div class="modal-content">
          			<div class="modal-header">
          				<h5 class="modal-title" id="exampleModalLabel">Add New Sub Menu</h5>
          				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          					<span aria-hidden="true">&times;</span>
          				</button>
          			</div>
          			<form action="<?= base_url('menu/submenu'); ?>" method="post">
          				<div class="modal-body">
          					<div class="form-group">
          						<input type="text" class="form-control" id="title" name="title" placeholder="Sub Menu Title">
          					</div>
          					<div class="form-group">
          						<select name="menu_id" id="menu_id" class="form-control">
          							<option value="">Select Menu</option>
          							<?php foreach ($menu as $m) :?>
          								<option value="<?= $m['id']; ?>"><?= ucfirst($m['menu']); ?></option>
          							<?php endforeach;?>
          						</select>
          					</div>	
          					<div class="form-group">
          						<input type="text" class="form-control" id="url" name="url" placeholder="Sub Menu Url">
          					</div>
          					<div class="form-group">
          						<input type="text" class="form-control" id="icon" name="icon" placeholder="Sub Menu Icon">
          					</div>
          					<div class="form-group">
          						<div class="form-check">
          							<input type="checkbox" class="form-check-input" id="is_active" value="1" name="is_active" checked>
          							<label for="is_active" class="form-check-label">Is Active</label>
          						</div>
          					</div>
          				</div>
          				<div class="modal-footer">
          					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          					<button type="submit" class="btn btn-primary">Add</button>
          				</div>
          			</form>
          		</div>
          	</div>
          </div>
              <!-- End of Add New Menu Modal -->