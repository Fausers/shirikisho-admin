<div class="table-responsive dt-responsive">
    <table id="tableId" class="table table-striped table-bordered nowrap">
        <thead>
            <tr>
                <th>N/S</th>
                <th>Name</th>
                <th>Region</th>
                <th>District</th>
                <th>Ward</th>
                <th>C.No</th>
                <th>Mx.No</th>
                <th>R.No</th>
                <th>Vehicle Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $n = 1;
            foreach ($data as $docu) {

                $regionName = $ServicesModel->getRegionRow($docu->region_id);
                $districtName = $ServicesModel->getDistrictRow($docu->district_id);
                $wardName = $ServicesModel->getWardRow($docu->ward_id);
            ?>
                <tr>

                    <td><?= $n ?></td>
                    <td><?= $docu->park_name ?></td>
                    <td><?= $regionName->name ?></td>
                    <td><?= $districtName->name ?></td>
                    <td><?= $wardName->name ?></td>
                    <td>0</td>
                    <td><?= $docu->number_of_members ?></td>
                    <td><?= $docu->number_of_members ?></td>
                    <td><?= $docu->vehicle_type ?></td>
                    <td>
                        <div class="" role="group" aria-label="Basic outlined example">

                            <button type="button" title="Edit Action" onclick="editParking('<?= $docu->id ?>')" class="btn btn-info btn-round btn-mini">
                                Edit</button>
                            <button type="button" title="Delete Action" onclick="viewParking('<?= $docu->id ?>')" class="btn btn-success btn-round btn-mini">
                                View More</button>
                            <button type="button" title="Delete Action" onclick="deleteParking('<?= $docu->id ?>')" class="btn btn-danger btn-round btn-mini" style="background-color: orange;">
                                Delete</button>

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