<!-- Google ANALYTICS -->
<?php foreach($js_scripts as $script){ ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<script type="text/javascript">
  _udn = "<?php echo $_SERVER['HTTP_HOST']; ?>";
   
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo $google_analytics_code; ?>']);
  _gaq.push(['_setDomainName', '<?php echo $_SERVER['HTTP_HOST']; ?>']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })(); 
</script>
<!-- Google ANALYTICS -->
