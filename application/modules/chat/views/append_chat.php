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
                $class = 'floats-right';
                $key = array_search($this->session->userdata['user_data']['user_id'], array_column($previous_images, 'user_id'));
                if (!is_numeric($key)){
                  $user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id" =>$this->session->userdata['user_data']['user_id']),'id desc','users','user_image','1','1')->result_array();
                  $image =''; if(isset($user_detail[0]['user_image']) && !empty($user_detail[0]['user_image'])) $image=$user_detail[0]['user_image']; $image=  Modules::run('api/string_length',$image,'8000','','');
                  $temp['user_id'] = $this->session->userdata['user_data']['user_id'];
                  $temp['image'] = $image;
                  unset($temp);
                }
                else {
                  $image = $previous_images[$key]['image'];
                }
              } 
              else {
                $class = 'floats-left';
                $key = array_search($cd['message_to'], array_column($previous_images, 'user_id'));
                if (!is_numeric($key)){
                  $user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id" =>$cd['message_to']),'id desc','users','user_image','1','1')->result_array();
                  $image =''; if(isset($user_detail[0]['user_image']) && !empty($user_detail[0]['user_image'])) $image=$user_detail[0]['user_image']; $image=  Modules::run('api/string_length',$image,'8000','','');
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
        					<div class="card d-inline-block mb-3 <?=$class?> mr-2">
                                <div class="card-body">
                                    <div class="d-flex flex-row pb-2">
                                        <a class="d-flex" >
                                            <img alt="Profile Picture" src="<?=$user_image?>"
                                                class="img-thumbnail border-0 rounded-circle mr-3 list-thumbnail align-self-center xsmall">
                                        </a>
                                        <div class="d-flex flex-grow-1 min-width-zero">
                                            <div
                                                class="m-2 pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                                                
                                            </div>
                                        </div>

                                    </div>

                                    <div class="chat-text-left">
                                        <p class="text-semi-muted">
                                            <?=$cd['message']?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
        
        
        
        
          <?php endforeach;
          } ?>
        </datamain> 
        <page_number><?php if(!isset($page_number) || !is_numeric($page_number) || empty($page_number)) $page_number = 0; if(isset($chat_detail) && !empty($chat_detail)) $page_number = $page_number+1; echo $page_number; ?></page_number><totalpage><?php if(isset($total_pages) && is_numeric($total_pages)) echo $total_pages; else echo "0"; ?></totalpage><lastcheater><?php if(isset($lastid) && is_numeric($lastid)) echo $lastid; else echo "0"; ?></lastcheater>
    </div>