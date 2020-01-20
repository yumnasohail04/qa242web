<div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-12">
        <table class="table table-striped table-condensed">
        <tbody>
            <tr>
                <td>Title:</td>
                <td><?php if($detail['page_title']){echo $detail['page_title'];}else {echo 'NIL';}?></td>
            </tr>
            <tr>
                <td>Meta Keywords:</td>
                <td><?php if($detail['meta_keywords']){echo $detail['meta_keywords'];}else {echo 'NIL';}?></td>
            </tr>
            <tr>
                <td>Meta Description:</td>
                <td><?php if($detail['meta_description']){echo $detail['meta_description'];}else {echo 'NIL';}?></td>
            </tr>
            <tr>
                <td>URL Slug:</td>
                <td><?php if($detail['url_slug']){echo $detail['url_slug'];}else {echo 'NIL';}?></td>
            </tr>
            <tr>
                <td>Rank:</td>
                <td><?php if($detail['page_rank']){echo $detail['page_rank'];}else {echo 'NIL';}?></td>
            </tr>
            <tr>
                <td>Page Contents:</td>
                <td style="max-width:100%"><?php if($detail['page_content']){echo $detail['page_content'];}else {echo 'NIL';}?></td>
            </tr>
        </tbody>
        </table>
    </div>
</div>