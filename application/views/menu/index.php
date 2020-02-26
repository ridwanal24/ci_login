              <!-- Begin Page Content -->
              <div class="container-fluid">

              	<!-- Page Heading -->
              	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

              	<div class="row">
              		<div class="col-lg-6">
              			<a class="btn btn-primary mb-3" href="#" data-toggle="modal" data-target="#addMenuModal">Add New Menu</a>
              			<?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
              			<?= $this->session->flashdata('message'); ?>
              			<table class="table table-hover">
              				<thead>
              					<tr>
              						<th scope="col">No</th>
              						<th scope="col">Menu</th>
              						<th scope="col">Action</th>
              					</tr>
              				</thead>
              				<tbody>
              					<?php $i = 1; ?>
              					<?php foreach ($menu as $m) : ?>
              						<?php $id = $m['id']; ?>
              						<tr>
              							<th scope="row"><?= $i; ?></th>
              							<td><?= $m['menu']; ?></td>
              							<td>
              								<a class="badge badge-success" href="#" data-toggle="modal" data-target="#editMenuModal<?= $id; ?>">Edit</a>

              								<!-- Edit Menu Modal -->
              								<div class="modal fade" id="editMenuModal<?= $id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              									<div class="modal-dialog" role="document">
              										<div class="modal-content">
              											<div class="modal-header">
              												<h5 class="modal-title" id="exampleModalLabel">Edit Menu</h5>
              												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              													<span aria-hidden="true">&times;</span>
              												</button>
              											</div>
              											<form action="<?= base_url('menu/edit/') . $id; ?>" method="post">
              												<div class="modal-body">
              													<div class="form-group">
              														<input type="text" class="form-control" id="menu" name="menu" placeholder="Menu Name" value="<?= $m['menu']; ?>">
              													</div>
              												</div>
              												<div class="modal-footer">
              													<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              													<button type="submit" class="btn btn-primary">Edit</button>
              												</div>
              											</form>
              										</div>
              									</div>
              								</div>
              								<!-- End of Edit Menu Modal -->
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
              <div class="modal fade" id="addMenuModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              	<div class="modal-dialog" role="document">
              		<div class="modal-content">
              			<div class="modal-header">
              				<h5 class="modal-title" id="exampleModalLabel">Add New Menu</h5>
              				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              					<span aria-hidden="true">&times;</span>
              				</button>
              			</div>
              			<form action="<?= base_url('menu'); ?>" method="post">
              				<div class="modal-body">
              					<div class="form-group">
              						<input type="text" class="form-control" id="menu" name="menu" placeholder="Menu Name">
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