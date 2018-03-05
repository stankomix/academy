<div class="bosdv"></div>

<div style="display:none;" id="actionConfirmation">
	<div class="rndvds trndvds">
		<div class="bslk" id="confirmationTitle"></div>

        <div class="bbfmaln">

        	<div class="missingTitle"></div>
            <p id="confirmationMessage"> </p>

            <div class="t"></div>

            <div class="fr frm4">

                <input type="button" class="inptsbt dialog-button" value="Ok" />
                <a href="javascript:$('#actionConfirmation').hide();" class="inptgri" >
                    Cancel
                </a>
            </div>

            <div class="t"></div>

        </div>

	</div>
</div>

<div style="display:none;" id="overlay">
	<div class="rndvds trndvds">
		<div class="bslk" id="overlayTitle"></div>

		<div class="bbfmaln">
			<div class="missingTitle" id="overlayMessage"></div>
			<div class="t"></div>
			<div>
				<button onclick="closeOverlay()" class="rnk sae bbsae wait-on-submit">Ok</button>
			</div>
		</div>
	</div>
</div>

<div style="display:none;" id="actionSelection">
	<div class="rndvds trndvds">
		<div class="bslk" id="selectionTitle"></div>

        <div class="bbfmaln">

        	<div class="missingTitle"></div>
            <p id="selectionMessage"> </p>

            <div class="t"></div>

            <div class="fr frm4">

                <input type="button" class="inptsbt dialog-button wait-on-submit" value="Yes" />
                <input type="button" class="inptgri dialog-button wait-on-submit" value="No" />
            </div>

            <div class="t"></div>

        </div>

	</div>
</div>