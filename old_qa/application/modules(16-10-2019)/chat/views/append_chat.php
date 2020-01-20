      <?php $lastid = $lastcheater; ?>
      <div>
        <datamain>
          <?php if(isset($chat_detail) && !empty($chat_detail)) {
            $chat_detail = array_reverse($chat_detail);
            $previous_images = array();
            foreach ($chat_detail as $key => $cd):
              if(isset($cd['chat_id']) && !empty($cd['chat_id']))
                if($lastid > $cd['chat_id'])
                  $lastid = $cd['chat_id'];
              if($cd['message_from'] == $this->session->userdata['user_data']['user_id']) {
                $class = 'replies';
                $key = array_search($this->session->userdata['user_data']['user_id'], array_column($previous_images, 'user_id'));
                if (!is_numeric($key)){
                  $user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id" =>$this->session->userdata['user_data']['user_id']),'id desc','users','user_image','1','1')->result_array();
                  $image =''; if(isset($user_detail[0]['user_image']) && !empty($user_detail[0]['user_image'])) $image=$user_detail[0]['user_image']; $image=  Modules::run('api/string_length',$image,'8000','');
                  $temp['user_id'] = $this->session->userdata['user_data']['user_id'];
                  $temp['image'] = $image;
                  unset($temp);
                }
                else {
                  $image = $previous_images[$key]['image'];
                }
              } 
              else {
                $class = 'sent';
                $key = array_search($cd['message_to'], array_column($previous_images, 'user_id'));
                if (!is_numeric($key)){
                  $user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id" =>$cd['message_to']),'id desc','users','user_image','1','1')->result_array();
                  $image =''; if(isset($user_detail[0]['user_image']) && !empty($user_detail[0]['user_image'])) $image=$user_detail[0]['user_image']; $image=  Modules::run('api/string_length',$image,'8000','');
                  $temp['user_id'] = $cd['message_to'];
                  $temp['image'] = $image;
                  unset($temp);
                }
                else {
                  $image = $previous_images[$key]['image'];
                }
              }
              $user_image = Modules::run('api/image_path_with_default',ACTUAL_OUTLET_USER_IMAGE_PATH,$image,STATIC_FRONT_IMAGE,'user.png');
              ?>
            <li class="<?=$class?>">
              <img src="<?=$user_image?>" alt="">
              <p><?=$cd['message']?></p>
            </li>
          <?php endforeach;
          } ?>
        </datamain> 
        <page_number><?php if(!isset($page_number) || !is_numeric($page_number) || empty($page_number)) $page_number = 0; if(isset($chat_detail) && !empty($chat_detail)) $page_number = $page_number+1; echo $page_number; ?></page_number><totalpage><?php if(isset($total_pages) && is_numeric($total_pages)) echo $total_pages; else echo "0"; ?></totalpage><lastcheater><?php if(isset($lastid) && is_numeric($lastid)) echo $lastid; else echo "0"; ?></lastcheater>
    </div>