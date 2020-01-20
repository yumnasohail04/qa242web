<?php ?>

<div class="col-sm-6 col-lg-3">
    <div class="card text-white white_bg">
        <div class="card-body pb-0">
            <h4 class="mb-0">
                Unsigned
            </h4>
            <div class="row sub_row">
                <div class="col-lg-12 cards" style="color:#929292">
                    <h4 class="mb">
                        <span style="color:#E8BC68;" class="count"><?php $temp='0'; if(isset($overduechecks) && !empty($overduechecks)) $temp=$overduechecks; $temp=  Modules::run('api/string_length',$temp,'100','0'); echo $temp; ?></span>
                    </h4>
                    <span class="font-head">Forms</span>
                    <i style="color:#E8BC68;" class=" fa fa-folder fa_icons"></i>
                </div>
            </div>
        </div>
    </div>
</div>
