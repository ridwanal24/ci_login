              <!-- Begin Page Content -->
              <div class="container-fluid">

              	<!-- Page Heading -->
              	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

              	<div class="row">
              		<div class="col-lg-6">
              			<?= $this->session->flashdata('message'); ?>
                    <h5>Rule : <?= $rule['rule']; ?></h5>
              			<table class="table table-hover">
              				<thead>
              					<tr>
              						<th scope="col">No</th>
              						<th scope="col">Menu</th>
              						<th scope="col">Access</th>
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
              								<div class="form-check">
                                <input class="form-check-input" type="checkbox" <?= check_access($rule['id'],$m['id']); ?> data-rule="<?= $rule['id']; ?>" data-menu="<?= $m['id']; ?>">
                              </div>
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
            <div class="modal fade" id="addRuleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
             <div class="modal-dialog" role="document">
               <div class="modal-content">
                 <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLabel">Add New Rule</h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                   </button>
                 </div>
                 <form action="<?= base_url('admin/addrule'); ?>" method="post">
                  <div class="modal-body">
                    <div class="form-group">
                      <input type="text" class="form-control" id="rule" name="rule" placeholder="Rule Name">
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