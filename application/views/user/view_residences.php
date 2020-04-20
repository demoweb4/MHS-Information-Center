        <!-- Begin Page Content -->
        <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

        <div class="row">
            <div class="col-lg">
                <?php if (validation_errors()) : ?>
                <div class="alert alert-danger text-center alert-dismissible fade show" role="alert"><?= validation_errors(); ?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>                
                <?php endif; ?>

                <?= $this->session->flashdata('message');?>


                <table class="table table-responsive-lg table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Residence ID</th>
                            <th scope="col">Address</th>
                            <th scope="col">Number Of Unit</th>
                            <th scope="col">Size Per Unit(m2)</th>
                            <th scope="col">Monthly Rental(RM)</th>
                            <th scope="col">Action</th>

                        </tr>
                    </thead>

                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach($residences as $sm) {?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $sm['residence_id']; ?></td>
                            <td><?= $sm['address']; ?></td>
                            <td><?= $sm['numunits']; ?></td>
                            <td><?= $sm['size_per_unit']; ?></td>
                            <td><?= $sm['monthly_rental']; ?></td>
                            <td>
                            <a 
                                href="javascript:;"
                                data-residence_id="<?php echo $sm['residence_id'] ?>"
                                data-staff_id="<?php echo $sm['staff_id'] ?>"
                                data-address="<?php echo $sm['address'] ?>"
                                data-numunits="<?php echo $sm['numunits'] ?>"
                                data-size_per_unit="<?php echo $sm['size_per_unit'] ?>"
                                data-size_per_unit="<?php echo $sm['monthly_rental'] ?>"
                                data-toggle="modal" data-target="#edit-data">
                                <button data-toggle="modal" data-target="#ubah-data" class="badge badge-pill badge-success" >Apply</button>
                        </tr>
                        <?php $i++; ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Modal -->
      <!-- Button trigger modal -->

    <!-- Modal Apply -->
    <?php 
        foreach($residences as $i):
            $residence_id=$i['residence_id'];
            $staff_id=$i['staff_id'];
            $address=$i['address'];
            $numunits=$i['numunits'];
            $size_per_unit=$i['size_per_unit'];
            $monthly_rental=$i['monthly_rental'];
        ?>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="edit-data" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Apply for the Residence</h4>
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            </div>
            <form class="form-horizontal" action="<?php echo base_url('user/applyResidence')?>" method="post" enctype="multipart/form-data" role="form">
            <div class="modal-body">
            <div class="form-group">
                <input type="hidden" id="residence_id" name="residence_id">
                <input type="hidden" id="staff_id" name="staff_id">
                <!-- <input type="month" class="form-control " id="requiredMonth" name="requiredMonth" > -->
                <label for="month">Month: </label><br>
                <select class="form-control" id="requiredMonth" name="requiredMonth">
                <option selected>January</option>
                <option>February</option>
                <option>March</option>
                <option>April</option>
                <option>May</option>
                <option>June</option>
                <option>July</option>
                <option>August</option>
                <option>September</option>
                <option>October</option>
                <option>November</option>
                <option>December</option>
                </select>
            </div>
            <div class="form-group">
                <!-- <input type="text" class="form-control " id="requiredYear" name="requiredYear" placeholder="Required Year"> -->
                <label for="year">Year: </label><br>
                <select class="form-control" 
                id="requiredYear" name="requiredYear">
                    <option selected>2020</option>
                    <option>2021</option>
                    <option>2022</option>
                    <option>2023</option>
                    <option>2024</option>
                    <option>2025</option>
                    <option>2026</option>
                    <option>2027</option>
                    <option>2028</option>
                    <option>2029</option>
                    <option>2030</option>
                    <option>2031</option>
                </select>
            </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info" type="submit"> Save&nbsp;</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal"> Cancel</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>
<!-- END Modal Ubah -->
<script src="<?php echo base_url('assets/js/jquery-3.4.1.min.js');?>"></script>
<script>
    $(document).ready(function() {
        // Untuk sunting
        $('#edit-data').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal          = $(this)
 
            // Isi nilai pada field
            modal.find('#residence_id').attr("value",div.data('residence_id'));
            modal.find('#staff_id').attr("value",div.data('staff_id'));
            modal.find('#address').attr("value",div.data('address'));
            modal.find('#requiredMonth').attr("value",div.data('requiredMonth'));
            modal.find('#requiredYear').attr("value",div.data('requiredYear'));
        });
    });
</script>