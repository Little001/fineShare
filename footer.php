	<footer>
		<div class="upFooterBackGround">
			<div class="upFooter">
				<ul>
					<li><a>Registrovat</a></li>
					<li><a>FAQ</a></li>
					<li><a>Právní náležitosti</a></li>
					<li><a>Podmínky užívání</a></li>
					<li><a>Nahlásit soubor</a></li>
					<li><a>Kontakt</a></li>
					<li><a><img src="Images/logo.png"></a></li>
				</ul>
			</div>
		</div>
		<div class="downFooterBackGround">
			<div class="downFooter">
				<span>Provozovatelem serveru je Mediasun Group s.r.o. Všechna práva vyhrazena</span>
			</div>
		</div>
	</footer>
	<input type="hidden" id="message" value="<?php echo $message ?>"/>
	<input type="hidden" id="typeMsg" value="<?php echo $typeMsg ?>"/>
	<?php $conn->close(); ?>
</body>
</html>