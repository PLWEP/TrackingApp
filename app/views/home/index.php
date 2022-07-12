<main>
    <div class="wrapper">
        <div class="main-header">
            <form action="<?=BASEURL;?>/data/addData" method="POST">
                <label for="iresi">Input Tracking Number</label>
                <input type="text" name="iresi" id="iresi" minlength="10" maxlength="10">
                <label for="name">Input Name</label>
                <input type="text" name="name" id="name">
                <button>Add</button>
            </form>
        </div>
        <div class="main-content">
            <table>
                <tr>
                    <th>Name</th>
                    <th>Tracking Number</th>
                    <th>Service</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Description</th>
                    <th>Timestamp</th>
                    <th>Action</th>
                </tr>
                <?php 
                if(isset($data["trackingNumberdata"])) :
                    foreach($data["trackingNumberdata"] as $data) :?>
                <tr>
                    <td><?= $data['name'] ?></td>
                    <td><?= $data['trackingNumber'] ?></td>
                    <td><?= $data['service'] ?></td>
                    <td><?= $data['address'] ?></td>
                    <td><?= $data['status'] ?></td>
                    <td><?= $data['description'] ?></td>
                    <td><?= $data['timestamp'] ?></td>
                    <td><a href="<?= BASEURL; ?>/data/deleteData/<?= $data['trackingNumber'];?>" class="btn">Delete</a></td>
                </tr>
                <?php 
                    endforeach; 
                endif;
                ?>
            </table>
        </div>
    </div>
</main>