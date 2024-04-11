<div class="table-responsive dt-responsive">
    <table id="tableId" class="table table-striped table-bordered nowrap">
        <thead>
            <tr>
                <th>N/S</th>
                <th>Name</th>
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
                    <td><?= $docu->name ?></td>
                    <td>
                        <div class="" role="group" aria-label="Basic outlined example">

                            <button type="button" title="Edit Action" onclick="editRegion('<?= $docu->id ?>')" class="btn btn-info btn-round btn-mini">
                                Edit</button>

                            <!-- <button type="button" title="Delete Action" onclick="deleteRegion('<?= $docu->id ?>')" class="btn btn-danger btn-round btn-mini">
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