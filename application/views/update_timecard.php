<?php

$curTimeofday = date('A', $_SERVER['REQUEST_TIME']);
$curMin = date('i', $_SERVER['REQUEST_TIME']);
$curHour = date('h', $_SERVER['REQUEST_TIME']);

?>
<?php if ( $is_admin_timecard ): ?>

<script type="text/javascript">
  $(document).ready(function() {
    $('select').selectric();

    $(".tklmaln").css({width:$("body").width(),height:$("body").height()});
    $(".tklmaln").click(function(){nwpstkpt();});
    embedegore();
  });

  $(window).resize(embedegore);

  function embedegore(){
    $(".bosdv,.tklmaln").css({width:"100%"});
    $(".rndvds").css({left:($(window).width()-$(".rndvds").width())/2});
  }

  function nwpstkpt(){
    $(".bosdv").html("");
  }

  function npstgndr()
  {
    $.ajax({
      type: 'POST',
      url :'/admin/timecard/save_update_timecard',
      data: $('form#bbform').serialize(),
    })
    .done(function(answer){
       if ( answer.error ){
         notify(answer.error);
         console.log('error: ' + answer.error);
         return;
       }
       location.reload();
    })
    .fail(function(xhr, answer){
       notify(answer);
       console.log('FAIL: ' + answer.error);
    });
  }

  function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
  }

</script>

<?php else: ?>

<script type="text/javascript">
  $(document).ready(function() {
    set_timecard_times();

    $('select').selectric();

    $(".tklmaln").css({width:$("body").width(),height:$("body").height()});
    $(".tklmaln").click(function(){nwpstkpt();});
    embedegore();
  });

  $(window).resize(embedegore);

  function embedegore(){
    $(".bosdv,.tklmaln").css({width:"100%"});
    $(".rndvds").css({left:($(window).width()-$(".rndvds").width())/2});
  }

  function nwpstkpt(){
    $(".bosdv").html("");
  }

  function npstgndr()
  {
    $.ajax({
      type: 'POST',
      url :'/timecard/save_update_timecard',
      data: $('form#bbform').serialize(),
    })
    .done(function(answer){
       if ( answer.error ){
         notify(answer.error);
         console.log('error: ' + answer.error);
         return;
       }
       location.reload();
    })
    .fail(function(xhr, answer){
       notify(answer);
       console.log('FAIL: ' + answer.error);
    });
  }

  function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
  }

</script>

<?php endif; ?>

<div class="tklmaln"></div>
<div class="rndvds trndvds">
  <div class="bslk">Time Card</div>
  <form method="post" name="bbform" id="bbform" action="javascript:npstgndr();" >
    <div class="bbfmaln">
      <input type="hidden" name="tcid" value="<?php echo $tcid; ?>">
      <div class="frm1"><?php echo $wo_id; ?></div>

      <div class="fl yzlr1">MONTH</div>
      <div class="fl yzlr2">DAY</div>
      <div class="fl yzlr3">YEAR</div>
      <div class="t"></div>

      <div class="fl slct1">
        <?php echo $tc_month; ?>
      </div>
      <div class="fl slct2">
        <?php echo $tc_date; ?>
      </div>
      <div class="fl slct3">
        <?php echo $tc_year; ?>
      </div>
      <div class="t"></div>
      <div id="start_time">
        <div class="yzlr4">START TIME</div>
        <div class="fl slct4">
          <?php echo $tc_start_hour; ?>
        </div>
        <div class="fl slct5">
          <?php echo $tc_start_min; ?>
        </div>
        <div class="fl slct6">
          <?php echo $tc_start_pmam; ?>
        </div>
      </div>

      <div class="t"></div>
      <div class="yzlr4">END TIME</div>
      <div class="fl slct4">
        <input type="hidden" value="" name="timecard_hour" id="timecard_hour">
        <span id="timecard_hour_label"></span>
      </div>
      <div class="fl slct5">
        <input type="hidden" value="" name="timecard_min" id="timecard_min">
        <span id="timecard_min_label"></span>
      </div>
      <div class="fl slct6">
        <input type="hidden" value="" name="timecard_pmam" id="timecard_pmam">
        <span id="timecard_pmam_label"></span>
      </div>
      <div class="bzngl t"></div>
      <div class="fr frm4">
        <input type="submit" name="submit" id="submit" class="inptsbt wait-on-submit" value="Send" action="javascript:npstgndr();" />
        <a href="javascript:nwpstkpt();" class="inptgri" >
          Cancel
        </a>
      </div>

      <div class="t"></div>

    </div>
  </form>
</div>
