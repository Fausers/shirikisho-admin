<div class="table-responsive dt-responsive">
    <table id="tableId" class="table table-striped table-bordered nowrap">
        <thead>
            <tr>
                <th>N/S</th>
                <th>Name</th>
                <th>Region</th>
                <th>District</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $n = 1;
            foreach ($data as $docu) {

                $regionName = $ServicesModel->getRegionRow($docu->region_id);
                $districtName = $ServicesModel->getDistrictRow($docu->district_id);
            ?>
                <tr>

                    <td><?= $n ?></td>
                    <td><?= $docu->name ?></td>
                    <td><?= $regionName->name ?></td>
                    <td><?= $districtName->name ?></td>
                    <td>
                        <div class="" role="group" aria-label="Basic outlined example">

                            <button type="button" title="Edit Action" onclick="editAssociation('<?= $docu->id ?>')" class="btn btn-info btn-round btn-mini">
                                Edit</button>
                            <button type="button" title="Delete Action" onclick="viewAssociation('<?= $docu->id ?>')" class="btn btn-success btn-round btn-mini">
                                View More</button>
                            <button type="button" title="Delete Action" onclick="deleteAssociation('<?= $docu->id ?>')" class="btn btn-round btn-mini" style="background-color: orange;color:white">
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