
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>chat_css.css"    id="maincss">
    <style type="text/css">
    .counter {
        background-color: #bdc3c7;
        width: 24px;
        border-radius: 32px;
        font-size: 12px;
        float: right;
        color: #34495e;
        text-align: center;
        height: 22px;
        padding-top: 2px;
        font-weight: bold;
        margin-top: 4px;
    }
    </style>
  
    <div id="frame">
        <div id="sidepanel">
            <div id="profile">
                <div class="wrap">
                    <img id="profile-img" src="<?=$user_image?>" class="online" alt="" />
                    <p><?=$user_name?></p>
                  
                    <div id="expanded">
                        <label for="twitter"><i class="fa fa-facebook fa-fw" aria-hidden="true"></i></label>
                        <input name="twitter" type="text" value="mikeross" />
                        <label for="twitter"><i class="fa fa-twitter fa-fw" aria-hidden="true"></i></label>
                        <input name="twitter" type="text" value="ross81" />
                        <label for="twitter"><i class="fa fa-instagram fa-fw" aria-hidden="true"></i></label>
                        <input name="twitter" type="text" value="mike.ross" />
                    </div>
                </div>
            </div>
            <div id="search">
                
            </div>
            <div id="contacts">
                <ul id="myInput">
                <?php if(isset($left_panel) && !empty($left_panel)) {
                  foreach ($left_panel as $key => $lp): ?>
                    <li class="contact chat_detail" list="chating" chating="<?=$lp['id']?>" tracking="<?=$lp['trackig_id']?>"  next_chat="<?=$lp['next_chat']?>" chatimage ="<?=$lp['image']?>" cheater ="<?=$lp['name']?>" cheatertype="<?=$lp['type']?>" lastcheater="<?=$lp['last_chat'];?>" counter="<?=$lp['counter']?>">
                        <div class="wrap">
                            <?php if($lp['type'] == 'user') {?>
                            <span class="contact-status <?php  $online_status = 'away'; if(isset($lp['is_online']) && !empty($lp['is_online'])) {  if($lp['is_online'] == true) $online_status='online';} echo $online_status;?>"></span>
                            <?php } 
                            if(!empty($lp['counter'])) { ?>
                                <div class="counter"><?=$lp['counter']?></div>
                            <?php } ?>
                            <img src="<?=$lp['image']?>" alt="" />
                            <div class="meta">
                                <p class="name"><?=$lp['name']?></p>
                                <p class="preview"><?=$lp['last_message']?></p>
                            </div>
                        </div>
                    </li>
                <?php
                  endforeach;
                      } ?>
                </ul>
            </div>
            
        </div>
        <div class="content">
            <div class="contact-profile">
                <img class="contact-profile-image"  src=""/>
                <p class="contact-profile-name"></p>
                
            </div>
            <div class="messages">
                <ul class="heightt" style="float: left;width: 100%">
                </ul>
            </div>
            <div class="message-input"  style="display: none;">
                <div class="wrap">
                <input type="text" placeholder="Write your message..." />
                <button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>
  <script src='//production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script>
  <script>
    $("#profile-img").click(function() {
        $("#status-options").toggleClass("active");
    });

    $(".expand-button").click(function() {
      $("#profile").toggleClass("expanded");
        $("#contacts").toggleClass("expanded");
    });

    $("#status-options ul li").click(function() {
        $("#profile-img").removeClass();
        $("#status-online").removeClass("active");
        $("#status-away").removeClass("active");
        $("#status-busy").removeClass("active");
        $("#status-offline").removeClass("active");
        $(this).addClass("active");
        
        if($("#status-online").hasClass("active")) {
            $("#profile-img").addClass("online");
        } else if ($("#status-away").hasClass("active")) {
            $("#profile-img").addClass("away");
        } else if ($("#status-busy").hasClass("active")) {
            $("#profile-img").addClass("busy");
        } else if ($("#status-offline").hasClass("active")) {
            $("#profile-img").addClass("offline");
        } else {
            $("#profile-img").removeClass();
        };
        
        $("#status-options").removeClass("active");
    });
    storeRequest = null;
    function newMessage() {
        /*createdAt: firebase.firestore.Timestamp.fromDate(new Date(data.createdAt)),*/
        message = $(".message-input input").val();
        if($.trim(message) == '') {
            return false;
        }
        storeRequest= $.ajax({
            type: "POST",  
            url: '<?php echo ADMIN_BASE_URL;?>chat/store_message',  
            data: {'chating':$(".contact-profile-image").attr("chating"),'cheatertype':$(".contact-profile-image").attr("cheatertype"),'message':message},
            beforeSend : function()    {           
              if(storeRequest != null) {
                  storeRequest.abort();
              }
            },
            success: function(data) {
                console.log(data);
                if(data.status == true) {
                    firebase.firestore().collection('/<?=DEFAULT_FCM_PROJECT?>/<?=DEFAULT_DOCUMENT_NAME?>/'+$(".contact-profile-image").attr("tracking")).doc().set({
                        chat_id : data.chat_id,
                        createdAt: firebase.firestore.Timestamp.fromDate(new Date()),
                        text: data.text,
                        user_id: data.user_id,
                        user_name:data.user_name,
                        user_pic: data.user_image,
                    });
                }
            }
        });
        /*$('<li class="replies"><img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>' + message + '</p></li>').appendTo($('.messages ul'));*/
        $('.message-input input').val(null);
        $('.contact.active .preview').html('<span>You: </span>' + message);
    };


    // Your web app's Firebase configuration
    
    $('.submit').click(function() {
      newMessage();
    });

    $(window).on('keydown', function(e) {
      if (e.which == 13) {
        newMessage();
        return false;
      }
    });
    
    citycurrentRequest = null;
    $("#contacts>ul>li[list=chating]").each(function(){
        tracking=$(this).attr('tracking')
        getRealtimeUpdates(tracking);
    })
    // getRealtimeUpdates('G_3');
    function clicking(){
    $(document).off('click', '.chat_detail').on('click', '.chat_detail', function(e){
        $('.messages ul').empty();
        $("#contacts>ul>li.active").removeClass("active");
        $(".message-input").css("display", "inline");
        $this = $(this);
        $this.addClass("active");
        var cheater = $this.attr('cheater');
        var chatimage = $this.attr('chatimage');
        var next_chat = $this.attr('next_chat');
        var tracking = $this.attr('tracking');
        var chating = $this.attr('chating');
        var cheatertype = $this.attr('cheatertype');
        var lastcheater = $this.attr('lastcheater');
        if(next_chat != '1') 
            $(".message-input").css("display", "none");
        $(".contact-profile-image").attr("src",chatimage);
        $(".contact-profile-image").attr("chating",chating);
        $(".contact-profile-image").attr("cheatertype",cheatertype);
        $(".contact-profile-image").attr("tracking",tracking);
        $(".contact-profile-image").attr("lastcheater",lastcheater);
        $(".contact-profile-image").attr("page_number",'2');
        $(".contact-profile-name").text(cheater);
        $this.attr('counter',"0");
        $this.find('.counter').remove();
        getRealtimeUpdates(tracking);
        $.ajax({
            type: "POST",  
            url: '<?php echo ADMIN_BASE_URL;?>chat/get_chat_messages',  
            data: {'page_number':'1','chating':chating,'limit':'<?=$limit?>','cheatertype':cheatertype,'lastcheater':parseInt(lastcheater) + 1000000},
            success: function(result) {
                var datamain = $(result).find('datamain').html();
                $(".messages ul").append(datamain);
                $(".messages").scrollTop($('.heightt').height());
                clicking();
            }
        });
      
    });
    }
    clicking();
    function getRealtimeUpdates(tracking){
        var user = '<?=$this->session->userdata['user_data']['user_id']?>';
        var chat_id = parseInt( $("#contacts>ul>li[tracking="+tracking+"]").attr('lastcheater'));
        var chatRef = firebase.firestore().collection('/<?=DEFAULT_FCM_PROJECT?>/<?=DEFAULT_DOCUMENT_NAME?>/'+tracking).where("chat_id",">",chat_id).limit(5);
        chatRef.onSnapshot(function(querySnapshot){
            querySnapshot.forEach(function(doc) {
                if($(".contact-profile-image").attr("tracking") == tracking) {
                    if(doc.data().chat_id > $("#contacts>ul>li[tracking="+tracking+"]").attr('lastcheater')){
                        $(".contact-profile-image").attr("lastcheater",doc.data().chat_id);
                        $("#contacts>ul>li[tracking="+tracking+"]").attr("lastcheater",doc.data().chat_id);
                        var classes = "replies";
                        if(user != doc.data().user_id)
                            classes = "sent";
                        $('<li class="'+classes+'"><img src="'+doc.data().user_pic+'" alt="" /><p>' + doc.data().text + '</p></li>').appendTo($('.messages ul'));
                        $('.contact.active .preview').html('<span>You: </span>' + doc.data().text);
                        $(".messages").scrollTop($('.heightt').height());
                        if(user != doc.data().user_id) {
                            $.ajax({
                                type: "POST",  
                                url: '<?php echo ADMIN_BASE_URL;?>chat/change_message_status',  
                                data: {'chat_id':doc.data().chat_id},
                                success: function(result) {
                                }
                            });
                        }
                    }
                } else {
                    if(doc.data().chat_id > $("#contacts>ul>li[tracking="+tracking+"]").attr('lastcheater')){
                        selector = $("#contacts>ul>li[tracking="+tracking+"]");
                        counter = parseInt(selector.attr('counter'))+1;
                        selector.attr('counter',counter);
                        if(!$("#contacts>ul>li[tracking="+tracking+"]").find(".counter").length){
                            $("#contacts>ul>li[tracking="+tracking+"]").find('.wrap').prepend('<div class="counter"></div>')
                        }
                        $("#contacts>ul>li[tracking="+tracking+"]").parent().prepend($("#contacts>ul>li[tracking="+tracking+"]"))
                        $("#contacts>ul>li[tracking="+tracking+"]").attr("lastcheater",doc.data().chat_id);
                        $("#contacts>ul>li[tracking="+tracking+"]").find('.counter').html(counter);
                        $("#contacts>ul>li[tracking="+tracking+"]").find('.preview').html(doc.data().text);

                    }
                }
                getRealtimeUpdates(tracking);
            });
        });
    }
    $('.messages').scroll(function() {
        if($('.messages').scrollTop() == 0) {
            var chating = $(".contact-profile-image").attr("chating");
            var cheatertype = $(".contact-profile-image").attr("cheatertype");
            var page_number = $(".contact-profile-image").attr("page_number");
            var lastcheater = $(".contact-profile-image").attr("lastcheater");
            citycurrentRequest= $.ajax({
                type: "POST",  
                url: '<?php echo ADMIN_BASE_URL;?>chat/get_chat_messages',  
                data: {'page_number':page_number,'chating':chating,'limit':'<?=$limit?>','cheatertype':cheatertype,'lastcheater':lastcheater},
                beforeSend : function()    {           
                  if(citycurrentRequest != null) {
                      citycurrentRequest.abort();
                  }
                },
                success: function(result) {
                    var datamain = $(result).find('datamain').html();
                    $(".messages ul").prepend(datamain);
                    $(".contact-profile-image").attr("page_number",$(result).find('page_number').text());
                }
            });
            /*$('.loader').remove()*/
        /*$('.messages').prepend('<div class="loader" style="text-align:center;position:fixed;width:75%"><image width="30px" src="<?=STATIC_FRONT_IMAGE."loader.gif"?>"></div>');*/
               /*$('.messages ul').prepend('<li class="replies"><img src="http://localhost/qa/uploads/outlet-user/actual-images/custom-image-1687954f1-default-welcomer.png" alt=""><p>hello</p></li>')*/
        }
    });
  </script>