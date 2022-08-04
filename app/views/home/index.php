<main>
    <div class="wrapper">
        <div class="main-header">
            <form action="<?=BASEURL;?>data/addData" method="POST">
                <label for="tracking_number">Input Tracking Number</label>
                <input type="text" name="tracking_number" id="tracking_number">
                <label for="carrier">Select Carrier</label>
                <select name="carrier" id="carrier">
                    <option value="ups">UPS</option>
                    <option value="fedex">FedEx</option>
                    <option value="dhl">DHL</option>
                </select>
                <label for="name">Input Name</label>
                <input type="text" name="name" id="name">
                <button>Add</button>
            </form>
        </div>
        <div class="main-content">
            <table>
                <tr>
                    <th>Title</th>
                    <th>Tracking Number</th>
                    <th>Carrier</th>
                    <th>Status</th>
                    <th>Last Update</th>
                    <th>Last Event</th>
                    <th>Action</th>
                </tr>
                <?php 
                if(isset($data["trackingNumberdata"])) :
                    foreach($data["trackingNumberdata"] as $data) :?>
                <tr>
                    <td><?= $data['title'] ?></td>
                    <td><?= $data['trackingNumber'] ?></td>
                    <td><?= $data['carrier_code'] ?></td>
                    <td><?= $data['status'] ?></td>
                    <td><?= $data['lastupdate'] ?></td>
                    <td><?= $data['lastevent'] ?></td>
                    <td><a href="<?= BASEURL; ?>data/deleteData/<?= $data['id'];?>" class="btn">Delete</a></td>
                </tr>
                <?php 
                    endforeach; 
                endif;
                ?>
            </table>
        </div>
    </div>
</main>