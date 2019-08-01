<div class="col-xs-12 col-sm-3 col-md-3"><!--=======================left panel starts===============================================-->
<div class="col-xs-12 col-sm-12 col-md-12 both_p">
<h4 class="bg_head"><?=$this->lang->line('text_products') ?></h4>
    	<?php
        $url_slug = $this->uri->segment(1);
		$counter = 1;
		foreach($left_panel_cats->result() as $row){
			$arr_sub_cats = Modules::run('catagories/_get_sub_cats_by_id', $row->id);
			$arr_sub_cats_items = Modules::run('items/_get_item_from_db_by_cat_id', $row->id,1);
			if($arr_sub_cats_items->num_rows() > 0){
			if($arr_sub_cats->num_rows() > 0)
			{
				if($url_slug == 'subcategory' && isset($id) && !empty($id)){
					$sub_cat_details = Modules::run('catagories/_get_cat_details_by_id', $id);
					$sub_cat_details = $sub_cat_details->row();
					$parent_id = $sub_cat_details->parent_id;
			}
			?>
            <ul class="nav nav-pills nav-stacked">
            <li class="dropdown n_pill <?php if($url_slug == $row->url_slug){echo 'active';}elseif($counter==1 && $url_slug == 'products'){echo 'active';}?>"> 
			<?php //elseif(isset($parent_id) && ($parent_id == $row->id)){echo 'active';} elseif($counter==1 && empty($id) && $url_slug != 'search_products'){echo 'active';}?>
            
                <a href="<?=base_url()?><?=$row->url_slug.'/'.$row->id?>" class="dropdown-toggle pill_font"><?=$row->cat_name;?> <img class="img-responsive pull-right" src="<?php echo base_url(); ?>static/front/theme1/images/arrow_gray.png" alt="arrow_active.png" /> </a>

                <ul class="dropdown-menu l_marg ">
                    <?php
					foreach($arr_sub_cats->result() as $sub_cat){
						$arr_prods = Modules::run('items/_get_products_by_cat_id', $sub_cat->id);
						if($arr_prods->num_rows > 0){
						?>
						<li ><a href="<?=base_url()?><?=$row->url_slug.'/'.$sub_cat->url_slug.'/'.$sub_cat->id?>"><?=$sub_cat->cat_name;?></a></li>
						<li class="divider" style="margin:0;"></li>
						<?php
						}
					}
						?>
                </ul>
            </li>
               </ul>
	    	<?php
			}
			}
			$counter++;
		}
		?>
 </div>
</div><!--=======================left panel ended===============================================-->
