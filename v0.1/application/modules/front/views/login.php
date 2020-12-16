   <div class="veen">
      <div class="login-btn splits" style="vertical-align:none !important;text-align:left !important;">
		 <img src="<?php echo STATIC_ADMIN_IMAGE.'eq_smart_log_f1.png' ?>" style="width:40%; margin-left: 5%;">
      </div>
       <div class="rgstr-btn splits">
      </div>
      <div class="wrapper">
            <form id="login" action="<?php echo BASE_URL.'front/submit_login' ?>" method="post">
          <h3>Login</h3>
          <div class="mail">
            <input type="mail" name="txtUserName">
            <label>Username</label>
          </div>
          <div class="passwd">
            <input type="password" name="txtPassword">
            <label>Password</label>
          </div>
          <input type="hidden" value="<?php echo $this->uri->segment(2); ?>" name="id">
          <div class="submit">
            <button type="submit" class="dark" id="submit_btn">Login</button>
          </div>
            </form>
      </div>
    </div>  
  </div>
<script type="text/javascript">
    $(document).off("click", "#submit_btn").on("click", "#submit_btn",function(event){
    event.preventDefault();
        $("#login").submit();
    }); 
</script>
</body>
</html>