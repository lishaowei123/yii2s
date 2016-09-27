<html>
    <head>
        <script type="text/javascript" src="/js/common/jquery-2.2.1.min.js"></script>
        <script type="text/javascript" src="/js/test/qrlogin/jquery.qrcode.min.js"></script>
    </head>
    <body>
        <div id="code"></div>
        <div><a href="http://ding.vguang.com/test/qrlogined?code=<?php echo $result?>" >扫码后点击此处</a></div>
    </body>
    <script>
        $('#code').qrcode("<?php echo 'http://qr.dingtalk.com/action/login?code='.$result; ?>");
    </script>
</html>
