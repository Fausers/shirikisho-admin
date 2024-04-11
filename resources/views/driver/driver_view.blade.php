<div class="table-responsive dt-responsive">
    <table id="tableId" class="table table-striped table-bordered nowrap">
        <thead>
            <tr>
                <th>N/S</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Uniform No</th>
                <th>Parking Area</th>
                <th>Residence</th>
                <!-- <th>State</th> -->
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $n = 1;
            foreach ($data as $docu) {
            ?>
                <tr>

                    <td><?= $n ?></td>
                    <td><?= $docu->full_name ?></td>
                    <td><?= $docu->phone_number ?></td>
                    <td></td>
                    <td><?= $docu->parking_id ?></td>
                    <td><?= $docu->residence_address ?></td>
                    <!-- <td><?= $docu->residence_address ?></td> -->
                    <td>
                        <div class="" role="group" aria-label="Basic outlined example">

                            <button type="button" title="Edit Action" onclick="editDriver('<?= $docu->id ?>')" class="btn btn-info btn-round btn-mini">
                                Edit</button>

                                <button type="button" title="Delete Action" onclick="viewDiver('<?= $docu->id ?>')" class="btn btn-success btn-round btn-mini">
                                View More</button>

                            <!-- <button type="button" title="Delete Action" onclick="deleteDriver('<?= $docu->id ?>')" class="btn btn-orange btn-round btn-mini">
                                Delete</button> -->

                        </div>
                    </td>

                </tr>
            <?php $n++;
            } ?>
        </tbody>
    </table>
</div>


<script>
    $(document).ready(function() {
        let table = new DataTable('#tableId');
    });
</script>