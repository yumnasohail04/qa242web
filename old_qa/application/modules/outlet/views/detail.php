<div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-12">
        <table class="table table-striped table-condensed" >
            <tbody><tr>
                <td>Name:</td>
                <td><?php if($outlet['name']){echo $outlet['name'];}else {echo 'NIL';}?></td>
            </tr>
            <tr>
                <td>Url:</td>
                <td><?php if($outlet['url']){echo $outlet['url'];}else {echo 'NIL';}?></td>
            </tr>
            <tr>
                <td>Phone:</td>
                <td><?php if($outlet['phone']){echo $outlet['phone'];}else {echo 'NIL';}?></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?php if($outlet['email']){echo $outlet['email'];}else {echo 'NIL';}?></td>
            </tr>
            <tr>
                <td>Country:</td>
                <td><?php if($outlet['country']){echo $outlet['country'];}else {echo 'NIL';}?></td>
            </tr>
            <tr>
                <td>City:</td>
                <td><?php if($outlet['city']){echo $outlet['city'];}else {echo 'NIL';}?></td>
            </tr>
            <tr>
                <td>State:</td>
                <td><?php if($outlet['state']){echo $outlet['state'];}else {echo 'NIL';}?></td>
            </tr>
            <tr>
                <td>Post Code:</td>
                <td><?php if($outlet['post_code']){echo $outlet['post_code'];}else {echo 'NIL';}?></td>
            </tr>
            <tr>
                <td>Address:</td>
                <td><?php if($outlet['address']){echo $outlet['address'];}else {echo 'NIL';}?></td>
            </tr>
            <tr>
                <td>Allowed Bookings of Small Pakages:</td>
                <td><?php if($outlet['allow_small']){echo $outlet['allow_small'];}else {echo 'NIL';}?></td>
            </tr>
            <tr>
                <td>Allowed Bookings of Big Pakages:</td>
                <td><?php if($outlet['allow_large']){echo $outlet['allow_large'];}else {echo 'NIL';}?></td>
            </tr>
            <tr>
                <td>Fax:</td>
                <td><?php if($outlet['fax']){echo $outlet['fax'];}else {echo 'NIL';}?></td>
            </tr>
            <tr>
                <td>Logo:</td>
                <td>
                <?php
                $item_img = base_url() . "static/admin/theme1/images/no_item_image_small.jpg";
                if (!empty($outlet['image']) && file_exists(FCPATH . SMALL_OUTLET_IMAGE_PATH . $outlet['image']))
                    $item_img = IMAGE_BASE_URL . 'outlet/small_images/' . $outlet['image'];
                ?>
                <img src="<?= $item_img ?>"/>
                </td>
            </tr>
            <tr>
                <td>Google Map:</td>
                <td ><?php if($outlet['google_map']){echo $outlet['google_map'];}else {echo 'NIL';}?></td>
            </tr>
            <tr>
                <td>Company Deal:</td>
                <td><?php if($outlet['is_deal_company'] == 1){echo 'Yes';}else {echo 'No';}?></td>
            </tr>
            <tr>
                <td>Bank Details:</td>
                <td><?php if($outlet['bank_details']){echo $outlet['bank_details'];}else {echo 'NIL';}?></td>
            </tr>
            <tr>
                <td>About Us:</td>
                <td><?php if($outlet['about_us']){echo $outlet['about_us'];}else {echo 'NIL';}?></td>
            </tr>
            <tr>
                <td>Working Hours:</td>
                <td><?php if($outlet['working_hours']){echo $outlet['working_hours'];}else {echo 'NIL';}?></td>
            </tr>
        </tbody></table>
    </div>
</div>