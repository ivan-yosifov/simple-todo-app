		<?php
		$current_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); 
		if($current_page == 'add.php' || $current_page == 'update.php'):
		?>
		<script>
      <?php if(isset($date)): ?>
      var d = document.getElementById('date');
      d.value = '<?php echo $date; ?>';     
      <?php endif; ?>
    </script>
		<?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
  </body>
</html>
<?php
if(isset($_SESSION['msg'])){
  unset($_SESSION['msg']);
}
?>