<!doctype html>
<html lang="en-US">
   <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
      <title>Payment Success</title>
      <meta name="robots" content="noindex, nofollow">
      <style>body,div,h1,html,img,p,span{margin:0;padding:0;border:0;font:inherit;vertical-align:baseline;outline:0;-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}body,h1{font-family:'Helvetica Neue',Helvetica,Arial,sans-serif}h1,p{line-height:1.5em}html{height:101%}body{background:#FFFFFF;color:#313131;font-size:62.5%;line-height:1}::selection{background:#a4dcec}::-moz-selection{background:#a4dcec}::-webkit-selection{background:#a4dcec}::-webkit-input-placeholder{color:#ccc;font-style:italic}:-moz-placeholder{color:#ccc;font-style:italic}::-moz-placeholder{color:#ccc;font-style:italic}:-ms-input-placeholder{color:#ccc!important;font-style:italic}img{border:0;width:40px}h1{font-size:2.5em;letter-spacing:-.05em;margin-bottom:20px;padding:.1em 0;color:#444;position:relative;overflow:hidden;white-space:nowrap;text-align:center}h1:after,h1:before{content:"";position:relative;display:inline-block;width:50%;height:1px;vertical-align:middle;background:#f0f0f0}#content,.notify{background:#fff;display:block,text-align:center}h1:before{left:-.5em;margin:0 0 0 -50%}h1:after{left:.5em;margin:0 -50% 0 0}p{display:block;font-size:1.35em;margin-bottom:22px}#w{display:block;margin:0 auto;padding-top:30px}#content{width:100%;padding:25px 20px 35px}.notify{padding:12px 18px;color:#4D5761;max-width:400px;margin:0 auto 20px;cursor:pointer;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;text-align:center;box-shadow:rgba(0,0,0,.3) 0 1px 2px 0}.notify h1{margin-bottom:6px}.successbox h1{color:#4D5761}.successbox h1:after,.successbox h1:before{background:#DDDDDD}.notify .alerticon{display:block;text-align:center;margin-bottom:10px}</style>
   </head>
   <body>
      <div id="w">
         <div id="content">
            <div class="notify successbox">
               <h1><?php if(isset($title)){ echo $title; } ?></h1> <span class="alerticon"><?php if(isset($title) && $title == 'Success') { echo '<img src="/static/front/images/check.png" alt="iconsuccess">'; } else { echo '<img src="/static/front/images/error.png" alt="iconsuccess">';} ?></span> 
               <p><?php if(isset($message)){ echo $message; } ?> </p>
            </div>
         </div>
      </div>
   </body>
</html>