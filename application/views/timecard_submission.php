<?php if ( $is_admin_timecard ): ?>
    <script src="/js/turnin_timecard_admin.js"></script>

<?php else: ?>
    <script src="/js/turnin_timecard.js"></script>

<?php endif; ?>

<div class="tklmaln"></div>
<div class="rndvds trndvds">
    <div class="bslk">Turn in Timecard</div>

    <form method="post" id="timecardTurnInForm" action="javascript:;">
        <div class="bbfmaln">

            <div class="missingTitle">
                Read the below before continuing: 
            </div>
            <div class="t"></div>
            
            <p>
                Accurately recording hours worked is the responsibility of every employee. Federal and state law requires COMMERCIAL FIRE PROTECTION to keep an accurate record of hours worked in order to calculate an employees pay and benefits. Falsification of time cards may be grounds for termination. I, the undersigned employee, certify this to be a true and accurate record of my working time for the period above. I further certify that I have had the opportunity to take my required rest and meal period(s).
            </p>

            <div class="t"></div>

            <div class="frm1">
                <input type="text" name="signature" id="signature" class="bbfrminpt" placeholder="Please sign with your full name" />
            </div>

            <div class="fr frm4">

                <input type="submit" class="inptsbt wait-on-submit" value="Submit" />
                <a href="javascript:closeDialog();" class="inptgri" >
                    Cancel
                </a>
            </div>

            <div class="t"></div>
        </div>
    </form>
</div>
