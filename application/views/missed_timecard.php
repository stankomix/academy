<?php


//<script src="/js/add_timecard.js"></script>

?>

<?php if( !$more_than_one ): ?>

<div class="tklmaln"></div>
<div class="rndvds trndvds">
  <div class="bslk">Missed Time Card</div>
  <div class="bbfmaln">
<div class="missingTitle">
    You did not submit a time card yesterday.
</div>
<div class="missingTitle">
Please select a reason: <?php echo $select_reason; ?>
</div>
    <div class="t"></div>
<div>
<?php echo $select_reason_submit; ?>
</div>
  </div>
</div>

<?php else: ?>

<div class="tklmaln"></div>
<div class="rndvds trndvds">
  <div class="bslk">Missed Time Cards</div>
  <div class="bbfmaln">
<div class="missingTitle">
    You did not submit more than one time card
</div>
<div class="missingTitle">
Please submit reasons why they were missed
</div>
    <div class="t"></div>
<div>

<a class="rnk sae" href="/timecard/missed_cards">Submit</a>

</div>
  </div>
</div>

<?php endif; ?>
