  <script>
	function kill_error(){
		$("#error").empty();
		$("#error").remove();
	}
  </script>
<body>
<div id="error" class="rndvds trndvds" title="Error">
	<div class="bslk">ERROR</div>
  	<div class="bbfmaln">
		<div class="missingTitle">
			<p><?php echo $error; ?></p>
		</div>
		<input type="button" value="close" onclick="kill_error()" class="rnk sae bbsae">
	</div>	
</div>
</body>
