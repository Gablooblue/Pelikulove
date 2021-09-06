<script type="text/javascript">

	$('.btn-gen-code').click(function(event) {
		var newcode1;
		var newcode2;

		do {			
			var code1 = [];
			var code2 = [];
			var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz01234567890123456789';
			var charactersLength = characters.length;

			while(code1.length < 25){
				var randomChar1 = characters.charAt(Math.floor(Math.random() * charactersLength));
				if(code1.indexOf(randomChar1) === -1) code1.push(randomChar1);
			}
			
			newcode1 = "B1-" + code1.join('');

			while(code2.length < 25){
				var randomChar2 = characters.charAt(Math.floor(Math.random() * charactersLength));
				if(code2.indexOf(randomChar2) === -1) code2.push(randomChar2);
			}

			newcode2 = "B2-" + code2.join('');

		} while (checkIfDuplicate(code2.join('')) == true || checkIfDuplicate(code1.join('')) == true)
			
		document.getElementById('code1').value = newcode1;
		document.getElementById('code2').value = newcode2;

		// Returns true if Code is Duplicate
		function checkIfDuplicate (code) {
			var giftcodes = {!! $giftCodes !!};
			var bool = false;
			
			// giftcodes = JSON.parse(giftcodes);
					
			for (var i=0; i<giftcodes.length; i++) {

				var uniqueCode = giftcodes[i].code.split("-");

				// console.log(uniqueCode);
				if (uniqueCode[1] == code) {
					bool = true;
				}
			}		

			return bool;
		}
  	});

</script>
